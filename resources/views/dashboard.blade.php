<x-layouts::app :title="__('Dashboard')">
    @php
        $metrics = [
            ['label' => 'Empreendimentos', 'value' => $developmentsCount, 'class' => 'border-blue-200 bg-blue-50/70 text-blue-700'],
            ['label' => 'Unidades disponiveis', 'value' => $availableUnitsCount, 'class' => 'border-emerald-200 bg-emerald-50/70 text-emerald-700'],
            ['label' => 'Unidades reservadas', 'value' => $reservedUnitsCount, 'class' => 'border-amber-200 bg-amber-50/70 text-amber-700'],
            ['label' => 'Unidades vendidas', 'value' => $soldUnitsCount, 'class' => 'border-rose-200 bg-rose-50/70 text-rose-700'],
            ['label' => 'Clientes cadastrados', 'value' => $clientsCount, 'class' => 'border-violet-200 bg-violet-50/70 text-violet-700'],
            ['label' => 'Contratos ativos', 'value' => $activeContractsCount, 'class' => 'border-zinc-200 bg-zinc-50 text-zinc-700'],
        ];

        $contractStatusMap = [
            'reserva' => 'bg-amber-100 text-amber-700 dark:bg-amber-950/40 dark:text-amber-300',
            'proposta' => 'bg-blue-100 text-blue-700 dark:bg-blue-950/40 dark:text-blue-300',
            'contrato_assinado' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300',
            'cancelado' => 'bg-red-100 text-red-700 dark:bg-red-950/40 dark:text-red-300',
            'concluido' => 'bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-200',
        ];
    @endphp

    <div class="p-6 lg:p-10 space-y-8 bg-zinc-50/50 dark:bg-zinc-950 min-h-screen">
        <div class="page-header">
            <div>
                <h1 class="page-title">Painel da Incorporadora</h1>
                <p class="page-subtitle">A OBRYN agora organiza a operacao da incorporadora em torno dos empreendimentos, unidades, clientes e contratos.</p>
            </div>
        </div>

        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
            @foreach ($metrics as $metric)
                <div class="rounded-3xl border p-6 shadow-sm {{ $metric['class'] }} dark:border-zinc-800 dark:bg-zinc-900 dark:text-white">
                    <p class="text-xs font-semibold uppercase tracking-[0.18em] opacity-80">{{ $metric['label'] }}</p>
                    <p class="mt-3 text-4xl font-bold tracking-tight">{{ number_format($metric['value'], 0, ',', '.') }}</p>
                </div>
            @endforeach
        </div>

        <div class="grid gap-6 xl:grid-cols-2">
            <div class="table-card">
                <div class="border-b border-zinc-100 px-6 py-5 dark:border-zinc-800">
                    <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Empreendimentos recentes</h2>
                    <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Acompanhe os empreendimentos mais recentes cadastrados na plataforma.</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-800">
                        <thead class="bg-zinc-50 dark:bg-zinc-800">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">Empreendimento</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">Localizacao</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                            @forelse ($recentDevelopments as $development)
                                <tr class="report-table-row">
                                    <td class="px-6 py-4 text-sm font-semibold text-zinc-800 dark:text-zinc-100">{{ $development->name }}</td>
                                    <td class="px-6 py-4 text-sm text-zinc-600 dark:text-zinc-300">{{ $development->location ?: '-' }}</td>
                                    <td class="px-6 py-4 text-sm text-zinc-600 dark:text-zinc-300">{{ str_replace('_', ' ', $development->status) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-8 text-center text-sm text-zinc-500 dark:text-zinc-400">Nenhum empreendimento cadastrado ainda.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="table-card">
                <div class="border-b border-zinc-100 px-6 py-5 dark:border-zinc-800">
                    <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Reservas / Contratos recentes</h2>
                    <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Ultimos vinculos entre clientes e unidades dentro dos empreendimentos.</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-800">
                        <thead class="bg-zinc-50 dark:bg-zinc-800">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">Cliente</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">Unidade</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                            @forelse ($recentContracts as $contract)
                                <tr class="report-table-row">
                                    <td class="px-6 py-4 text-sm font-semibold text-zinc-800 dark:text-zinc-100">{{ $contract->client->name ?? '-' }}</td>
                                    <td class="px-6 py-4 text-sm text-zinc-600 dark:text-zinc-300">
                                        {{ $contract->development->name ?? '-' }}
                                        <div class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">Unidade {{ $contract->unit->unit_number ?? $contract->unit->identifier ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $contractStatusMap[$contract->status] ?? 'bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-200' }}">
                                            {{ str_replace('_', ' ', $contract->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-8 text-center text-sm text-zinc-500 dark:text-zinc-400">Nenhuma reserva ou contrato cadastrado ainda.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-layouts::app>
