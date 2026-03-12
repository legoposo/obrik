<div class="form-grid">
    <div class="field-group md:col-span-2">
        <label for="title" class="field-label">Titulo</label>
        <input id="title" type="text" name="title" value="{{ old('title', $communication->title ?? '') }}" class="field-input" placeholder="Ex.: Atualizacao mensal da obra" required>
        @error('title')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="field-group md:col-span-2">
        <label for="type" class="field-label">Tipo</label>
        <select id="type" name="type" class="field-input" required>
            @foreach ($typeOptions as $value => $label)
                <option value="{{ $value }}" @selected(old('type', $communication->type ?? 'aviso') === $value)>{{ $label }}</option>
            @endforeach
        </select>
        @error('type')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="field-group md:col-span-2">
        <label for="message" class="field-label">Mensagem</label>
        <textarea id="message" name="message" rows="8" class="field-input" placeholder="Escreva o comunicado que sera exibido aos clientes do empreendimento." required>{{ old('message', $communication->message ?? '') }}</textarea>
        @error('message')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>
</div>