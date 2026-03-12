<x-layouts::app :title="__('Obras')">
    <div class="p-6">
        <div class="page-header">
            <div>
                <h1 class="page-title">Obras</h1>
                <p class="page-subtitle">Gerencie as obras cadastradas no sistema e acompanhe o cronograma de cada uma.</p>
            </div>

            <a href="{{ route('works.create') }}" class="primary-button">Nova Obra</a>
        </div>

        @if (session('success'))
            <div class="success-alert">{{ session('success') }}</div>
        @endif

        <div class="table-card">
            <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-800">
                <thead class="bg-zinc-50 dark:bg-zinc-800">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">Obra</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">Cliente</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">Inicio</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">Previsao</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-zinc-500">Acoes</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                    @forelse ($works as $work)
                        @php
                            $statusMap = [
                                'planning' => ['label' => 'Planejamento', 'class' => 'bg-zinc-100 text-zinc-700'],
                                'in_progress' => ['label' => 'Em andamento', 'class' => 'bg-blue-100 text-blue-700'],
                                'paused' => ['label' => 'Pausada', 'class' => 'bg-yellow-100 text-yellow-700'],
                                'finished' => ['label' => 'Concluida', 'class' => 'bg-green-100 text-green-700'],
                                'canceled' => ['label' => 'Cancelada', 'class' => 'bg-red-100 text-red-700'],
                            ];

                            $status = $statusMap[$work->status] ?? ['label' => $work->status, 'class' => 'bg-zinc-100 text-zinc-700'];
                            $progressPercentage = $work->stages_count > 0 ? (int) round(($work->completed_stages_count / $work->stages_count) * 100) : 0;
                        @endphp

                        <tr class="report-table-row">
                            <td class="px-6 py-4 text-sm text-zinc-700 dark:text-zinc-200">
                                <div class="font-semibold text-zinc-800 dark:text-zinc-100">{{ $work->name }}</div>
                                <div class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">
                                    {{ number_format($work->stages_count, 0, ',', '.') }} etapas cadastradas
                                    @if ($work->stages_count > 0)
                                        | {{ $progressPercentage }}% concluidas
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-zinc-700 dark:text-zinc-200">{{ $work->client->name ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-zinc-700 dark:text-zinc-200">
                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-medium {{ $status['class'] }}">{{ $status['label'] }}</span>
                            </td>
                            <td class="px-6 py-4 text-sm text-zinc-700 dark:text-zinc-200">{{ $work->start_date?->format('d/m/Y') ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-zinc-700 dark:text-zinc-200">{{ $work->expected_end_date?->format('d/m/Y') ?? '-' }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('works.stages.index', $work) }}" class="action-icon action-icon--timeline" title="Cronograma" aria-label="Abrir cronograma da obra">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M7.5 3.75v6m9-6v6M6.75 12.75h3.75v3.75H6.75v-3.75Zm6.75 0h3.75v3.75H13.5v-3.75Z" />
                                        </svg>
                                    </a>

                                    <a href="{{ route('works.edit', $work->id) }}" class="action-icon action-icon--edit" title="Editar" aria-label="Editar obra">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487a2.1 2.1 0 1 1 2.97 2.97L8.25 19.04 4 20l.96-4.25 11.902-11.263Z" />
                                        </svg>
                                    </a>

                                    <form action="{{ route('works.destroy', $work->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta obra?');">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="action-icon action-icon--delete" title="Excluir" aria-label="Excluir obra">
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
                            <td colspan="6" class="px-6 py-4 text-center text-sm text-zinc-700 dark:text-zinc-200">Nenhuma obra cadastrada ainda</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $works->links() }}</div>
    </div>
</x-layouts::app>
