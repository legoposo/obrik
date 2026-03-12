<?php

use App\Models\Builder;
use App\Models\Client;
use App\Models\Contract;
use App\Models\Development;
use App\Models\FinancialEntry;
use App\Models\Unit;
use App\Models\User;
use App\Models\Work;

test('authenticated users can open the reports hub and dedicated report pages', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $this->get(route('reports.index'))
        ->assertOk()
        ->assertSee('Relatorio de Obras')
        ->assertSee('Relatorio Financeiro')
        ->assertSee('Relatorio de Clientes')
        ->assertSee('Relatorio de Empreendimentos');

    $this->get(route('reports.works'))->assertOk();
    $this->get(route('reports.financial'))->assertOk();
    $this->get(route('reports.clients'))->assertOk();
    $this->get(route('reports.developments'))->assertOk();
});

test('works report filters by status and responsible', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $builderOne = Builder::create([
        'name' => 'Atlas Engenharia',
        'responsible' => 'Ana Lima',
    ]);

    $builderTwo = Builder::create([
        'name' => 'Brisa Construtora',
        'responsible' => 'Bruno Costa',
    ]);

    $clientOne = Client::create([
        'construtora_id' => $builderOne->id,
        'name' => 'Cliente Alpha',
    ]);

    $clientTwo = Client::create([
        'construtora_id' => $builderTwo->id,
        'name' => 'Cliente Beta',
    ]);

    Work::create([
        'client_id' => $clientOne->id,
        'name' => 'Obra Alpha',
        'status' => 'planning',
        'start_date' => '2026-01-10',
        'budget' => 150000,
    ]);

    Work::create([
        'client_id' => $clientTwo->id,
        'name' => 'Obra Beta',
        'status' => 'canceled',
        'start_date' => '2026-02-10',
        'budget' => 90000,
    ]);

    $this->get(route('reports.works', [
        'status' => 'planning',
        'responsible' => 'Ana',
    ]))
        ->assertOk()
        ->assertSee('Obra Alpha')
        ->assertDontSee('Obra Beta');
});

test('financial report shows aggregated totals', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $client = Client::create([
        'name' => 'Cliente Financeiro',
    ]);

    $work = Work::create([
        'client_id' => $client->id,
        'name' => 'Obra Financeira',
        'status' => 'planning',
    ]);

    FinancialEntry::create([
        'work_id' => $work->id,
        'client_id' => $client->id,
        'type' => 'income',
        'category' => 'Recebimento',
        'description' => 'Entrada principal',
        'amount' => 10000,
        'due_date' => '2026-03-01',
        'status' => 'paid',
    ]);

    FinancialEntry::create([
        'work_id' => $work->id,
        'client_id' => $client->id,
        'type' => 'expense',
        'category' => 'Material',
        'description' => 'Compra de insumos',
        'amount' => 3500,
        'due_date' => '2026-03-05',
        'status' => 'paid',
    ]);

    $this->get(route('reports.financial'))
        ->assertOk()
        ->assertSee('R$ 10.000,00')
        ->assertSee('R$ 3.500,00')
        ->assertSee('R$ 6.500,00');
});

test('clients report derives customer status from contracts', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $builder = Builder::create([
        'name' => 'Nova Casa',
    ]);

    $development = Development::create([
        'builder_id' => $builder->id,
        'name' => 'Residencial Horizonte',
        'type' => 'apartments',
        'city' => 'Bauru',
        'state' => 'SP',
        'status' => 'planning',
    ]);

    $unit = Unit::create([
        'development_id' => $development->id,
        'identifier' => 'A-101',
        'type' => 'Apartamento',
        'status' => 'available',
    ]);

    $lead = Client::create([
        'name' => 'Lead sem contrato',
        'email' => 'lead@example.com',
    ]);

    $customer = Client::create([
        'name' => 'Cliente com contrato',
        'email' => 'cliente@example.com',
    ]);

    Contract::create([
        'development_id' => $development->id,
        'unit_id' => $unit->id,
        'client_id' => $customer->id,
        'contract_number' => 'CTR-2026-001',
        'sale_date' => '2026-03-01',
        'contract_date' => '2026-03-02',
        'unit_price' => 250000,
        'discount' => 10000,
        'negotiated_value' => 240000,
        'down_payment' => 40000,
        'financed_amount' => 200000,
        'installments_count' => 120,
        'status' => 'ativo',
    ]);

    $this->get(route('reports.clients', [
        'status' => 'client',
    ]))
        ->assertOk()
        ->assertSee('Cliente com contrato')
        ->assertSee('Residencial Horizonte')
        ->assertDontSee('Lead sem contrato');
});
