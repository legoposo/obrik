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
        <label for="identifier" class="field-label">Identificação da unidade</label>
        <input id="identifier" type="text" name="identifier" value="{{ old('identifier', $unit->identifier ?? '') }}" class="field-input" required>
        @error('identifier')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="field-group">
        <label for="type" class="field-label">Tipo</label>
        <input id="type" type="text" name="type" value="{{ old('type', $unit->type ?? '') }}" class="field-input" required>
        @error('type')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="field-group">
        <label for="block" class="field-label">Bloco/Torre</label>
        <input id="block" type="text" name="block" value="{{ old('block', $unit->block ?? '') }}" class="field-input">
        @error('block')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="field-group">
        <label for="floor" class="field-label">Andar</label>
        <input id="floor" type="text" name="floor" value="{{ old('floor', $unit->floor ?? '') }}" class="field-input">
        @error('floor')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="field-group">
        <label for="private_area" class="field-label">Área privativa (m²)</label>
        <input id="private_area" type="number" step="0.01" min="0" name="private_area" value="{{ old('private_area', $unit->private_area ?? '') }}" class="field-input">
        @error('private_area')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="field-group">
        <label for="total_area" class="field-label">Área total (m²)</label>
        <input id="total_area" type="number" step="0.01" min="0" name="total_area" value="{{ old('total_area', $unit->total_area ?? '') }}" class="field-input">
        @error('total_area')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="field-group">
        <label for="price" class="field-label">Valor</label>
        <input id="price" type="number" step="0.01" min="0" name="price" value="{{ old('price', $unit->price ?? '') }}" class="field-input">
        @error('price')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="field-group">
        <label for="status" class="field-label">Status</label>
        <select id="status" name="status" class="field-input" required>
            <option value="available" @selected(old('status', $unit->status ?? 'available') === 'available')>Disponível</option>
            <option value="reserved" @selected(old('status', $unit->status ?? '') === 'reserved')>Reservado</option>
            <option value="sold" @selected(old('status', $unit->status ?? '') === 'sold')>Vendido</option>
            <option value="blocked" @selected(old('status', $unit->status ?? '') === 'blocked')>Bloqueado</option>
        </select>
        @error('status')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="field-group md:col-span-2">
        <label for="notes" class="field-label">Observações</label>
        <textarea id="notes" name="notes" rows="4" class="field-input">{{ old('notes', $unit->notes ?? '') }}</textarea>
        @error('notes')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>
</div>
