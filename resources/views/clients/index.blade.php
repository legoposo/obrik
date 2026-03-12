<x-layouts::app :title="__('Clientes')">
    @php
        $statusMap = [
            'lead' => ['label' => 'Lead', 'class' => 'bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-200'],
            'interessado' => ['label' => 'Interessado', 'class' => 'bg-blue-100 text-blue-700 dark:bg-blue-950/40 dark:text-blue-300'],
            'comprador' => ['label' => 'Comprador', 'class' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300'],
            'pos_venda' => ['label' => 'Pos-venda', 'class' => 'bg-violet-100 text-violet-700 dark:bg-violet-950/40 dark:text-violet-300'],
        ];

        $selectedDevelopment = $developmentId ? $developments->firstWhere('id', $developmentId) : null;
    @endphp

    <div class="p-6 space-y-6">
        <div class="page-header">
            <div>
                <h1 class="page-title">Clientes</h1>
                <p class="page-subtitle">Concentre o relacionamento comercial e o historico dos clientes ligados aos empreendimentos e unidades da incorporadora.</p>
            </div>

            <div class="flex flex-col gap-3 sm:flex-row">
                @if ($selectedDevelopment)
                    <a href="{{ route('developments.show', $selectedDevelopment) }}" class="ghost-button">Voltar ao empreendimento</a>
                @endif
                <a href="{{ route('clients.create') }}" class="primary-button">Novo cliente</a>
            </div>
        </div>

        @if (session('success'))
            <div class="success-alert">{{ session('success') }}</div>
        @endif

        <div class="panel-card">
            <div class="panel-card__body">
                <form action="{{ route('clients.index') }}" method="GET" class="space-y-4">
                    <div class="grid gap-4 lg:grid-cols-[minmax(0,1.2fr)_240px_240px_auto] lg:items-end">
                        <div class="field-group">
                            <label for="search" class="field-label">Buscar cliente</label>
                            <input id="search" type="text" name="search" value="{{ $search }}" class="field-input" placeholder="Nome, e-mail, telefone ou documento">
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
                                @foreach ($statusMap as $value => $statusData)
                                    <option value="{{ $value }}" @selected($status === $value)>{{ $statusData['label'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex gap-3">
                            <button type="submit" class="primary-button">Filtrar</button>
                            @if ($search !== '' || $status !== '' || $developmentId)
                                <a href="{{ route('clients.index') }}" class="ghost-button">Limpar</a>
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
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">Cliente</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">Contato</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">Documento</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">Empreendimentos</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">Contratos</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-zinc-500">Acoes</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                        @forelse ($clients as $client)
                            @php
                                $statusData = $statusMap[$client->status] ?? ['label' => ucfirst(str_replace('_', ' ', $client->status ?: 'lead')), 'class' => 'bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-200'];
                            @endphp

                            <tr class="report-table-row align-top">
                                <td class="px-6 py-4 text-sm text-zinc-700 dark:text-zinc-200">
                                    <div class="font-semibold text-zinc-900 dark:text-white">{{ $client->name }}</div>
                                    @if ($client->notes)
                                        <p class="mt-2 max-w-xs text-xs leading-5 text-zinc-500 dark:text-zinc-400">{{ \Illuminate\Support\Str::limit($client->notes, 88) }}</p>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-zinc-600 dark:text-zinc-300">
                                    <div>{{ $client->phone ?: '-' }}</div>
                                    <div class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">{{ $client->email ?: 'Sem e-mail' }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm text-zinc-600 dark:text-zinc-300">{{ $client->document ?: $client->cpf ?: '-' }}</td>
                                <td class="px-6 py-4 text-sm text-zinc-600 dark:text-zinc-300">
                                    @if ($client->developments->isNotEmpty())
                                        {{ $client->developments->take(2)->pluck('name')->join(', ') }}@if ($client->developments->count() > 2) +{{ $client->developments->count() - 2 }} @endif
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $statusData['class'] }}">{{ $statusData['label'] }}</span>
                                </td>
                                <td class="px-6 py-4 text-sm text-zinc-600 dark:text-zinc-300">{{ number_format($client->contracts_count, 0, ',', '.') }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('contracts.create') }}" class="action-icon border-emerald-200 bg-emerald-50 text-emerald-600 hover:border-emerald-300 hover:bg-emerald-100 hover:text-emerald-700 focus:ring-emerald-500/20 dark:border-emerald-900/60 dark:bg-emerald-950/40 dark:text-emerald-300 dark:hover:bg-emerald-900/40" title="Nova reserva/contrato">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                            </svg>
                                        </a>

                                        <a href="{{ route('clients.edit', $client) }}" class="action-icon action-icon--edit" title="Editar cliente">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487a2.1 2.1 0 1 1 2.97 2.97L8.25 19.04 4 20l.96-4.25 11.902-11.263Z" />
                                            </svg>
                                        </a>

                                        <form action="{{ route('clients.destroy', $client) }}" method="POST" onsubmit="return confirm('Deseja realmente excluir este cliente?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="action-icon action-icon--delete" title="Excluir cliente">
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
                                <td colspan="7" class="px-6 py-10 text-center text-sm text-zinc-500 dark:text-zinc-400">
                                    Nenhum cliente encontrado para os filtros informados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="border-t border-zinc-100 px-6 py-4 dark:border-zinc-800">
                {{ $clients->links() }}
            </div>
        </div>
    </div>
</x-layouts::app>