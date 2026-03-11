<x-layouts::app>
    <div class="p-6">
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-zinc-800 dark:text-white">
                    Empreendimentos
                </h1>
                <p class="mt-1 text-sm text-zinc-500">
                    Gerencie os condomínios e edifícios cadastrados.
                </p>
                </div>

            <a href="{{ route('developments.create') }}"
               class="inline-flex items-center rounded-xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
                Novo empreendimento
            </a>
        </div>

        @if (session('success'))
            <div class="rounded-2xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-hidden rounded-2xl bg-white shadow">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-zinc-200">
                    <thead class="bg-zinc-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">Nome</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">Construtora</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">Tipo</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">Cidade/UF</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">Status</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-zinc-500">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                        @forelse ($developments as $development)
                            <tr class="hover:bg-zinc-50">
                                <td class="px-6 py-4 text-sm text-zinc-700 dark:text-zinc-200">
                                    {{ $development->name }}
                                </td>
                                <td class="px-6 py-4 text-sm text-zinc-600">
                                    {{ $development->builder->name ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-zinc-600">
                                    {{ $development->type === 'houses' ? 'Casas' : 'Apartamentos' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-zinc-600">
                                    {{ $development->city }}/{{ $development->state }}
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    @php
                                        $statusClasses = match($development->status) {
                                            'planning' => 'bg-zinc-100 text-zinc-700',
                                            'in_progress' => 'bg-blue-100 text-blue-700',
                                            'paused' => 'bg-yellow-100 text-yellow-700',
                                            'completed' => 'bg-green-100 text-green-700',
                                            'canceled' => 'bg-red-100 text-red-700',
                                            default => 'bg-zinc-100 text-zinc-700',
                                        };

                                        $statusLabels = [
                                            'planning' => 'Planejamento',
                                            'in_progress' => 'Em andamento',
                                            'paused' => 'Pausado',
                                            'completed' => 'Concluído',
                                            'canceled' => 'Cancelado',
                                        ];
                                    @endphp

                                    <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $statusClasses }}">
                                        {{ $statusLabels[$development->status] ?? $development->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-end gap-3">
                                        <a href="{{ route('developments.edit', $development) }}"
                                           class="text-blue-600 hover:text-blue-800"
                                           title="Editar">
                                            ✏️
                                        </a>

                                        <form action="{{ route('developments.destroy', $development) }}" method="POST"
                                              onsubmit="return confirm('Deseja realmente excluir este empreendimento?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="text-red-600 hover:text-red-800"
                                                    title="Excluir">
                                                🗑️
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-sm text-zinc-500">
                                    Nenhum empreendimento cadastrado.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="border-t border-zinc-100 px-6 py-4">
                {{ $developments->links() }}
            </div>
        </div>
    </div>
</x-layouts::app>