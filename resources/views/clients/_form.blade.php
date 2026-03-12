<div class="form-grid">
    <div class="field-group md:col-span-2">
        <label for="name" class="field-label">Nome</label>
        <input id="name" type="text" name="name" value="{{ old('name', $client->name ?? '') }}" class="field-input" placeholder="Nome completo do cliente" required>
        @error('name')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="field-group">
        <label for="status" class="field-label">Status</label>
        <select id="status" name="status" class="field-input" required>
            <option value="lead" @selected(old('status', $client->status ?? 'lead') === 'lead')>Lead</option>
            <option value="interessado" @selected(old('status', $client->status ?? '') === 'interessado')>Interessado</option>
            <option value="comprador" @selected(old('status', $client->status ?? '') === 'comprador')>Comprador</option>
            <option value="pos_venda" @selected(old('status', $client->status ?? '') === 'pos_venda')>Pos-venda</option>
        </select>
        @error('status')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="field-group">
        <label for="document" class="field-label">Documento</label>
        <input id="document" type="text" name="document" value="{{ old('document', $client->document ?? $client->cpf ?? '') }}" class="field-input" placeholder="CPF, CNPJ ou outro documento">
        @error('document')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="field-group">
        <label for="phone" class="field-label">Telefone</label>
        <input id="phone" type="text" name="phone" value="{{ old('phone', $client->phone ?? '') }}" class="field-input" placeholder="(00) 00000-0000">
        @error('phone')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="field-group">
        <label for="email" class="field-label">E-mail</label>
        <input id="email" type="email" name="email" value="{{ old('email', $client->email ?? '') }}" class="field-input" placeholder="cliente@exemplo.com">
        @error('email')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="field-group md:col-span-2">
        <label for="address" class="field-label">Endereco</label>
        <input id="address" type="text" name="address" value="{{ old('address', $client->address ?? '') }}" class="field-input" placeholder="Endereco principal do cliente">
        @error('address')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="field-group md:col-span-2">
        <label for="notes" class="field-label">Observacoes</label>
        <textarea id="notes" name="notes" rows="5" class="field-input" placeholder="Historico de atendimento, preferencias, restricoes ou contexto comercial.">{{ old('notes', $client->notes ?? '') }}</textarea>
        @error('notes')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>
</div>