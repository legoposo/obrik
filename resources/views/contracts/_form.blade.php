@php
    $selectedDevelopmentId = (string) old('development_id', $contract->development_id ?? '');
    $selectedUnitId = (string) old('unit_id', $contract->unit_id ?? '');
    $selectedClientId = (string) old('client_id', $contract->client_id ?? '');

    $unitsPayload = $units->map(fn ($unit) => [
        'id' => (string) $unit->id,
        'development_id' => (string) $unit->development_id,
        'label' => trim(($unit->block_or_tower ? $unit->block_or_tower.' | ' : '').'Unidade '.($unit->unit_number ?? $unit->identifier).' | '.$unit->type),
        'price' => $unit->price !== null ? number_format((float) $unit->price, 2, '.', '') : null,
    ])->values();
@endphp

<div class="space-y-8">
    <input type="hidden" id="contract_units_payload" value='@json($unitsPayload)'>

    <section class="space-y-5">
        <div>
            <h3 class="text-base font-semibold text-zinc-900 dark:text-white">Dados principais</h3>
            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Vincule cliente, unidade e empreendimento em uma mesma operacao comercial.</p>
        </div>

        <div class="form-grid">
            <div class="field-group">
                <label for="development_id" class="field-label">Empreendimento</label>
                <select id="development_id" name="development_id" class="field-input" data-selected-development="{{ $selectedDevelopmentId }}" required>
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
                <select id="unit_id" name="unit_id" class="field-input" data-selected-unit="{{ $selectedUnitId }}" required>
                    <option value="">Selecione a unidade</option>
                </select>
                <p id="unit_id_hint" class="hidden text-xs text-zinc-500 dark:text-zinc-400">Nenhuma unidade disponivel para o empreendimento selecionado.</p>
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
                <label class="field-label">Codigo</label>
                <div class="field-input flex items-center text-zinc-500 dark:text-zinc-400">
                    {{ $contract->contract_number ?: 'Sera gerado automaticamente ao salvar.' }}
                </div>
            </div>

            <div class="field-group">
                <label for="value" class="field-label">Valor</label>
                <input id="value" type="number" step="0.01" min="0" name="value" value="{{ old('value', $contract->value ?? $contract->negotiated_value ?? '') }}" class="field-input" placeholder="0,00" required>
                @error('value')
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
            <h3 class="text-base font-semibold text-zinc-900 dark:text-white">Status e observacoes</h3>
            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">O status comercial da operacao tambem sincroniza o status da unidade.</p>
        </div>

        <div class="form-grid">
            <div class="field-group">
                <label for="status" class="field-label">Status</label>
                <select id="status" name="status" class="field-input" required>
                    @foreach ($statusOptions as $value => $label)
                        <option value="{{ $value }}" @selected(old('status', $contract->status ?? 'reserva') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
                @error('status')
                    <p class="field-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="field-group md:col-span-2">
                <label for="notes" class="field-label">Observacoes</label>
                <textarea id="notes" name="notes" rows="5" class="field-input" placeholder="Registre condicoes comerciais, contexto da negociacao ou observacoes relevantes.">{{ old('notes', $contract->notes ?? '') }}</textarea>
                @error('notes')
                    <p class="field-error">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </section>
</div>

<script>
    (() => {
        const payloadField = document.getElementById('contract_units_payload');
        const developmentSelect = document.getElementById('development_id');
        const unitSelect = document.getElementById('unit_id');
        const valueInput = document.getElementById('value');
        const hint = document.getElementById('unit_id_hint');

        if (! payloadField || ! developmentSelect || ! unitSelect || ! valueInput || ! hint) {
            return;
        }

        const units = JSON.parse(payloadField.value || '[]');
        const initialSelectedUnit = unitSelect.dataset.selectedUnit || '';

        const renderUnits = (developmentId) => {
            const filteredUnits = units.filter((unit) => unit.development_id === String(developmentId || ''));
            const currentSelectedUnit = unitSelect.dataset.selectedUnit || unitSelect.value || '';

            unitSelect.innerHTML = '<option value="">Selecione a unidade</option>';

            filteredUnits.forEach((unit) => {
                const option = document.createElement('option');
                option.value = unit.id;
                option.textContent = unit.label;
                option.dataset.price = unit.price || '';

                if (unit.id === currentSelectedUnit) {
                    option.selected = true;
                }

                unitSelect.appendChild(option);
            });

            hint.classList.toggle('hidden', filteredUnits.length > 0);

            if (! filteredUnits.some((unit) => unit.id === currentSelectedUnit)) {
                unitSelect.value = '';
            }
        };

        const applyUnitPrice = () => {
            const selectedOption = unitSelect.selectedOptions[0];

            if (! selectedOption || ! selectedOption.dataset.price) {
                return;
            }

            valueInput.value = selectedOption.dataset.price;
        };

        developmentSelect.addEventListener('change', () => {
            unitSelect.dataset.selectedUnit = '';
            renderUnits(developmentSelect.value);
        });

        unitSelect.addEventListener('change', applyUnitPrice);

        unitSelect.dataset.selectedUnit = initialSelectedUnit;
        renderUnits(developmentSelect.value || developmentSelect.dataset.selectedDevelopment || '');
    })();
</script>