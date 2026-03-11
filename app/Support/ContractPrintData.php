<?php

namespace App\Support;

use App\Models\Contract;
use Illuminate\Support\Carbon;

class ContractPrintData
{
    /**
     * @return array<string, string>
     */
    public static function from(Contract $contract): array
    {
        $client = $contract->client;
        $development = $contract->development;
        $builder = $development?->builder;
        $unit = $contract->unit;
        $negotiatedValue = (float) $contract->negotiated_value;

        return [
            'title' => 'CONTRATO DE PROMESSA DE COMPRA E VENDA DE UNIDADE IMOBILIARIA',
            'contract_number' => $contract->contract_number ?: 'Nao informado',
            'contract_date_full' => self::formatLongDate($contract->contract_date),
            'seller_name' => $builder?->name ?: 'Construtora nao informada',
            'seller_description' => self::buildSellerDescription(
                $builder?->name,
                $builder?->cnpj
            ),
            'buyer_name' => $client?->name ?: 'Cliente nao informado',
            'buyer_description' => self::buildBuyerDescription(
                $client?->name,
                $client?->cpf,
                $client?->address,
                $client?->city,
                $client?->state
            ),
            'development_name' => $development?->name ?: 'Nao informado',
            'development_type' => self::translateDevelopmentType($development?->type),
            'development_address' => $development?->address ?: 'Nao informado',
            'development_city' => $development?->city ?: 'Nao informado',
            'development_state' => $development?->state ?: 'Nao informado',
            'builder_name' => $builder?->name ?: 'Nao informado',
            'unit_identifier' => $unit?->identifier ?: 'Nao informado',
            'unit_floor' => self::formatFloor($unit?->floor),
            'unit_type' => $unit?->type ?: 'Nao informado',
            'unit_status' => self::translateUnitStatus($unit?->status),
            'negotiated_value' => self::formatMoney($negotiatedValue),
            'negotiated_value_words' => PortugueseCurrencyWriter::toWords($negotiatedValue),
            'payment_terms' => self::buildPaymentTerms($contract),
            'client_reference' => $client?->name ?: 'Nao informado',
            'unit_reference' => $unit?->identifier ?: 'Nao informado',
            'development_reference' => $development?->name ?: 'Nao informado',
            'contract_status' => self::translateContractStatus($contract->status),
            'forum_city_state' => self::formatCityState(
                $development?->city,
                $development?->state,
                'Nao informado'
            ),
            'issued_at' => now()->format('d/m/Y H:i'),
        ];
    }

    protected static function formatLongDate(Carbon|string|null $date): string
    {
        if (! $date) {
            return 'Nao informada';
        }

        $parsed = $date instanceof Carbon ? $date : Carbon::parse($date);

        return $parsed->locale('pt_BR')->translatedFormat('d \d\e F \d\e Y');
    }

    protected static function buildSellerDescription(?string $name, ?string $cnpj): string
    {
        $sellerName = $name ?: 'Construtora nao informada';
        $cnpjText = $cnpj ? ', CNPJ '.$cnpj : '';

        return $sellerName.$cnpjText.', pessoa juridica de direito privado, responsavel pelo empreendimento imobiliario descrito neste contrato.';
    }

    protected static function buildBuyerDescription(
        ?string $name,
        ?string $cpf,
        ?string $address,
        ?string $city,
        ?string $state
    ): string {
        $buyerName = $name ?: 'Cliente nao informado';
        $cpfText = $cpf ? 'CPF '.$cpf : 'CPF nao informado';
        $location = self::buildResidenceText($address, $city, $state);

        return $buyerName.', '.$cpfText.', '.$location.'.';
    }

    protected static function buildResidenceText(?string $address, ?string $city, ?string $state): string
    {
        $cityState = self::formatCityState($city, $state, '');

        if ($address && $cityState !== '') {
            return 'residente e domiciliado em '.$address.', '.$cityState;
        }

        if ($address) {
            return 'residente e domiciliado em '.$address;
        }

        if ($cityState !== '') {
            return 'residente e domiciliado na cidade de '.$cityState;
        }

        return 'residente e domiciliado em localidade nao informada';
    }

    protected static function formatFloor(?string $floor): string
    {
        if (! $floor) {
            return 'Nao informado';
        }

        $normalized = trim($floor);

        if (preg_match('/^\d+$/', $normalized) === 1) {
            return $normalized.'º';
        }

        return $normalized;
    }

    protected static function buildPaymentTerms(Contract $contract): string
    {
        $details = [];

        if ((float) $contract->down_payment > 0) {
            $details[] = 'entrada de '.self::formatMoney((float) $contract->down_payment);
        }

        if ((float) $contract->financed_amount > 0) {
            $details[] = 'saldo financiado de '.self::formatMoney((float) $contract->financed_amount);
        }

        if ((int) $contract->installments_count > 0) {
            $details[] = (int) $contract->installments_count.' parcelas previstas';
        }

        if ($details === []) {
            return 'Forma de pagamento acordada entre as partes conforme condicoes registradas no sistema de gestao da construtora.';
        }

        return 'Forma de pagamento registrada no sistema de gestao da construtora, com '.self::joinWithAnd($details).'.';
    }

    protected static function translateDevelopmentType(?string $type): string
    {
        return match ($type) {
            'houses' => 'Casas',
            'apartments' => 'Apartamentos',
            default => 'Nao informado',
        };
    }

    protected static function translateUnitStatus(?string $status): string
    {
        return match ($status) {
            'available' => 'Disponivel',
            'reserved' => 'Reservada',
            'sold' => 'Vendida',
            'blocked' => 'Bloqueada',
            default => 'Nao informada',
        };
    }

    protected static function translateContractStatus(?string $status): string
    {
        return match ($status) {
            'ativo' => 'Ativo',
            'assinado' => 'Assinado',
            'cancelado' => 'Cancelado',
            'concluido' => 'Concluido',
            default => 'Nao informado',
        };
    }

    protected static function formatMoney(float $value): string
    {
        return 'R$ '.number_format($value, 2, ',', '.');
    }

    protected static function formatCityState(?string $city, ?string $state, string $fallback): string
    {
        $city = $city ? trim($city) : '';
        $state = $state ? trim($state) : '';

        if ($city !== '' && $state !== '') {
            return $city.'/'.$state;
        }

        if ($city !== '') {
            return $city;
        }

        if ($state !== '') {
            return $state;
        }

        return $fallback;
    }

    /**
     * @param  list<string>  $parts
     */
    protected static function joinWithAnd(array $parts): string
    {
        $count = count($parts);

        if ($count === 1) {
            return $parts[0];
        }

        if ($count === 2) {
            return $parts[0].' e '.$parts[1];
        }

        $last = array_pop($parts);

        return implode(', ', $parts).' e '.$last;
    }
}