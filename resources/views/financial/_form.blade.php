<div class="form-grid">
    <div class="field-group">
        <label for="work_id" class="field-label">Obra</label>
        <select name="work_id" id="work_id" class="field-input" required>
            <option value="">Selecione</option>
            @foreach ($works as $work)
                <option value="{{ $work->id }}" {{ old('work_id', $financial->work_id ?? '') == $work->id ? 'selected' : '' }}>
                    {{ $work->name }}
                </option>
            @endforeach
        </select>
        @error('work_id')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="field-group">
        <label for="client_id" class="field-label">Cliente</label>
        <select name="client_id" id="client_id" class="field-input">
            <option value="">Selecione</option>
            @foreach ($clients as $client)
                <option value="{{ $client->id }}" {{ old('client_id', $financial->client_id ?? '') == $client->id ? 'selected' : '' }}>
                    {{ $client->name }}
                </option>
            @endforeach
        </select>
        @error('client_id')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="field-group">
        <label for="type" class="field-label">Tipo</label>
        <select name="type" id="type" class="field-input" required>
            <option value="">Selecione</option>
            <option value="income" {{ old('type', $financial->type ?? '') === 'income' ? 'selected' : '' }}>Receita</option>
            <option value="expense" {{ old('type', $financial->type ?? '') === 'expense' ? 'selected' : '' }}>Despesa</option>
        </select>
        @error('type')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="field-group">
        <label for="amount" class="field-label">Valor</label>
        <input type="number" step="0.01" name="amount" id="amount" value="{{ old('amount', $financial->amount ?? '') }}" class="field-input" required>
        @error('amount')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="field-group md:col-span-2">
        <label for="description" class="field-label">Descricao</label>
        <input type="text" name="description" id="description" value="{{ old('description', $financial->description ?? '') }}" class="field-input" required>
        @error('description')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="field-group">
        <label for="due_date" class="field-label">Data de vencimento</label>
        <input type="date" name="due_date" id="due_date" value="{{ old('due_date', isset($financial?->due_date) ? $financial->due_date->format('Y-m-d') : '') }}" class="field-input">
        @error('due_date')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="field-group">
        <label for="paid_at" class="field-label">Data de pagamento</label>
        <input type="date" name="paid_at" id="paid_at" value="{{ old('paid_at', isset($financial?->paid_at) ? $financial->paid_at->format('Y-m-d') : '') }}" class="field-input">
        @error('paid_at')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="field-group">
        <label for="status" class="field-label">Status</label>
        <select name="status" id="status" class="field-input" required>
            <option value="pending" {{ old('status', $financial->status ?? 'pending') === 'pending' ? 'selected' : '' }}>Pendente</option>
            <option value="paid" {{ old('status', $financial->status ?? '') === 'paid' ? 'selected' : '' }}>Pago</option>
            <option value="overdue" {{ old('status', $financial->status ?? '') === 'overdue' ? 'selected' : '' }}>Atrasado</option>
        </select>
        @error('status')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="field-group md:col-span-2">
        <label for="notes" class="field-label">Observacoes</label>
        <textarea name="notes" id="notes" rows="4" class="field-input">{{ old('notes', $financial->notes ?? '') }}</textarea>
        @error('notes')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>
</div>
