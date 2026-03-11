<?php

use App\Models\Builder;
use App\Models\Client;
use App\Models\Contract;
use App\Models\Development;
use App\Models\Unit;
use App\Support\ContractPrintData;
use App\Support\PortugueseCurrencyWriter;
use Illuminate\Support\Carbon;

it('writes negotiated values in portuguese currency words', function () {
    expect(PortugueseCurrencyWriter::toWords(450000))->toBe('quatrocentos e cinquenta mil reais');
    expect(PortugueseCurrencyWriter::toWords(1500.25))->toBe('mil e quinhentos reais e vinte e cinco centavos');
});

it('renders the contract template with registered data', function () {
    $builder = new Builder([
        'name' => 'Quality Construtora Ltda.',
        'cnpj' => '12.345.678/0001-99',
    ]);

    $client = new Client([
        'name' => 'Joao Carlos da Silva',
        'cpf' => '123.456.789-00',
        'address' => 'Rua das Flores, 10',
        'city' => 'Bauru',
        'state' => 'SP',
    ]);

    $development = new Development([
        'name' => 'Residencial Aurora',
        'type' => 'apartments',
        'address' => 'Rua Antonio Gobette, 240',
        'city' => 'Bauru',
        'state' => 'SP',
    ]);
    $development->setRelation('builder', $builder);

    $unit = new Unit([
        'identifier' => '402',
        'floor' => '4',
        'type' => 'Apartamento',
        'status' => 'sold',
    ]);

    $contract = new Contract([
        'contract_number' => '2026-001',
        'contract_date' => '2026-03-15',
        'sale_date' => '2026-03-15',
        'unit_price' => 450000,
        'discount' => 0,
        'negotiated_value' => 450000,
        'down_payment' => 50000,
        'financed_amount' => 400000,
        'installments_count' => 36,
        'status' => 'ativo',
    ]);
    $contract->setRelation('client', $client);
    $contract->setRelation('development', $development);
    $contract->setRelation('unit', $unit);

    $document = ContractPrintData::from($contract);
    $html = view('contracts.pdf', compact('contract', 'document'))->render();
    $fullDate = Carbon::parse('2026-03-15')->locale('pt_BR')->translatedFormat('d \\d\\e F \\d\\e Y');
    $fourthFloor = 'Andar:</strong> '.html_entity_decode('4&ordm;', ENT_QUOTES, 'UTF-8');

    expect($html)->toContain('Contrato n&ordm;:</strong> 2026-001')
        ->toContain($fullDate)
        ->toContain('Quality Construtora Ltda.')
        ->toContain('Joao Carlos da Silva')
        ->toContain('Residencial Aurora')
        ->toContain($fourthFloor)
        ->toContain('R$ 450.000,00 (quatrocentos e cinquenta mil reais)')
        ->toContain('Situa&ccedil;&atilde;o do contrato: Ativo')
        ->toContain('comarca de <strong>Bauru/SP</strong>');
});