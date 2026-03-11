@php
    $selectedDevelopmentId = (string) old('development_id', $contract->development_id ?? '');
    $selectedUnitId = (string) old('unit_id', $contract->unit_id ?? '');
    $selectedClientId = (string) old('client_id', $contract->client_id ?? '');

    $unitsPayload = $units->map(fn ($unit) => [
        'id' => (string) $unit->id,
        'development_id' => (string) $unit->development_id,
        'label' => trim($unit->identifier.' | Bloco '.($unit->block ?: '-').' | Andar '.($unit->floor ?: '-')),
        'price' => $unit->price !== null ? number_format((float) $unit->price, 2, '.', '') : null,
    ])->values();
@endphp

<div class="space-y-8">
    <input type="hidden" id="contract_units_payload" value='@json($unitsPayload)'>

    <section class="space-y-5">
        <div>
            <h3 class="text-base font-semibold text-zinc-900 dark:text-white">Dados principais</h3>
            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Defina o vínculo oficial entre empreendimento, unidade e cliente.</p>
        </div>

        <div class="form-grid">
            <div class="field-group">
                <label for="development_id" class="field-label">Empreendimento</label>
                <select
                    id="development_id"
                    name="development_id"
                    class="field-input"
                    data-selected-development="{{ $selectedDevelopmentId }}"
                    required
                >
                    <option value="">Selecione o empreendimento</option>
                    @foreach ($developments as $development)
                        <option value="{{ $development->id }}" @selected($selectedDevelopmentId === (string) $development->id)>{{ $development->name }}</option>
                    @endforeach
                </select>
                @error('development_id')
                    <p class="field-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="field-group">
                <label for="unit_id" class="field-label">Unidade</label>
                <select
                    id="unit_id"
                    name="unit_id"
                    class="field-input"
                    data-selected-unit="{{ $selectedUnitId }}"
                    required
                >
                    <option value="">Selecione a unidade</option>
                </select>
                <p id="unit_id_hint" class="hidden text-xs text-zinc-500 dark:text-zinc-400">
                    Nenhuma unidade encontrada para o empreendimento selecionado.
                </p>
                @error('unit_id')
                    <p class="field-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="field-group">
                <label for="client_id" class="field-label">Cliente</label>
                <select id="client_id" name="client_id" class="field-input" required>
                    <option value="">Selecione o cliente</option>
                    @foreach ($clients as $client)
                        <option value="{{ $client->id }}" @selected($selectedClientId === (string) $client->id)>{{ $client->name }}</option>
                    @endforeach
                </select>
                @error('client_id')
                    <p class="field-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="field-group">
                <label for="contract_number" class="field-label">Número do contrato</label>
                <input id="contract_number" type="text" name="contract_number" value="{{ old('contract_number', $contract->contract_number ?? '') }}" class="field-input" required>
                @error('contract_number')
                    <p class="field-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="field-group">
                <label for="sale_date" class="field-label">Data da venda</label>
                <input id="sale_date" type="date" name="sale_date" value="{{ old('sale_date', isset($contract?->sale_date) ? $contract->sale_date->format('Y-m-d') : '') }}" class="field-input" required>
                @error('sale_date')
                    <p class="field-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="field-group">
                <label for="contract_date" class="field-label">Data do contrato</label>
                <input id="contract_date" type="date" name="contract_date" value="{{ old('contract_date', isset($contract?->contract_date) ? $contract->contract_date->format('Y-m-d') : '') }}" class="field-input" required>
                @error('contract_date')
                    <p class="field-error">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </section>

    <section class="space-y-5 border-t border-zinc-200 pt-8 dark:border-zinc-800">
        <div>
            <h3 class="text-base font-semibold text-zinc-900 dark:text-white">Valores</h3>
            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Informe os valores comerciais do contrato e deixe a base pronta para futuras parcelas.</p>
        </div>

        <div class="form-grid">
            <div class="field-group">
                <label for="unit_price" class="field-label">Valor da unidade</label>
                <input id="unit_price" type="number" step="0.01" min="0" name="unit_price" value="{{ old('unit_price', $contract->unit_price ?? '') }}" class="field-input" required>
                @error('unit_price')
                    <p class="field-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="field-group">
                <label for="discount" class="field-label">Desconto</label>
                <input id="discount" type="number" step="0.01" min="0" name="discount" value="{{ old('discount', $contract->discount ?? 0) }}" class="field-input">
                @error('discount')
                    <p class="field-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="field-group">
                <label for="negotiated_value" class="field-label">Valor negociado</label>
                <input id="negotiated_value" type="number" step="0.01" min="0" name="negotiated_value" value="{{ old('negotiated_value', $contract->negotiated_value ?? '') }}" class="field-input" required>
                @error('negotiated_value')
                    <p class="field-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="field-group">
                <label for="down_payment" class="field-label">Entrada</label>
                <input id="down_payment" type="number" step="0.01" min="0" name="down_payment" value="{{ old('down_payment', $contract->down_payment ?? 0) }}" class="field-input">
                @error('down_payment')
                    <p class="field-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="field-group">
                <label for="financed_amount" class="field-label">Valor financiado</label>
                <input id="financed_amount" type="number" step="0.01" min="0" name="financed_amount" value="{{ old('financed_amount', $contract->financed_amount ?? 0) }}" class="field-input">
                @error('financed_amount')
                    <p class="field-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="field-group">
                <label for="installments_count" class="field-label">Quantidade de parcelas</label>
                <input id="installments_count" type="number" min="0" name="installments_count" value="{{ old('installments_count', $contract->installments_count ?? 0) }}" class="field-input">
                @error('installments_count')
                    <p class="field-error">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </section>

    <section class="space-y-5 border-t border-zinc-200 pt-8 dark:border-zinc-800">
        <div>
            <h3 class="text-base font-semibold text-zinc-900 dark:text-white">Status e observações</h3>
            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Mantenha o acompanhamento contratual organizado e pronto para futuras automações.</p>
        </div>

        <div class="form-grid">
            <div class="field-group">
                <label for="status" class="field-label">Status</label>
                <select id="status" name="status" class="field-input" required>
                    <option value="ativo" @selected(old('status', $contract->status ?? 'ativo') === 'ativo')>Ativo</option>
                    <option value="assinado" @selected(old('status', $contract->status ?? '') === 'assinado')>Assinado</option>
                    <option value="cancelado" @selected(old('status', $contract->status ?? '') === 'cancelado')>Cancelado</option>
                    <option value="concluido" @selected(old('status', $contract->status ?? '') === 'concluido')>Concluído</option>
                </select>
                @error('status')
                    <p class="field-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="field-group md:col-span-2">
                <label for="notes" class="field-label">Observações</label>
                <textarea id="notes" name="notes" rows="5" class="field-input">{{ old('notes', $contract->notes ?? '') }}</textarea>
                @error('notes')
                    <p class="field-error">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </section>
</div>