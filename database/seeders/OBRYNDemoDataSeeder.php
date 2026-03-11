<?php

namespace Database\Seeders;

use App\Models\Builder;
use App\Models\Client;
use App\Models\Contract;
use App\Models\Development;
use App\Models\Unit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OBRYNDemoDataSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            $builder = Builder::updateOrCreate(
                ['cnpj' => '12.345.678/0001-90'],
                [
                    'name' => 'OBRYN Construtora e Incorporadora',
                    'email' => 'contato@obryn.com.br',
                    'phone' => '(14) 99999-0001',
                    'city' => 'Bauru',
                    'state' => 'SP',
                    'address' => 'Av. das Construtoras, 1200',
                    'responsible' => 'Marina Albuquerque',
                ]
            );

            $developmentRows = [
                ['name' => 'Residencial Aurora', 'type' => 'apartments', 'city' => 'Bauru', 'state' => 'SP', 'status' => 'in_progress'],
                ['name' => 'Jardins do Lago', 'type' => 'houses', 'city' => 'Bauru', 'state' => 'SP', 'status' => 'planning'],
                ['name' => 'Vista Nobre', 'type' => 'apartments', 'city' => 'Marília', 'state' => 'SP', 'status' => 'in_progress'],
                ['name' => 'Parque das Palmeiras', 'type' => 'houses', 'city' => 'Jaú', 'state' => 'SP', 'status' => 'completed'],
                ['name' => 'Reserva Central', 'type' => 'apartments', 'city' => 'Botucatu', 'state' => 'SP', 'status' => 'paused'],
                ['name' => 'Bosque Imperial', 'type' => 'houses', 'city' => 'Sorocaba', 'state' => 'SP', 'status' => 'in_progress'],
                ['name' => 'Solar do Vale', 'type' => 'apartments', 'city' => 'Lins', 'state' => 'SP', 'status' => 'planning'],
                ['name' => 'Essenza Home', 'type' => 'houses', 'city' => 'Ourinhos', 'state' => 'SP', 'status' => 'completed'],
                ['name' => 'Mirante Prime', 'type' => 'apartments', 'city' => 'Avaré', 'state' => 'SP', 'status' => 'in_progress'],
                ['name' => 'Terras do Horizonte', 'type' => 'houses', 'city' => 'Assis', 'state' => 'SP', 'status' => 'planning'],
            ];

            $clientRows = [
                ['name' => 'Leonardo Moraes', 'email' => 'leonardo.moraes@exemplo.com', 'phone' => '(14) 99111-1001', 'cpf' => '111.222.333-01'],
                ['name' => 'Camila Fernandes', 'email' => 'camila.fernandes@exemplo.com', 'phone' => '(14) 99111-1002', 'cpf' => '111.222.333-02'],
                ['name' => 'Roberto Siqueira', 'email' => 'roberto.siqueira@exemplo.com', 'phone' => '(14) 99111-1003', 'cpf' => '111.222.333-03'],
                ['name' => 'Patricia Lima', 'email' => 'patricia.lima@exemplo.com', 'phone' => '(14) 99111-1004', 'cpf' => '111.222.333-04'],
                ['name' => 'Gustavo Nogueira', 'email' => 'gustavo.nogueira@exemplo.com', 'phone' => '(14) 99111-1005', 'cpf' => '111.222.333-05'],
                ['name' => 'Fernanda Castro', 'email' => 'fernanda.castro@exemplo.com', 'phone' => '(14) 99111-1006', 'cpf' => '111.222.333-06'],
                ['name' => 'Thiago Azevedo', 'email' => 'thiago.azevedo@exemplo.com', 'phone' => '(14) 99111-1007', 'cpf' => '111.222.333-07'],
                ['name' => 'Aline Ribeiro', 'email' => 'aline.ribeiro@exemplo.com', 'phone' => '(14) 99111-1008', 'cpf' => '111.222.333-08'],
                ['name' => 'Marcelo Prado', 'email' => 'marcelo.prado@exemplo.com', 'phone' => '(14) 99111-1009', 'cpf' => '111.222.333-09'],
                ['name' => 'Juliana Freitas', 'email' => 'juliana.freitas@exemplo.com', 'phone' => '(14) 99111-1010', 'cpf' => '111.222.333-10'],
            ];

            $unitStatuses = ['sold', 'reserved', 'sold', 'available', 'reserved', 'sold', 'available', 'reserved', 'sold', 'blocked'];
            $contractStatuses = ['assinado', 'ativo', 'concluido', 'cancelado', 'ativo', 'assinado', 'cancelado', 'ativo', 'concluido', 'cancelado'];

            foreach ($clientRows as $index => $clientData) {
                $client = Client::updateOrCreate(
                    ['cpf' => $clientData['cpf']],
                    [
                        ...$clientData,
                        'rg' => 'RG-00'.($index + 1),
                        'birth_date' => now()->subYears(28 + $index)->subDays($index)->format('Y-m-d'),
                        'address' => 'Rua do Cliente, '.(120 + $index),
                        'city' => $developmentRows[$index]['city'],
                        'state' => $developmentRows[$index]['state'],
                        'zip_code' => '1700'.($index).'000',
                    ]
                );

                $developmentData = $developmentRows[$index];
                $development = Development::updateOrCreate(
                    ['name' => $developmentData['name']],
                    [
                        'builder_id' => $builder->id,
                        'type' => $developmentData['type'],
                        'city' => $developmentData['city'],
                        'state' => $developmentData['state'],
                        'address' => 'Rua Principal, '.(300 + $index),
                        'start_date' => now()->subMonths(12 - $index)->format('Y-m-d'),
                        'expected_delivery_date' => now()->addMonths(8 + $index)->format('Y-m-d'),
                        'status' => $developmentData['status'],
                        'description' => 'Empreendimento demonstrativo gerado para apresentação do sistema OBRYN.',
                    ]
                );

                $unitIdentifier = $developmentData['type'] === 'apartments'
                    ? 'APT '.str_pad((string) (101 + $index), 3, '0', STR_PAD_LEFT)
                    : 'CASA '.str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT);

                $unitType = $developmentData['type'] === 'apartments' ? 'Apartamento' : 'Casa';
                $basePrice = 185000 + ($index * 37500);
                $discount = 5000 + ($index * 1000);
                $negotiatedValue = $basePrice - $discount;
                $downPayment = round($negotiatedValue * 0.2, 2);
                $financedAmount = $negotiatedValue - $downPayment;

                $unit = Unit::updateOrCreate(
                    [
                        'development_id' => $development->id,
                        'identifier' => $unitIdentifier,
                    ],
                    [
                        'type' => $unitType,
                        'block' => $developmentData['type'] === 'apartments' ? 'Torre '.chr(65 + ($index % 3)) : 'Quadra '.($index + 1),
                        'floor' => $developmentData['type'] === 'apartments' ? (string) (1 + $index) : 'Térreo',
                        'private_area' => 62 + ($index * 3),
                        'total_area' => 78 + ($index * 3.5),
                        'price' => $basePrice,
                        'status' => $unitStatuses[$index],
                        'notes' => 'Unidade demonstrativa criada automaticamente para validação visual do sistema.',
                    ]
                );

                Contract::updateOrCreate(
                    ['contract_number' => 'CTR-2026-'.str_pad((string) ($index + 1), 3, '0', STR_PAD_LEFT)],
                    [
                        'development_id' => $development->id,
                        'unit_id' => $unit->id,
                        'client_id' => $client->id,
                        'sale_date' => now()->subDays(45 - ($index * 2))->format('Y-m-d'),
                        'contract_date' => now()->subDays(42 - ($index * 2))->format('Y-m-d'),
                        'unit_price' => $basePrice,
                        'discount' => $discount,
                        'negotiated_value' => $negotiatedValue,
                        'down_payment' => $downPayment,
                        'financed_amount' => $financedAmount,
                        'installments_count' => 36 + ($index * 2),
                        'status' => $contractStatuses[$index],
                        'notes' => 'Contrato demonstrativo gerado automaticamente para popular o ambiente.',
                    ]
                );
            }
        });
    }
}