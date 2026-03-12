<div class="form-grid">
    <div class="field-group md:col-span-2">
        <label for="name" class="field-label">Nome do empreendimento</label>
        <input
            id="name"
            type="text"
            name="name"
            value="{{ old('name', $development->name ?? '') }}"
            class="field-input"
            placeholder="Ex.: Residencial Aurora"
            required
        >
        @error('name')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="field-group md:col-span-2">
        <label for="location" class="field-label">Localizacao</label>
        <input
            id="location"
            type="text"
            name="location"
            value="{{ old('location', $development->location ?? $development->address ?? '') }}"
            class="field-input"
            placeholder="Cidade, bairro ou endereco principal"
        >
        @error('location')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="field-group">
        <label for="status" class="field-label">Status</label>
        <select id="status" name="status" class="field-input" required>
            <option value="planejamento" @selected(old('status', $development->status ?? 'planejamento') === 'planejamento')>Planejamento</option>
            <option value="lancamento" @selected(old('status', $development->status ?? '') === 'lancamento')>Lancamento</option>
            <option value="em_obras" @selected(old('status', $development->status ?? '') === 'em_obras')>Em obras</option>
            <option value="finalizado" @selected(old('status', $development->status ?? '') === 'finalizado')>Finalizado</option>
            <option value="entregue" @selected(old('status', $development->status ?? '') === 'entregue')>Entregue</option>
            <option value="cancelado" @selected(old('status', $development->status ?? '') === 'cancelado')>Cancelado</option>
        </select>
        @error('status')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="field-group">
        <label for="launch_date" class="field-label">Data de lancamento</label>
        <input
            id="launch_date"
            type="date"
            name="launch_date"
            value="{{ old('launch_date', isset($development?->launch_date) ? $development->launch_date->format('Y-m-d') : (isset($development?->start_date) ? $development->start_date->format('Y-m-d') : '')) }}"
            class="field-input"
        >
        @error('launch_date')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="field-group">
        <label for="expected_delivery" class="field-label">Previsao de entrega</label>
        <input
            id="expected_delivery"
            type="date"
            name="expected_delivery"
            value="{{ old('expected_delivery', isset($development?->expected_delivery) ? $development->expected_delivery->format('Y-m-d') : (isset($development?->expected_delivery_date) ? $development->expected_delivery_date->format('Y-m-d') : '')) }}"
            class="field-input"
        >
        @error('expected_delivery')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="field-group md:col-span-2">
        <label for="description" class="field-label">Descricao</label>
        <textarea id="description" name="description" rows="4" class="field-input" placeholder="Apresente proposta, diferencial comercial e contexto do empreendimento.">{{ old('description', $development->description ?? '') }}</textarea>
        @error('description')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="field-group md:col-span-2">
        <label for="notes" class="field-label">Observacoes internas</label>
        <textarea id="notes" name="notes" rows="5" class="field-input" placeholder="Registre informacoes operacionais, decisoes comerciais ou pontos de atencao.">{{ old('notes', $development->notes ?? '') }}</textarea>
        @error('notes')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>
</div>