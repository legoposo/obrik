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
        return [
            'development_id' => ['required', 'exists:developments,id'],
            'unit_id' => ['required', 'exists:units,id'],
            'client_id' => ['required', 'exists:clients,id'],
            'value' => ['required', 'numeric', 'min:0'],
            'contract_date' => ['required', 'date'],
            'status' => ['required', Rule::in(['reserva', 'proposta', 'contrato_assinado', 'cancelado', 'concluido'])],
            'notes' => ['nullable', 'string'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'value' => $this->normalizeDecimal($this->input('value')),
        ]);
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            $this->validateUnitBelongsToDevelopment($validator);
            $this->validateUnitAvailability($validator);
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
            ->whereIn('status', ['reserva', 'proposta', 'contrato_assinado', 'concluido'])
            ->exists();

        if ($hasOpenContract) {
            $validator->errors()->add('unit_id', 'A unidade selecionada ja possui uma reserva ou contrato vigente.');
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
