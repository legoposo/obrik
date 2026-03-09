<x-layouts::app :title="__('Nova Obra')">
    <div class="p-6">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-zinc-800 dark:text-white">
                Nova Obra
            </h1>
            <p class="mt-1 text-sm text-zinc-500">
                Preencha os dados para cadastrar uma nova obra.
            </p>
        </div>

        <div class="rounded-2xl bg-white p-6 shadow dark:bg-zinc-900">
            <form action="{{ route('works.store') }}" method="POST" class="grid grid-cols-1 gap-6 md:grid-cols-2">
                @csrf

                <div>
                    <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-200">Cliente</label>
                    <select id="client_id" name="client_id"
    class="w-full rounded-xl border border-zinc-300 px-4 py-2 focus:border-blue-500 focus:outline-none dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
    <                   option value="">Selecione um cliente</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}" @selected(old('client_id', $work->client_id ?? '') == $client->id)>
                            {{ $client->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('client_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-200">Nome da obra</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        class="w-full rounded-xl border border-zinc-300 px-4 py-2 focus:border-blue-500 focus:outline-none dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-200">Endereço</label>
                    <input type="text" name="address" value="{{ old('address') }}" autocomplete="off"
                        class="w-full rounded-xl border border-zinc-300 px-4 py-2 focus:border-blue-500 focus:outline-none dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-200">Cidade</label>
                    <input type="text" name="city" value="{{ old('city') }}"
                        class="w-full rounded-xl border border-zinc-300 px-4 py-2 focus:border-blue-500 focus:outline-none dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-200">Estado</label>
                    <input type="text" name="state" value="{{ old('state') }}" maxlength="2"
                        class="w-full rounded-xl border border-zinc-300 px-4 py-2 focus:border-blue-500 focus:outline-none dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-200">Data de início</label>
                    <input type="date" name="start_date" value="{{ old('start_date') }}"
                        class="w-full rounded-xl border border-zinc-300 px-4 py-2 focus:border-blue-500 focus:outline-none dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-200">Previsão de término</label>
                    <input type="date" name="expected_end_date" value="{{ old('expected_end_date') }}"
                        class="w-full rounded-xl border border-zinc-300 px-4 py-2 focus:border-blue-500 focus:outline-none dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-200">CEP</label>
                    <input type="text" name="zip_code" value="{{ old('zip_code') }}"
                        class="w-full rounded-xl border border-zinc-300 px-4 py-2 focus:border-blue-500 focus:outline-none dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-200">Orçamento</label>
                    <input type="number" step="0.01" name="budget" value="{{ old('budget') }}"
                        class="w-full rounded-xl border border-zinc-300 px-4 py-2 focus:border-blue-500 focus:outline-none dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-200">Status</label>
                    <select name="status"
                        class="w-full rounded-xl border border-zinc-300 px-4 py-2 focus:border-blue-500 focus:outline-none dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                        <option value="planning" @selected(old('status') == 'planning')>Planejamento</option>
                        <option value="in_progress" @selected(old('status') == 'in_progress')>Em andamento</option>
                        <option value="paused" @selected(old('status') == 'paused')>Pausada</option>
                        <option value="finished" @selected(old('status') == 'finished')>Concluída</option>
                        <option value="canceled" @selected(old('status') == 'canceled')>Cancelada</option>
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-200">Observações</label>
                    <textarea name="notes" rows="4"
                        class="w-full rounded-xl border border-zinc-300 px-4 py-2 focus:border-blue-500 focus:outline-none dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">{{ old('notes') }}</textarea>
                </div>

                <div class="md:col-span-2 flex justify-end gap-3">
                    <a href="{{ route('works.index') }}"
                       class="rounded-xl border border-zinc-300 px-4 py-2 text-sm font-medium text-zinc-700 hover:bg-zinc-100 dark:border-zinc-700 dark:text-zinc-200 dark:hover:bg-zinc-800">
                        Cancelar
                    </a>

                    <button type="submit"
                        class="rounded-xl bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">
                        Salvar Obra
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts::app>