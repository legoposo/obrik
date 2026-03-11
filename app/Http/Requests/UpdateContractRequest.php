<?php

namespace App\Http\Requests;

use App\Models\Contract;
use App\Models\Unit;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class UpdateContractRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $contract = $this->route('contract');

        return [
            'development_id' => ['required', 'exists:developments,id'],
            'unit_id' => ['required', 'exists:units,id'],
            'client_id' => ['required', 'exists:clients,id'],
            'contract_number' => ['required', 'string', 'max:255', Rule::unique('contracts', 'contract_number')->ignore($contract)],
            'sale_date' => ['required', 'date'],
            'contract_date' => ['required', 'date', 'after_or_equal:sale_date'],
            'unit_price' => ['required', 'numeric', 'min:0'],
            'discount' => ['nullable', 'numeric', 'min:0'],
            'negotiated_value' => ['required', 'numeric', 'min:0'],
            'down_payment' => ['nullable', 'numeric', 'min:0'],
            'financed_amount' => ['nullable', 'numeric', 'min:0'],
            'installments_count' => ['nullable', 'integer', 'min:0'],
            'status' => ['required', Rule::in(['ativo', 'assinado', 'cancelado', 'concluido'])],
            'notes' => ['nullable', 'string'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'discount' => $this->normalizeDecimal($this->input('discount')),
            'unit_price' => $this->normalizeDecimal($this->input('unit_price')),
            'negotiated_value' => $this->normalizeDecimal($this->input('negotiated_value')),
            'down_payment' => $this->normalizeDecimal($this->input('down_payment')),
            'financed_amount' => $this->normalizeDecimal($this->input('financed_amount')),
            'installments_count' => $this->input('installments_count') !== null && $this->input('installments_count') !== ''
                ? (int) $this->input('installments_count')
                : 0,
        ]);
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            $this->validateUnitBelongsToDevelopment($validator);
            $this->validateUnitAvailability($validator);
            $this->validateAmounts($validator);
        });
    }

    protected function validateUnitBelongsToDevelopment(Validator $validator): void
    {
        if (! $this->filled('development_id') || ! $this->filled('unit_id')) {
            return;
        }

        $unitBelongsToDevelopment = Unit::query()
            ->whereKey($this->integer('unit_id'))
            ->where('development_id', $this->integer('development_id'))
            ->exists();

        if (! $unitBelongsToDevelopment) {
            $validator->errors()->add('unit_id', 'A unidade selecionada nao pertence ao empreendimento informado.');
        }
    }

    protected function validateUnitAvailability(Validator $validator): void
    {
        if (! $this->filled('unit_id')) {
            return;
        }

        $currentContract = $this->route('contract');

        $hasOpenContract = Contract::query()
            ->where('unit_id', $this->integer('unit_id'))
            ->where('id', '!=', $currentContract?->id)
            ->whereIn('status', ['ativo', 'assinado', 'concluido'])
            ->exists();

        if ($hasOpenContract) {
            $validator->errors()->add('unit_id', 'A unidade selecionada ja possui um contrato vigente.');
        }
    }

    protected function validateAmounts(Validator $validator): void
    {
        $unitPrice = (float) ($this->input('unit_price') ?? 0);
        $discount = (float) ($this->input('discount') ?? 0);
        $negotiatedValue = (float) ($this->input('negotiated_value') ?? 0);
        $downPayment = (float) ($this->input('down_payment') ?? 0);
        $financedAmount = (float) ($this->input('financed_amount') ?? 0);

        if ($negotiatedValue > $unitPrice) {
            $validator->errors()->add('negotiated_value', 'O valor negociado nao pode ser maior que o valor da unidade.');
        }

        if ($discount > $unitPrice) {
            $validator->errors()->add('discount', 'O desconto nao pode ser maior que o valor da unidade.');
        }

        if (($downPayment + $financedAmount) > $negotiatedValue) {
            $validator->errors()->add('financed_amount', 'Entrada e financiamento nao podem ultrapassar o valor negociado.');
        }
    }

    protected function normalizeDecimal(mixed $value): mixed
    {
        if ($value === null || $value === '') {
            return 0;
        }

        if (is_numeric($value)) {
            return $value;
        }

        $normalized = str_replace('.', '', (string) $value);
        $normalized = str_replace(',', '.', $normalized);

        return is_numeric($normalized) ? $normalized : $value;
    }
}
