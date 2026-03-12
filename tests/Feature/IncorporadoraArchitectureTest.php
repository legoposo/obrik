<?php

use App\Models\Builder;
use App\Models\Client;
use App\Models\Communication;
use App\Models\Contract;
use App\Models\Development;
use App\Models\DevelopmentPhoto;
use App\Models\DevelopmentStage;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

function createBuilderForIncorporadoraTests(): Builder
{
    return Builder::create([
        'name' => 'Incorporadora Horizonte',
        'city' => 'Bauru',
        'state' => 'SP',
        'responsible' => 'Carla Martins',
    ]);
}

function createDevelopmentForIncorporadoraTests(): Development
{
    $builder = createBuilderForIncorporadoraTests();

    return Development::create([
        'builder_id' => $builder->id,
        'name' => 'Residencial Aurora',
        'type' => 'apartments',
        'city' => 'Bauru',
        'state' => 'SP',
        'address' => 'Rua das Flores, 120',
        'location' => 'Bauru - Centro',
        'status' => 'em_obras',
        'launch_date' => '2026-01-10',
        'start_date' => '2026-01-10',
        'expected_delivery' => '2026-12-20',
        'expected_delivery_date' => '2026-12-20',
        'description' => 'Empreendimento piloto para os testes de arquitetura.',
        'notes' => 'Hub central da incorporadora.',
    ]);
}

function createUnitForIncorporadoraTests(Development $development, array $overrides = []): Unit
{
    return Unit::create(array_merge([
        'development_id' => $development->id,
        'identifier' => '101',
        'unit_number' => '101',
        'block' => 'Torre A',
        'block_or_tower' => 'Torre A',
        'type' => 'Apartamento 2 dormitorios',
        'private_area' => 68,
        'total_area' => 68,
        'area' => 68,
        'bedrooms' => 2,
        'parking_spaces' => 1,
        'price' => 320000,
        'status' => 'disponivel',
    ], $overrides));
}

test('authenticated users can view the development hub with linked modules', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $development = createDevelopmentForIncorporadoraTests();

    $availableUnit = createUnitForIncorporadoraTests($development, [
        'identifier' => '101',
        'unit_number' => '101',
        'status' => 'disponivel',
    ]);

    $reservedUnit = createUnitForIncorporadoraTests($development, [
        'identifier' => '102',
        'unit_number' => '102',
        'status' => 'reservada',
    ]);

    $client = Client::create([
        'name' => 'Mariana Souza',
        'email' => 'mariana@example.com',
        'phone' => '14999998888',
        'status' => 'comprador',
        'document' => '123.456.789-00',
    ]);

    Contract::create([
        'development_id' => $development->id,
        'unit_id' => $reservedUnit->id,
        'client_id' => $client->id,
        'contract_number' => 'OBR-TESTE-1',
        'sale_date' => '2026-02-10',
        'contract_date' => '2026-02-10',
        'value' => 330000,
        'unit_price' => 330000,
        'discount' => 0,
        'negotiated_value' => 330000,
        'down_payment' => 0,
        'financed_amount' => 0,
        'installments_count' => 0,
        'status' => 'reserva',
    ]);

    DevelopmentStage::create([
        'development_id' => $development->id,
        'stage_name' => 'Fundacao',
        'status' => 'concluido',
        'finished_date' => '2026-02-20',
    ]);

    DevelopmentStage::create([
        'development_id' => $development->id,
        'stage_name' => 'Estrutura',
        'status' => 'pendente',
    ]);

    Communication::create([
        'development_id' => $development->id,
        'title' => 'Atualizacao de marco',
        'message' => 'A obra concluiu a fase de fundacao.',
        'type' => 'atualizacao_obra',
        'created_at' => now(),
    ]);

    DevelopmentPhoto::create([
        'development_id' => $development->id,
        'title' => 'Vista da fachada',
        'description' => 'Primeiros registros do canteiro.',
        'date' => '2026-02-18',
        'image_path' => 'development-photos/teste.jpg',
    ]);

    $this->get(route('developments.show', $development))
        ->assertOk()
        ->assertSee('Hub operacional do empreendimento')
        ->assertSee($development->name)
        ->assertSee('Reservas / contratos')
        ->assertSee('50%')
        ->assertSee('Fotos da obra')
        ->assertSee($availableUnit->unit_number);
});

test('creating a reservation syncs the unit status', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $development = createDevelopmentForIncorporadoraTests();
    $unit = createUnitForIncorporadoraTests($development);
    $client = Client::create([
        'name' => 'Paulo Neri',
        'status' => 'interessado',
    ]);

    $this->post(route('contracts.store'), [
        'development_id' => $development->id,
        'unit_id' => $unit->id,
        'client_id' => $client->id,
        'value' => 350000,
        'contract_date' => '2026-03-10',
        'status' => 'reserva',
        'notes' => 'Reserva inicial da unidade.',
    ])->assertRedirect(route('contracts.index', ['development_id' => $development->id]));

    $contract = Contract::first();

    expect($contract)->not->toBeNull();
    expect($contract->status)->toBe('reserva');
    expect((float) $contract->value)->toBe(350000.0);
    expect($unit->fresh()->status)->toBe('reservada');
});

test('development stages can be created and concluded from the nested module', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $development = createDevelopmentForIncorporadoraTests();

    $this->post(route('developments.stages.store', $development), [
        'stage_name' => 'Alvenaria',
        'status' => 'em_andamento',
        'start_date' => '2026-03-01',
        'expected_date' => '2026-04-15',
        'responsible' => 'Equipe estrutural',
        'notes' => 'Etapa iniciada sem impedimentos.',
    ])->assertRedirect(route('developments.stages.index', $development));

    $stage = DevelopmentStage::first();

    expect($stage)->not->toBeNull();
    expect($stage->stage_name)->toBe('Alvenaria');

    $this->patch(route('developments.stages.status', [$development, $stage]), [
        'status' => 'concluido',
    ])->assertRedirect(route('developments.stages.index', $development));

    $stage->refresh();

    expect($stage->status)->toBe('concluido');
    expect($stage->finished_date)->not->toBeNull();

    $this->get(route('developments.stages.index', $development))
        ->assertOk()
        ->assertSee('100% da obra concluida');
});

test('communications and photos can be managed inside the development hub', function () {
    Storage::fake('public');

    $user = User::factory()->create();
    $this->actingAs($user);

    $development = createDevelopmentForIncorporadoraTests();

    $this->post(route('developments.communications.store', $development), [
        'title' => 'Entrega de documento',
        'message' => 'Disponibilizamos um novo documento para os clientes.',
        'type' => 'documento',
    ])->assertRedirect(route('developments.communications.index', $development));

    $this->post(route('developments.photos.store', $development), [
        'title' => 'Fachada norte',
        'description' => 'Pintura externa em andamento.',
        'date' => '2026-03-05',
        'image' => UploadedFile::fake()->createWithContent('fachada.png', base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAusB9oNcamUAAAAASUVORK5CYII=')),
    ])->assertRedirect(route('developments.photos.index', $development));

    $photo = DevelopmentPhoto::first();

    expect($photo)->not->toBeNull();
    Storage::disk('public')->assertExists($photo->image_path);

    $this->get(route('developments.communications.index', $development))
        ->assertOk()
        ->assertSee('Entrega de documento')
        ->assertSee('Documento');

    $this->get(route('developments.photos.index', $development))
        ->assertOk()
        ->assertSee('Fachada norte');
});