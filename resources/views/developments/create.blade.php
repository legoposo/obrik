<x-layouts::app>
    <div class="space-y-6">
        <div>
            <h1 class="text-3xl font-bold text-zinc-900">Novo empreendimento</h1>
            <p class="mt-1 text-sm text-zinc-500">
                Cadastre um novo condomínio ou edifício.
            </p>
        </div>

        <div class="rounded-2xl border border-zinc-200 bg-white p-8 shadow-sm">
            <form action="{{ route('developments.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <label for="builder_id" class="mb-2 block text-sm font-medium text-zinc-700">
                            Construtora
                        </label>
                        <select
                            name="builder_id"
                            id="builder_id"
                            class="w-full rounded-xl border border-zinc-300 bg-white px-4 py-3 text-sm text-zinc-900 shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                        >
                            <option value="">Selecione</option>
                            @foreach ($builders as $builder)
                                <option value="{{ $builder->id }}" @selected(old('builder_id') == $builder->id)>
                                    {{ $builder->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('builder_id')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="name" class="mb-2 block text-sm font-medium text-zinc-700">
                            Nome
                        </label>
                        <input
                            type="text"
                            name="name"
                            id="name"
                            value="{{ old('name') }}"
                            class="w-full rounded-xl border border-zinc-300 bg-white px-4 py-3 text-sm text-zinc-900 shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                        >
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="type" class="mb-2 block text-sm font-medium text-zinc-700">
                            Tipo
                        </label>
                        <select
                            name="type"
                            id="type"
                            class="w-full rounded-xl border border-zinc-300 bg-white px-4 py-3 text-sm text-zinc-900 shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                        >
                            <option value="">Selecione</option>
                            <option value="houses" @selected(old('type') === 'houses')>Casas</option>
                            <option value="apartments" @selected(old('type') === 'apartments')>Apartamentos</option>
                        </select>
                        @error('type')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="status" class="mb-2 block text-sm font-medium text-zinc-700">
                            Status
                        </label>
                        <select
                            name="status"
                            id="status"
                            class="w-full rounded-xl border border-zinc-300 bg-white px-4 py-3 text-sm text-zinc-900 shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                        >
                            <option value="planning" @selected(old('status') === 'planning')>Planejamento</option>
                            <option value="in_progress" @selected(old('status') === 'in_progress')>Em andamento</option>
                            <option value="paused" @selected(old('status') === 'paused')>Pausado</option>
                            <option value="completed" @selected(old('status') === 'completed')>Concluído</option>
                            <option value="canceled" @selected(old('status') === 'canceled')>Cancelado</option>
                        </select>
                        @error('status')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="city" class="mb-2 block text-sm font-medium text-zinc-700">
                            Cidade
                        </label>
                        <input
                            type="text"
                            name="city"
                            id="city"
                            value="{{ old('city') }}"
                            class="w-full rounded-xl border border-zinc-300 bg-white px-4 py-3 text-sm text-zinc-900 shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                        >
                        @error('city')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="state" class="mb-2 block text-sm font-medium text-zinc-700">
                            Estado
                        </label>
                        <input
                            type="text"
                            name="state"
                            id="state"
                            maxlength="2"
                            value="{{ old('state') }}"
                            class="w-full rounded-xl border border-zinc-300 bg-white px-4 py-3 text-sm uppercase text-zinc-900 shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                        >
                        @error('state')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="address" class="mb-2 block text-sm font-medium text-zinc-700">
                            Endereço
                        </label>
                        <input
                            type="text"
                            name="address"
                            id="address"
                            value="{{ old('address') }}"
                            class="w-full rounded-xl border border-zinc-300 bg-white px-4 py-3 text-sm text-zinc-900 shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                        >
                        @error('address')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="start_date" class="mb-2 block text-sm font-medium text-zinc-700">
                            Data de início
                        </label>
                        <input
                            type="date"
                            name="start_date"
                            id="start_date"
                            value="{{ old('start_date') }}"
                            class="w-full rounded-xl border border-zinc-300 bg-white px-4 py-3 text-sm text-zinc-900 shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                        >
                        @error('start_date')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="expected_delivery_date" class="mb-2 block text-sm font-medium text-zinc-700">
                            Previsão de entrega
                        </label>
                        <input
                            type="date"
                            name="expected_delivery_date"
                            id="expected_delivery_date"
                            value="{{ old('expected_delivery_date') }}"
                            class="w-full rounded-xl border border-zinc-300 bg-white px-4 py-3 text-sm text-zinc-900 shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                        >
                        @error('expected_delivery_date')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="description" class="mb-2 block text-sm font-medium text-zinc-700">
                            Descrição
                        </label>
                        <textarea
                            name="description"
                            id="description"
                            rows="4"
                            class="w-full rounded-xl border border-zinc-300 bg-white px-4 py-3 text-sm text-zinc-900 shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                        >{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-2">
                    <a
                        href="{{ route('developments.index') }}"
                        class="rounded-xl border border-zinc-300 bg-white px-5 py-2.5 text-sm font-medium text-zinc-700 transition hover:bg-zinc-50"
                    >
                        Cancelar
                    </a>

                    <button
                        type="submit"
                        class="rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700"
                    >
                        Salvar empreendimento
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts::app>