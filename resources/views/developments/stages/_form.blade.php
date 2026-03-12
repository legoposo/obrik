<div class="form-grid">
    <div class="field-group md:col-span-2">
        <label for="stage_name" class="field-label">Nome da etapa</label>
        <input
            id="stage_name"
            type="text"
            name="stage_name"
            value="{{ old('stage_name', $stage->stage_name ?? '') }}"
            class="field-input"
            list="stage-suggestions"
            placeholder="Ex.: Fundacao, Estrutura, Acabamento"
            required
        >
        <datalist id="stage-suggestions">
            @foreach ($stageSuggestions as $stageSuggestion)
                <option value="{{ $stageSuggestion }}"></option>
            @endforeach
        </datalist>
        @error('stage_name')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="field-group">
        <label for="status" class="field-label">Status</label>
        <select id="status" name="status" class="field-input" required>
            @foreach ($statusOptions as $value => $label)
                <option value="{{ $value }}" @selected(old('status', $stage->status ?? 'pendente') === $value)>{{ $label }}</option>
            @endforeach
        </select>
        @error('status')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="field-group">
        <label for="responsible" class="field-label">Responsavel</label>
        <input id="responsible" type="text" name="responsible" value="{{ old('responsible', $stage->responsible ?? '') }}" class="field-input" placeholder="Nome do responsavel pela etapa">
        @error('responsible')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="field-group">
        <label for="start_date" class="field-label">Data de inicio</label>
        <input id="start_date" type="date" name="start_date" value="{{ old('start_date', $stage->start_date?->format('Y-m-d') ?? '') }}" class="field-input">
        @error('start_date')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="field-group">
        <label for="expected_date" class="field-label">Data prevista</label>
        <input id="expected_date" type="date" name="expected_date" value="{{ old('expected_date', $stage->expected_date?->format('Y-m-d') ?? '') }}" class="field-input">
        @error('expected_date')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="field-group md:col-span-2">
        <label for="finished_date" class="field-label">Data de conclusao</label>
        <input id="finished_date" type="date" name="finished_date" value="{{ old('finished_date', $stage->finished_date?->format('Y-m-d') ?? '') }}" class="field-input">
        <p class="text-xs text-zinc-500 dark:text-zinc-400">Preencha quando a etapa estiver concluida ou deixe em branco para concluir depois.</p>
        @error('finished_date')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="field-group md:col-span-2">
        <label for="notes" class="field-label">Observacoes</label>
        <textarea id="notes" name="notes" rows="5" class="field-input" placeholder="Registre detalhes importantes da execucao da etapa.">{{ old('notes', $stage->notes ?? '') }}</textarea>
        @error('notes')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>
</div>