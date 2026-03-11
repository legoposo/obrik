<x-layouts::app>

<div class="space-y-6">

    <div>
        <h1 class="text-3xl font-bold text-zinc-900">Editar empreendimento</h1>
        <p class="mt-1 text-sm text-zinc-500">
            Atualize os dados do empreendimento.
        </p>
    </div>

    <div class="rounded-2xl border border-zinc-200 bg-white p-8 shadow-sm">

        <form action="{{ route('developments.update', $development) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                {{-- Construtora --}}
                <div>
                    <label class="mb-2 block text-sm font-medium text-zinc-700">
                        Construtora
                    </label>

                    <select
                        name="builder_id"
                        class="w-full rounded-xl border border-zinc-300 bg-white px-4 py-3 text-sm text-zinc-900 shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >
                        <option value="">Selecione</option>

                        @foreach ($builders as $builder)
                            <option
                                value="{{ $builder->id }}"
                                @selected(old('builder_id', $development->builder_id) == $builder->id)
                            >
                                {{ $builder->name }}
                            </option>
                        @endforeach

                    </select>

                    @error('builder_id')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Nome --}}
                <div>
                    <label class="mb-2 block text-sm font-medium text-zinc-700">
                        Nome
                    </label>

                    <input
                        type="text"
                        name="name"
                        value="{{ old('name', $development->name) }}"
                        class="w-full rounded-xl border border-zinc-300 bg-white px-4 py-3 text-sm text-zinc-900 shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >

                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tipo --}}
                <div>
                    <label class="mb-2 block text-sm font-medium text-zinc-700">
                        Tipo
                    </label>

                    <select
                        name="type"
                        class="w-full rounded-xl border border-zinc-300 bg-white px-4 py-3 text-sm text-zinc-900 shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >

                        <option value="houses"
                            @selected(old('type', $development->type) === 'houses')
                        >
                            Casas
                        </option>

                        <option value="apartments"
                            @selected(old('type', $development->type) === 'apartments')
                        >
                            Apartamentos
                        </option>

                    </select>

                    @error('type')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Status --}}
                <div>
                    <label class="mb-2 block text-sm font-medium text-zinc-700">
                        Status
                    </label>

                    <select
                        name="status"
                        class="w-full rounded-xl border border-zinc-300 bg-white px-4 py-3 text-sm text-zinc-900 shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >

                        <option value="planning"
                            @selected(old('status', $development->status) === 'planning')
                        >
                            Planejamento
                        </option>

                        <option value="in_progress"
                            @selected(old('status', $development->status) === 'in_progress')
                        >
                            Em andamento
                        </option>

                        <option value="paused"
                            @selected(old('status', $development->status) === 'paused')
                        >
                            Pausado
                        </option>

                        <option value="completed"
                            @selected(old('status', $development->status) === 'completed')
                        >
                            Concluído
                        </option>

                        <option value="canceled"
                            @selected(old('status', $development->status) === 'canceled')
                        >
                            Cancelado
                        </option>

                    </select>

                    @error('status')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Cidade --}}
                <div>
                    <label class="mb-2 block text-sm font-medium text-zinc-700">
                        Cidade
                    </label>

                    <input
                        type="text"
                        name="city"
                        value="{{ old('city', $development->city) }}"
                        class="w-full rounded-xl border border-zinc-300 bg-white px-4 py-3 text-sm text-zinc-900 shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >

                    @error('city')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Estado --}}
                <div>
                    <label class="mb-2 block text-sm font-medium text-zinc-700">
                        Estado (UF)
                    </label>

                    <input
                        type="text"
                        name="state"
                        maxlength="2"
                        value="{{ old('state', $development->state) }}"
                        class="w-full rounded-xl border border-zinc-300 bg-white px-4 py-3 text-sm uppercase text-zinc-900 shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >

                    @error('state')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Endereço --}}
                <div class="md:col-span-2">
                    <label class="mb-2 block text-sm font-medium text-zinc-700">
                        Endereço
                    </label>

                    <input
                        type="text"
                        name="address"
                        value="{{ old('address', $development->address) }}"
                        class="w-full rounded-xl border border-zinc-300 bg-white px-4 py-3 text-sm text-zinc-900 shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >

                    @error('address')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Data início --}}
                <div>
                    <label class="mb-2 block text-sm font-medium text-zinc-700">
                        Data de início
                    </label>

                    <input
                        type="date"
                        name="start_date"
                        value="{{ old('start_date', optional($development->start_date)->format('Y-m-d')) }}"
                        class="w-full rounded-xl border border-zinc-300 bg-white px-4 py-3 text-sm text-zinc-900 shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >

                    @error('start_date')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Previsão entrega --}}
                <div>
                    <label class="mb-2 block text-sm font-medium text-zinc-700">
                        Previsão de entrega
                    </label>

                    <input
                        type="date"
                        name="expected_delivery_date"
                        value="{{ old('expected_delivery_date', optional($development->expected_delivery_date)->format('Y-m-d')) }}"
                        class="w-full rounded-xl border border-zinc-300 bg-white px-4 py-3 text-sm text-zinc-900 shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >

                    @error('expected_delivery_date')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Descrição --}}
                <div class="md:col-span-2">
                    <label class="mb-2 block text-sm font-medium text-zinc-700">
                        Descrição
                    </label>

                    <textarea
                        name="description"
                        rows="4"
                        class="w-full rounded-xl border border-zinc-300 bg-white px-4 py-3 text-sm text-zinc-900 shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >{{ old('description', $development->description) }}</textarea>

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
                    Atualizar empreendimento
                </button>

            </div>

        </form>

    </div>

</div>

</x-layouts::app>