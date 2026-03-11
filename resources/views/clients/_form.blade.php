<div class="form-grid">
    <div class="field-group md:col-span-2">
        <label for="name" class="field-label">Nome</label>
        <input id="name" type="text" name="name" value="{{ old('name', $client->name ?? '') }}" class="field-input">
        @error('name')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="field-group">
        <label for="email" class="field-label">E-mail</label>
        <input id="email" type="email" name="email" value="{{ old('email', $client->email ?? '') }}" class="field-input">
    </div>

    <div class="field-group">
        <label for="phone" class="field-label">Telefone</label>
        <input id="phone" type="text" name="phone" value="{{ old('phone', $client->phone ?? '') }}" class="field-input">
    </div>

    <div class="field-group">
        <label for="cpf" class="field-label">CPF</label>
        <input id="cpf" type="text" name="cpf" value="{{ old('cpf', $client->cpf ?? '') }}" class="field-input">
    </div>

    <div class="field-group">
        <label for="rg" class="field-label">RG</label>
        <input id="rg" type="text" name="rg" value="{{ old('rg', $client->rg ?? '') }}" class="field-input">
    </div>

    <div class="field-group">
        <label for="birth_date" class="field-label">Data de nascimento</label>
        <input id="birth_date" type="date" name="birth_date" value="{{ old('birth_date', $client->birth_date ?? '') }}" class="field-input">
    </div>

    <div class="field-group">
        <label for="zip_code" class="field-label">CEP</label>
        <input id="zip_code" type="text" name="zip_code" value="{{ old('zip_code', $client->zip_code ?? '') }}" class="field-input">
    </div>

    <div class="field-group md:col-span-2">
        <label for="address" class="field-label">Endereco</label>
        <input id="address" type="text" name="address" value="{{ old('address', $client->address ?? '') }}" class="field-input">
    </div>

    <div class="field-group">
        <label for="city" class="field-label">Cidade</label>
        <input id="city" type="text" name="city" value="{{ old('city', $client->city ?? '') }}" class="field-input">
    </div>

    <div class="field-group">
        <label for="state" class="field-label">Estado</label>
        <input id="state" type="text" name="state" value="{{ old('state', $client->state ?? '') }}" maxlength="2" class="field-input">
    </div>
</div>
