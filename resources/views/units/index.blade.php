<x-layouts::app>
    <div class="p-6">
        <div class="page-header">
            <div>
                <h1 class="page-title">Unidades</h1>
                <p class="page-subtitle">Gerencie as unidades vinculadas aos empreendimentos cadastrados.</p>
            </div>

            <a href="{{ route('units.create') }}" class="primary-button">
                Nova unidade
            </a>
        </div>

        @if (session('success'))
            <div class="success-alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-card">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-800">
                    <thead class="bg-zinc-50 dark:bg-zinc-800">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">Empreendimento</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">Unidade</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">Tipo</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">Bloco/Andar</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">Valor</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">Status</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-zinc-500">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                        @forelse ($units as $unit)
                            <tr>
                                <td class="px-6 py-4 text-sm text-zinc-700 dark:text-zinc-200">
                                    {{ $unit->development->name }}
                                </td>
                                <td class="px-6 py-4 text-sm text-zinc-700 dark:text-zinc-200">
                                    <div class="font-semibold">{{ $unit->identifier }}</div>
                                    @if ($unit->private_area || $unit->total_area)
                                        <div class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">
                                            @if ($unit->private_area)
                                                Privativa: {{ number_format((float) $unit->private_area, 2, ',', '.') }} m²
                                            @endif
                                            @if ($unit->private_area && $unit->total_area)
                                                ·
                                            @endif
                                            @if ($unit->total_area)
                                                Total: {{ number_format((float) $unit->total_area, 2, ',', '.') }} m²
                                            @endif
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-zinc-600 dark:text-zinc-300">
                                    {{ $unit->type }}
                                </td>
                                <td class="px-6 py-4 text-sm text-zinc-600 dark:text-zinc-300">
                                    {{ $unit->block ?: '-' }} / {{ $unit->floor ?: '-' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-zinc-600 dark:text-zinc-300">
                                    {{ $unit->price ? 'R$ '.number_format((float) $unit->price, 2, ',', '.') : '-' }}
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    @php
                                        $statusClasses = match($unit->status) {
                                            'available' => 'bg-green-100 text-green-700',
                                            'reserved' => 'bg-yellow-100 text-yellow-700',
                                            'sold' => 'bg-blue-100 text-blue-700',
                                            'blocked' => 'bg-red-100 text-red-700',
                                            default => 'bg-zinc-100 text-zinc-700',
                                        };

                                        $statusLabels = [
                                            'available' => 'Disponível',
                                            'reserved' => 'Reservado',
                                            'sold' => 'Vendido',
                                            'blocked' => 'Bloqueado',
                                        ];
                                    @endphp

                                    <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $statusClasses }}">
                                        {{ $statusLabels[$unit->status] ?? $unit->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('units.edit', $unit) }}" class="action-icon action-icon--edit" title="Editar">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487a2.1 2.1 0 1 1 2.97 2.97L8.25 19.04 4 20l.96-4.25 11.902-11.263Z" />
                                            </svg>
                                        </a>

                                        <form action="{{ route('units.destroy', $unit) }}" method="POST" onsubmit="return confirm('Deseja realmente excluir esta unidade?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="action-icon action-icon--delete" title="Excluir">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 7h12M9 7V5.75A1.75 1.75 0 0 1 10.75 4h2.5A1.75 1.75 0 0 1 15 5.75V7m-7 0 1 11.25A1.75 1.75 0 0 0 10.74 20h2.52A1.75 1.75 0 0 0 15 18.25L16 7" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center text-sm text-zinc-500 dark:text-zinc-400">
                                    Nenhuma unidade cadastrada.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="border-t border-zinc-100 px-6 py-4 dark:border-zinc-800">
                {{ $units->links() }}
            </div>
        </div>
    </div>
</x-layouts::app>
