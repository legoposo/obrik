<div class="form-grid">
    <div class="field-group md:col-span-2">
        <label for="development_id" class="field-label">Empreendimento</label>
        <select id="development_id" name="development_id" class="field-input" required>
            <option value="">Selecione o empreendimento</option>
            @foreach ($developments as $developmentOption)
                <option value="{{ $developmentOption->id }}" @selected((string) old('development_id', $unit->development_id ?? '') === (string) $developmentOption->id)>
                    {{ $developmentOption->name }}
                </option>
            @endforeach
        </select>
        @error('development_id')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="field-group">
        <label for="block_or_tower" class="field-label">Bloco ou torre</label>
        <input
            id="block_or_tower"
            type="text"
            name="block_or_tower"
            value="{{ old('block_or_tower', $unit->block_or_tower ?? $unit->block ?? '') }}"
            class="field-input"
            placeholder="Ex.: Torre A"
        >
        @error('block_or_tower')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="field-group">
        <label for="unit_number" class="field-label">Numero da unidade</label>
        <input
            id="unit_number"
            type="text"
            name="unit_number"
            value="{{ old('unit_number', $unit->unit_number ?? $unit->identifier ?? '') }}"
            class="field-input"
            placeholder="Ex.: 1203"
            required
        >
        @error('unit_number')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="field-group">
        <label for="type" class="field-label">Tipologia</label>
        <input
            id="type"
            type="text"
            name="type"
            value="{{ old('type', $unit->type ?? '') }}"
            class="field-input"
            placeholder="Ex.: Apartamento 3 dormitorios"
            required
        >
        @error('type')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="field-group">
        <label for="area" class="field-label">Area (m2)</label>
        <input
            id="area"
            type="number"
            step="0.01"
            min="0"
            name="area"
            value="{{ old('area', $unit->area ?? $unit->private_area ?? '') }}"
            class="field-input"
        >
        @error('area')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="field-group">
        <label for="bedrooms" class="field-label">Dormitorios</label>
        <input
            id="bedrooms"
            type="number"
            min="0"
            name="bedrooms"
            value="{{ old('bedrooms', $unit->bedrooms ?? '') }}"
            class="field-input"
        >
        @error('bedrooms')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="field-group">
        <label for="parking_spaces" class="field-label">Vagas</label>
        <input
            id="parking_spaces"
            type="number"
            min="0"
            name="parking_spaces"
            value="{{ old('parking_spaces', $unit->parking_spaces ?? '') }}"
            class="field-input"
        >
        @error('parking_spaces')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="field-group">
        <label for="price" class="field-label">Preco</label>
        <input
            id="price"
            type="number"
            step="0.01"
            min="0"
            name="price"
            value="{{ old('price', $unit->price ?? '') }}"
            class="field-input"
            placeholder="0,00"
        >
        @error('price')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="field-group">
        <label for="status" class="field-label">Status comercial</label>
        <select id="status" name="status" class="field-input" required>
            <option value="disponivel" @selected(old('status', $unit->status ?? 'disponivel') === 'disponivel')>Disponivel</option>
            <option value="reservada" @selected(old('status', $unit->status ?? '') === 'reservada')>Reservada</option>
            <option value="vendida" @selected(old('status', $unit->status ?? '') === 'vendida')>Vendida</option>
            <option value="bloqueada" @selected(old('status', $unit->status ?? '') === 'bloqueada')>Bloqueada</option>
        </select>
        @error('status')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="field-group md:col-span-2">
        <label for="notes" class="field-label">Observacoes</label>
        <textarea id="notes" name="notes" rows="5" class="field-input" placeholder="Registre detalhes de planta, acabamento, vista, restricoes ou observacoes comerciais.">{{ old('notes', $unit->notes ?? '') }}</textarea>
        @error('notes')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>
</div>