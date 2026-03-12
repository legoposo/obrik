<div class="form-grid">
    <div class="field-group md:col-span-2">
        <label for="title" class="field-label">Titulo</label>
        <input id="title" type="text" name="title" value="{{ old('title', $photo->title ?? '') }}" class="field-input" placeholder="Ex.: Evolucao da fachada" required>
        @error('title')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="field-group">
        <label for="date" class="field-label">Data</label>
        <input id="date" type="date" name="date" value="{{ old('date', $photo->date?->format('Y-m-d') ?? '') }}" class="field-input">
        @error('date')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="field-group">
        <label for="image" class="field-label">Imagem</label>
        <input id="image" type="file" name="image" accept="image/*" class="field-input" @required(! $photo->exists)>
        <p class="text-xs text-zinc-500 dark:text-zinc-400">Arquivos de ate 5 MB. Formatos comuns de imagem sao aceitos.</p>
        @error('image')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="field-group md:col-span-2">
        <label for="description" class="field-label">Descricao</label>
        <textarea id="description" name="description" rows="6" class="field-input" placeholder="Descreva o que esta sendo mostrado nesta atualizacao visual da obra.">{{ old('description', $photo->description ?? '') }}</textarea>
        @error('description')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    @if ($photo->exists && $photo->image_path)
        <div class="field-group md:col-span-2">
            <label class="field-label">Imagem atual</label>
            <div class="overflow-hidden rounded-3xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                <img src="{{ asset('storage/'.$photo->image_path) }}" alt="{{ $photo->title }}" class="h-80 w-full object-cover">
            </div>
        </div>
    @endif
</div>