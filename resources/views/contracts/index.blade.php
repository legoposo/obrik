<x-layouts::app :title="__('Reservas / Contratos')">
    @php
        $statusMap = [
            'reserva' => ['label' => 'Reserva', 'class' => 'bg-amber-100 text-amber-700 dark:bg-amber-950/40 dark:text-amber-300'],
            'proposta' => ['label' => 'Proposta', 'class' => 'bg-blue-100 text-blue-700 dark:bg-blue-950/40 dark:text-blue-300'],
            'contrato_assinado' => ['label' => 'Contrato assinado', 'class' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300'],
            'cancelado' => ['label' => 'Cancelado', 'class' => 'bg-red-100 text-red-700 dark:bg-red-950/40 dark:text-red-300'],
            'concluido' => ['label' => 'Concluido', 'class' => 'bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-200'],
        ];

        $selectedDevelopment = $developmentId ? $developments->firstWhere('id', $developmentId) : null;
    @endphp

    <div class="p-6 space-y-6">
        <div class="page-header">
            <div>
                <h1 class="page-title">Reservas / Contratos</h1>
                <p class="page-subtitle">Acompanhe a jornada comercial entre clientes e unidades, desde a reserva ate a conclusao do contrato.</p>
            </div>

            <div class="flex flex-col gap-3 sm:flex-row">
                @if ($selectedDevelopment)
                    <a href="{{ route('developments.show', $selectedDevelopment) }}" class="ghost-button">Voltar ao empreendimento</a>
                @endif
                <a href="{{ route('contracts.create', array_filter(['development_id' => $developmentId])) }}" class="primary-button">Nova reserva / contrato</a>
            </div>
        </div>

        @if (session('success'))
            <div class="success-alert">{{ session('success') }}</div>
        @endif

        <div class="panel-card">
            <div class="panel-card__body">
                <form action="{{ route('contracts.index') }}" method="GET" class="space-y-4">
                    <div class="grid gap-4 lg:grid-cols-[minmax(0,1.2fr)_240px_240px_auto] lg:items-end">
                        <div class="field-group">
                            <label for="search" class="field-label">Buscar operacao</label>
                            <input id="search" type="text" name="search" value="{{ $search }}" class="field-input" placeholder="Cliente, unidade, contrato ou empreendimento">
                        </div>

                        <div class="field-group">
                            <label for="development_id" class="field-label">Empreendimento</label>
                            <select id="development_id" name="development_id" class="field-input">
                                <option value="">Todos</option>
                                @foreach ($developments as $developmentOption)
                                    <option value="{{ $developmentOption->id }}" @selected((string) $developmentId === (string) $developmentOption->id)>{{ $developmentOption->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="field-group">
                            <label for="status" class="field-label">Status</label>
                            <select id="status" name="status" class="field-input">
                                <option value="">Todos</option>
                                @foreach ($statusOptions as $value => $label)
                                    <option value="{{ $value }}" @selected($status === $value)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex gap-3">
                            <button type="submit" class="primary-button">Filtrar</button>
                            @if ($search !== '' || $status !== '' || $developmentId)
                                <a href="{{ route('contracts.index') }}" class="ghost-button">Limpar</a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="table-card">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-800">
                    <thead class="bg-zinc-50 dark:bg-zinc-800">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">Operacao</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">Cliente</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">Unidade</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">Empreendimento</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">Valor</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">Data</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-zinc-500">Acoes</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                        @forelse ($contracts as $contract)
                            @php
                                $statusData = $statusMap[$contract->status] ?? ['label' => ucfirst(str_replace('_', ' ', $contract->status)), 'class' => 'bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-200'];
                            @endphp

                            <tr class="report-table-row align-top">
                                <td class="px-6 py-4 text-sm text-zinc-700 dark:text-zinc-200">
                                    <div class="font-semibold text-zinc-900 dark:text-white">{{ $contract->contract_number }}</div>
                                    @if ($contract->notes)
                                        <p class="mt-2 max-w-xs text-xs leading-5 text-zinc-500 dark:text-zinc-400">{{ \Illuminate\Support\Str::limit($contract->notes, 88) }}</p>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-zinc-700 dark:text-zinc-200">{{ $contract->client->name ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm text-zinc-600 dark:text-zinc-300">
                                    <div class="font-semibold text-zinc-900 dark:text-white">Unidade {{ $contract->unit->unit_number ?? $contract->unit->identifier ?? '-' }}</div>
                                    <div class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">{{ $contract->unit->block_or_tower ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm text-zinc-600 dark:text-zinc-300">{{ $contract->development->name ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm text-zinc-600 dark:text-zinc-300">{{ $contract->value ? 'R$ '.number_format((float) $contract->value, 2, ',', '.') : '-' }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $statusData['class'] }}">{{ $statusData['label'] }}</span>
                                </td>
                                <td class="px-6 py-4 text-sm text-zinc-600 dark:text-zinc-300">{{ $contract->contract_date?->format('d/m/Y') ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('contracts.print', $contract) }}" class="action-icon border-zinc-200 bg-white text-zinc-700 hover:border-zinc-300 hover:bg-zinc-50 hover:text-zinc-900 focus:ring-zinc-400/20 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-200 dark:hover:bg-zinc-800" title="Gerar PDF" target="_blank">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v3A2.25 2.25 0 0 1 17.25 19.5H6.75A2.25 2.25 0 0 1 4.5 17.25v-3m15-3-3.879-3.879a1.5 1.5 0 0 0-1.06-.44H9.44a1.5 1.5 0 0 0-1.06.44L4.5 11.25m15 0h-3.75m3.75 0v-6A2.25 2.25 0 0 0 17.25 3H6.75A2.25 2.25 0 0 0 4.5 5.25v6m0 0h3.75m3 1.5h1.5" />
                                            </svg>
                                        </a>

                                        <a href="{{ route('contracts.edit', $contract) }}" class="action-icon action-icon--edit" title="Editar operacao">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487a2.1 2.1 0 1 1 2.97 2.97L8.25 19.04 4 20l.96-4.25 11.902-11.263Z" />
                                            </svg>
                                        </a>

                                        <form action="{{ route('contracts.destroy', $contract) }}" method="POST" onsubmit="return confirm('Deseja realmente excluir esta operacao?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="action-icon action-icon--delete" title="Excluir operacao">
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
                                <td colspan="8" class="px-6 py-10 text-center text-sm text-zinc-500 dark:text-zinc-400">
                                    Nenhuma reserva ou contrato encontrado para os filtros informados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="border-t border-zinc-100 px-6 py-4 dark:border-zinc-800">
                {{ $contracts->links() }}
            </div>
        </div>
    </div>
</x-layouts::app>