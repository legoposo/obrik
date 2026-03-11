<div class="form-grid">
    <div class="field-group md:col-span-2">
        <label for="name" class="field-label">Nome</label>
        <input id="name" type="text" name="name" value="{{ old('name', $development->name ?? '') }}" class="field-input">
        @error('name')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="field-group">
        <label for="type" class="field-label">Tipo</label>
        <select id="type" name="type" class="field-input">
            <option value="">Selecione o tipo</option>
            <option value="houses" @selected(old('type', $development->type ?? '') === 'houses')>Casas</option>
            <option value="apartments" @selected(old('type', $development->type ?? '') === 'apartments')>Apartamentos</option>
        </select>
        @error('type')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="field-group">
        <label for="status" class="field-label">Status</label>
        <select id="status" name="status" class="field-input">
            <option value="planning" @selected(old('status', $development->status ?? '') === 'planning')>Planejamento</option>
            <option value="in_progress" @selected(old('status', $development->status ?? '') === 'in_progress')>Em andamento</option>
            <option value="paused" @selected(old('status', $development->status ?? '') === 'paused')>Pausado</option>
            <option value="completed" @selected(old('status', $development->status ?? '') === 'completed')>Concluído</option>
            <option value="canceled" @selected(old('status', $development->status ?? '') === 'canceled')>Cancelado</option>
        </select>
        @error('status')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="field-group">
        <label for="city" class="field-label">Cidade</label>
        <input id="city" type="text" name="city" value="{{ old('city', $development->city ?? '') }}" class="field-input">
        @error('city')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="field-group">
        <label for="state" class="field-label">Estado</label>
        <input id="state" type="text" name="state" maxlength="2" value="{{ old('state', $development->state ?? '') }}" class="field-input">
        @error('state')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="field-group md:col-span-2">
        <label for="address" class="field-label">Endereço</label>
        <input id="address" type="text" name="address" value="{{ old('address', $development->address ?? '') }}" class="field-input">
        @error('address')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="field-group">
        <label for="start_date" class="field-label">Data de início</label>
        <input id="start_date" type="date" name="start_date" value="{{ old('start_date', isset($development?->start_date) ? $development->start_date->format('Y-m-d') : '') }}" class="field-input">
        @error('start_date')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="field-group">
        <label for="expected_delivery_date" class="field-label">Previsão de entrega</label>
        <input id="expected_delivery_date" type="date" name="expected_delivery_date" value="{{ old('expected_delivery_date', isset($development?->expected_delivery_date) ? $development->expected_delivery_date->format('Y-m-d') : '') }}" class="field-input">
        @error('expected_delivery_date')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="field-group md:col-span-2">
        <label for="description" class="field-label">Descrição</label>
        <textarea id="description" name="description" rows="4" class="field-input">{{ old('description', $development->description ?? '') }}</textarea>
        @error('description')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>
</div>
