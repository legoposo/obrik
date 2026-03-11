<x-layouts::app :title="__('Dashboard')">
    <div class="p-6 lg:p-10 space-y-10 bg-zinc-50/50 dark:bg-zinc-950 min-h-screen">
        @php
            $formatMoney = fn ($value) => 'R$ ' . number_format((float) $value, 2, ',', '.');
            
            // Mapeamento de cores para status (Exemplo)
            $statusColor = fn ($status) => match(strtolower($status)) {
                'ativo', 'pago', 'concluído' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400',
                'pendente', 'em análise' => 'bg-amber-100 text-amber-700 dark:bg-amber-500/10 dark:text-amber-400',
                'cancelado', 'atrasado' => 'bg-rose-100 text-rose-700 dark:bg-rose-500/10 dark:text-rose-400',
                default => 'bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300',
            };
        @endphp

        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white md:text-3xl">Painel da OBRYN</h1>
                <p class="mt-1 text-zinc-500 dark:text-zinc-400">Visão executiva da operação comercial, imobiliária e financeira em um só lugar.</p>
            </div>

            <div class="inline-flex items-center gap-2 rounded-xl border border-zinc-200 bg-white px-4 py-2.5 text-sm font-medium text-zinc-600 shadow-sm dark:border-zinc-800 dark:bg-zinc-900 dark:text-zinc-300">
                <svg class="w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                {{ now()->translatedFormat('d \d\e F, Y') }}
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-4">
    @foreach([
        ['label' => 'Clientes', 'val' => $clientsCount, 'color' => 'border-blue-500', 'bg' => 'bg-blue-50/50'],
        ['label' => 'Contratos Ativos', 'val' => $activeContractsCount, 'color' => 'border-emerald-500', 'bg' => 'bg-emerald-50/50'],
        ['label' => 'Unidades Disp.', 'val' => $availableUnitsCount, 'color' => 'border-orange-500', 'bg' => 'bg-orange-50/50'],
        ['label' => 'Empreendimentos', 'val' => $developmentsCount, 'color' => 'border-purple-500', 'bg' => 'bg-purple-50/50'],
    ] as $item)
    <div class="group relative overflow-hidden rounded-2xl border-t-4 {{ $item['color'] }} bg-white p-6 shadow-sm transition-all hover:-translate-y-1 hover:shadow-md dark:bg-zinc-900">
        <p class="text-xs font-bold uppercase tracking-wider text-zinc-400">{{ $item['label'] }}</p>
        <div class="mt-2 flex items-baseline gap-2">
            <h2 class="text-3xl font-black text-zinc-800 dark:text-white">{{ $item['val'] }}</h2>
        </div>
        {{-- Um detalhe visual sutil no fundo --}}
        <div class="absolute -right-2 -bottom-2 h-12 w-12 rounded-full {{ $item['bg'] }} opacity-50 transition-transform group-hover:scale-150"></div>
    </div>
    @endforeach
</div>

        <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
    
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-blue-700 via-blue-600 to-sky-500 p-8 text-white shadow-xl shadow-blue-500/20">
        <div class="relative z-10">
            <p class="text-xs font-bold uppercase tracking-[0.2em] text-blue-100/80">Comercial</p>
            <h2 class="mt-4 text-lg font-medium opacity-90">Volume Contratado</h2>
            <div class="mt-2 text-4xl font-black">{{ $formatMoney($contractedVolume) }}</div>
            <div class="mt-8 flex items-center gap-2 text-sm font-medium text-blue-50">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                Último contrato: {{ $latestContract?->contract_number ?? 'Nenhum' }}
            </div>
        </div>
        <div class="absolute -bottom-6 -right-6 h-40 w-40 text-white/10 rotate-12 transition-transform group-hover:rotate-0">
            <svg fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1.75 14.82l-1.5-1.5 3.5-3.5-3.5-3.5 1.5-1.5L18.5 12l-4.75 4.82zM12 13H7v-2h5V8l4.5 4-4.5 4v-3z"/></svg>
        </div>
    </div>

    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-emerald-600 via-emerald-600 to-teal-500 p-8 text-white shadow-xl shadow-emerald-500/20">
        <div class="relative z-10">
            <p class="text-xs font-bold uppercase tracking-[0.2em] text-emerald-100/80">Financeiro</p>
            <h2 class="mt-4 text-lg font-medium opacity-90">Recebimentos em Aberto</h2>
            <div class="mt-2 text-4xl font-black">{{ $formatMoney($financialOpenAmount) }}</div>
            <div class="mt-8 flex items-center gap-2 text-sm font-medium">
                <span class="flex h-2 w-2 rounded-full bg-rose-300 animate-pulse"></span>
                {{ $financialOverdueCount }} lançamentos em atraso
            </div>
        </div>
        <div class="absolute -bottom-8 -right-4 h-44 w-44 text-white/10 -rotate-12">
            <svg fill="currentColor" viewBox="0 0 24 24"><path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z"/></svg>
        </div>
    </div>

    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-orange-500 via-orange-500 to-amber-500 p-8 text-white shadow-xl shadow-orange-500/20">
        <div class="relative z-10">
            <p class="text-xs font-bold uppercase tracking-[0.2em] text-orange-100/80">Operação</p>
            <h2 class="mt-4 text-lg font-medium opacity-90">Performance da Carteira</h2>
            <div class="mt-2 text-4xl font-black">{{ $completedContractsCount }}</div>
            <p class="mt-8 text-sm font-medium text-orange-50">
                <span class="opacity-75">Concluídos:</span> {{ $completedContractsCount }} | <span class="opacity-75">Cancelados:</span> {{ $cancelledContractsCount }}
            </p>
        </div>
        <div class="absolute -bottom-6 -right-6 h-40 w-40 text-white/10 rotate-12">
            <svg fill="currentColor" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/></svg>
        </div>
    </div>
