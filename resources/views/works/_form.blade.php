<div class="form-grid">
    <div class="field-group">
        <label for="client_id" class="field-label">Cliente</label>
        <select id="client_id" name="client_id" class="field-input">
            <option value="">Selecione um cliente</option>
            @foreach ($clients as $client)
                <option value="{{ $client->id }}" @selected(old('client_id', $work->client_id ?? '') == $client->id)>
                    {{ $client->name }}
                </option>
            @endforeach
        </select>
        @error('client_id')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="field-group">
        <label for="name" class="field-label">Nome da obra</label>
        <input id="name" type="text" name="name" value="{{ old('name', $work->name ?? '') }}" class="field-input">
        @error('name')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="field-group md:col-span-2">
        <label for="address" class="field-label">Endereco</label>
        <input id="address" type="text" name="address" value="{{ old('address', $work->address ?? '') }}" autocomplete="off" class="field-input">
    </div>

    <div class="field-group">
        <label for="city" class="field-label">Cidade</label>
        <input id="city" type="text" name="city" value="{{ old('city', $work->city ?? '') }}" class="field-input">
    </div>

    <div class="field-group">
        <label for="state" class="field-label">Estado</label>
        <input id="state" type="text" name="state" value="{{ old('state', $work->state ?? '') }}" maxlength="2" class="field-input">
    </div>

    <div class="field-group">
        <label for="start_date" class="field-label">Data de inicio</label>
        <input id="start_date" type="date" name="start_date" value="{{ old('start_date', $work->start_date?->format('Y-m-d') ?? '') }}" class="field-input">
    </div>

    <div class="field-group">
        <label for="expected_end_date" class="field-label">Previsao de termino</label>
        <input id="expected_end_date" type="date" name="expected_end_date" value="{{ old('expected_end_date', $work->expected_end_date?->format('Y-m-d') ?? '') }}" class="field-input">
    </div>

    <div class="field-group">
        <label for="zip_code" class="field-label">CEP</label>
        <input id="zip_code" type="text" name="zip_code" value="{{ old('zip_code', $work->zip_code ?? '') }}" class="field-input">
    </div>

    <div class="field-group">
        <label for="budget" class="field-label">Orcamento</label>
        <input id="budget" type="number" step="0.01" name="budget" value="{{ old('budget', $work->budget ?? '') }}" class="field-input">
    </div>

    <div class="field-group">
        <label for="status" class="field-label">Status</label>
        <select id="status" name="status" class="field-input">
            <option value="planning" @selected(old('status', $work->status ?? '') == 'planning')>Planejamento</option>
            <option value="in_progress" @selected(old('status', $work->status ?? '') == 'in_progress')>Em andamento</option>
            <option value="paused" @selected(old('status', $work->status ?? '') == 'paused')>Pausada</option>
            <option value="finished" @selected(old('status', $work->status ?? '') == 'finished')>Concluida</option>
            <option value="canceled" @selected(old('status', $work->status ?? '') == 'canceled')>Cancelada</option>
        </select>
    </div>

    <div class="field-group md:col-span-2">
        <label for="notes" class="field-label">Observacoes</label>
        <textarea id="notes" name="notes" rows="4" class="field-input">{{ old('notes', $work->notes ?? '') }}</textarea>
    </div>
</div>