</div>

        <div class="grid grid-cols-1 gap-8 xl:grid-cols-3">
            <div class="xl:col-span-2 overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                <div class="flex items-center justify-between border-b border-zinc-100 p-6 dark:border-zinc-800">
                    <div>
                        <h3 class="text-lg font-bold text-zinc-900 dark:text-white">Contratos Recentes</h3>
                        <p class="text-sm text-zinc-500">Últimas formalizações de vendas e locações.</p>
                    </div>
                    <a href="{{ route('contracts.index') }}" class="rounded-lg bg-zinc-50 px-4 py-2 text-sm font-semibold text-blue-600 hover:bg-blue-50 dark:bg-zinc-800 dark:hover:bg-zinc-700" wire:navigate>
                        Ver todos
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-zinc-50/50 text-xs uppercase tracking-wider text-zinc-500 dark:bg-zinc-800/50">
                            <tr>
                                <th class="px-6 py-3 font-semibold">Nº Contrato</th>
                                <th class="px-6 py-3 font-semibold">Cliente / Unidade</th>
                                <th class="px-6 py-3 font-semibold text-center">Status</th>
                                <th class="px-6 py-3 text-right font-semibold">Valor</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                            @forelse ($recentContracts as $contract)
                                <tr class="hover:bg-zinc-50/50 dark:hover:bg-zinc-800/50 transition-colors">
                                    <td class="px-6 py-4 text-sm font-bold text-zinc-900 dark:text-white">
                                        {{ $contract->contract_number }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-zinc-900 dark:text-white">{{ $contract->client->name }}</div>
                                        <div class="text-xs text-zinc-500">{{ $contract->development->name }} • Unid. {{ $contract->unit->identifier }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-bold {{ $statusColor($contract->status) }}">
                                            {{ $contract->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right text-sm font-bold text-zinc-900 dark:text-zinc-100">
                                        {{ $formatMoney($contract->negotiated_value) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-10 text-center text-sm text-zinc-500">Nenhum contrato recente.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="space-y-6">
                <div class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                    <h3 class="text-lg font-bold text-zinc-900 dark:text-white">Novos Clientes</h3>
                    <div class="mt-6 space-y-5">
                        @foreach($recentClients as $client)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-blue-500 to-blue-600 text-xs font-bold text-white shadow-sm">
                                    {{ strtoupper(substr($client->name, 0, 2)) }}
                                </div>
                                <div class="min-w-0">
                                    <p class="truncate text-sm font-bold text-zinc-900 dark:text-white">{{ $client->name }}</p>
                                    <p class="truncate text-xs text-zinc-500">{{ $client->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <a href="{{ route('clients.edit', $client) }}" class="text-zinc-400 hover:text-blue-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                            </a>
                        </div>
                        @endforeach
                    </div>
                    <hr class="my-6 border-zinc-100 dark:border-zinc-800">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between rounded-xl bg-zinc-50 p-4 dark:bg-zinc-800/50">
                            <span class="text-sm text-zinc-500 font-medium">Já recebido</span>
                            <span class="text-sm font-bold text-emerald-600">{{ $formatMoney($financialPaidAmount) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts::app>