<x-layouts::app :title="$development->name">
    <div class="p-6 space-y-8">
        <div class="page-header">
            <div>
                <div class="flex items-center gap-3 text-sm text-zinc-500 dark:text-zinc-400">
                    <a href="{{ route('developments.index') }}" class="hover:text-blue-600" wire:navigate>Empreendimentos</a>
                    <span>/</span>
                    <span>{{ $development->name }}</span>
                </div>
                <h1 class="page-title mt-3">{{ $development->name }}</h1>
                <p class="page-subtitle">Visualize os dados do empreendimento e acompanhe o painel visual de unidades no mesmo padrão moderno do sistema.</p>
            </div>

            <div class="flex flex-col gap-3 sm:flex-row">
                <a href="{{ route('units.create') }}" class="ghost-button" wire:navigate>Nova unidade</a>
                <a href="{{ route('developments.edit', $development) }}" class="primary-button" wire:navigate>Editar empreendimento</a>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <div class="panel-card lg:col-span-2">
                <div class="panel-card__body">
                    <div class="panel-card__intro">
                        <p class="panel-card__eyebrow">Resumo do empreendimento</p>
                        <h2 class="panel-card__title">Informações principais</h2>
                        <p class="panel-card__text">Dados cadastrais, localização e contexto geral do empreendimento.</p>
                    </div>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div class="rounded-2xl border border-zinc-200 bg-zinc-50 p-4 dark:border-zinc-800 dark:bg-zinc-800/70">
                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-zinc-500 dark:text-zinc-400">Tipo</p>
                            <p class="mt-2 text-base font-semibold text-zinc-900 dark:text-white">{{ $development->type === 'houses' ? 'Casas' : 'Apartamentos' }}</p>
                        </div>

                        <div class="rounded-2xl border border-zinc-200 bg-zinc-50 p-4 dark:border-zinc-800 dark:bg-zinc-800/70">
                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-zinc-500 dark:text-zinc-400">Status</p>
                            <p class="mt-2 text-base font-semibold text-zinc-900 dark:text-white">
                                {{ ['planning' => 'Planejamento', 'in_progress' => 'Em andamento', 'paused' => 'Pausado', 'completed' => 'Concluído', 'canceled' => 'Cancelado'][$development->status] ?? $development->status }}
                            </p>
                        </div>

                        <div class="rounded-2xl border border-zinc-200 bg-zinc-50 p-4 dark:border-zinc-800 dark:bg-zinc-800/70">
                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-zinc-500 dark:text-zinc-400">Cidade / UF</p>
                            <p class="mt-2 text-base font-semibold text-zinc-900 dark:text-white">{{ $development->city }}/{{ $development->state }}</p>
                        </div>

                        <div class="rounded-2xl border border-zinc-200 bg-zinc-50 p-4 dark:border-zinc-800 dark:bg-zinc-800/70">
                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-zinc-500 dark:text-zinc-400">Construtora</p>
                            <p class="mt-2 text-base font-semibold text-zinc-900 dark:text-white">{{ $development->builder->name ?? 'Não informada' }}</p>
                        </div>

                        <div class="rounded-2xl border border-zinc-200 bg-zinc-50 p-4 dark:border-zinc-800 dark:bg-zinc-800/70 md:col-span-2">
                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-zinc-500 dark:text-zinc-400">Endereço</p>
                            <p class="mt-2 text-base font-semibold text-zinc-900 dark:text-white">{{ $development->address ?: 'Endereço não informado' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel-card">
                <div class="panel-card__body">
                    <div class="panel-card__intro mb-6">
                        <p class="panel-card__eyebrow">Unidades</p>
                        <h2 class="panel-card__title">Contadores rápidos</h2>
                        <p class="panel-card__text">Visão imediata do estoque do empreendimento.</p>
                    </div>

                    <div class="space-y-4">
                        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-4 dark:border-emerald-900/60 dark:bg-emerald-950/30">
                            <p class="text-sm text-emerald-700 dark:text-emerald-300">Disponíveis</p>
                            <p class="mt-1 text-2xl font-bold text-emerald-800 dark:text-emerald-200">{{ $unitStats['available'] }}</p>
                        </div>

                        <div class="rounded-2xl border border-amber-200 bg-amber-50 p-4 dark:border-amber-900/60 dark:bg-amber-950/30">
                            <p class="text-sm text-amber-700 dark:text-amber-300">Reservadas</p>
                            <p class="mt-1 text-2xl font-bold text-amber-800 dark:text-amber-200">{{ $unitStats['reserved'] }}</p>
                        </div>

                        <div class="rounded-2xl border border-red-200 bg-red-50 p-4 dark:border-red-900/60 dark:bg-red-950/30">
                            <p class="text-sm text-red-700 dark:text-red-300">Vendidas</p>
                            <p class="mt-1 text-2xl font-bold text-red-800 dark:text-red-200">{{ $unitStats['sold'] }}</p>
                        </div>

                        <div class="rounded-2xl border border-zinc-300 bg-zinc-100 p-4 dark:border-zinc-700 dark:bg-zinc-800/80">
                            <p class="text-sm text-zinc-700 dark:text-zinc-300">Bloqueadas</p>
                            <p class="mt-1 text-2xl font-bold text-zinc-800 dark:text-zinc-100">{{ $unitStats['blocked'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div
            class="panel-card"
            x-data="{ viewMode: '{{ $units->count() > 20 ? 'compact' : 'detailed' }}', statusFilter: 'all' }"
        >
            <div class="panel-card__body space-y-6">
                <div class="panel-card__intro">
                    <div class="flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">
                        <div>
                            <p class="panel-card__eyebrow">Unidades</p>
                            <h2 class="panel-card__title">Painel visual do empreendimento</h2>
                            <p class="panel-card__text">Alterne entre leitura detalhada e visão compacta para localizar rapidamente unidades em empreendimentos maiores.</p>
                        </div>

                        <div class="inline-flex rounded-2xl border border-zinc-200 bg-white p-1 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
                            <button
                                type="button"
                                class="rounded-xl px-4 py-2 text-sm font-semibold transition"
                                :class="viewMode === 'detailed'
                                    ? 'bg-blue-600 text-white shadow-sm shadow-blue-600/20'
                                    : 'text-zinc-600 hover:bg-zinc-100 dark:text-zinc-300 dark:hover:bg-zinc-800'"
                                @click="viewMode = 'detailed'; statusFilter = 'all'"
                            >
                                Visualização detalhada
                            </button>

                            <button
                                type="button"
                                class="rounded-xl px-4 py-2 text-sm font-semibold transition"
                                :class="viewMode === 'compact'
                                    ? 'bg-blue-600 text-white shadow-sm shadow-blue-600/20'
                                    : 'text-zinc-600 hover:bg-zinc-100 dark:text-zinc-300 dark:hover:bg-zinc-800'"
                                @click="viewMode = 'compact'"
                            >
                                Visualização compacta
                            </button>
                        </div>
                    </div>
                </div>

                <div x-show="viewMode === 'compact'" x-transition.opacity class="flex flex-wrap items-center gap-3 rounded-2xl border border-zinc-200 bg-zinc-50 p-4 dark:border-zinc-800 dark:bg-zinc-900/70">
                    <button
                        type="button"
                        class="inline-flex items-center gap-2 rounded-full px-3 py-1.5 text-sm font-medium ring-1 transition"
                        :class="statusFilter === 'all'
                            ? 'bg-zinc-900 text-white ring-zinc-900 dark:bg-white dark:text-zinc-900 dark:ring-white'
                            : 'bg-white text-zinc-700 ring-zinc-200 hover:bg-zinc-100 dark:bg-zinc-900 dark:text-zinc-200 dark:ring-zinc-700 dark:hover:bg-zinc-800'"
                        @click="statusFilter = 'all'"
                    >
                        Todas
                    </button>

                    <button
                        type="button"
                        class="inline-flex items-center gap-2 rounded-full px-3 py-1.5 text-sm font-medium ring-1 transition"
                        :class="statusFilter === 'available'
                            ? 'bg-green-100 text-green-700 ring-green-200 dark:bg-green-900/40 dark:text-green-300 dark:ring-green-900/60'
                            : 'bg-white text-zinc-700 ring-zinc-200 hover:bg-zinc-100 dark:bg-zinc-900 dark:text-zinc-200 dark:ring-zinc-700 dark:hover:bg-zinc-800'"
                        @click="statusFilter = statusFilter === 'available' ? 'all' : 'available'"
                    >
                        <span class="h-2.5 w-2.5 rounded-full bg-green-500"></span> Disponível
                    </button>

                    <button
                        type="button"
                        class="inline-flex items-center gap-2 rounded-full px-3 py-1.5 text-sm font-medium ring-1 transition"
                        :class="statusFilter === 'reserved'
                            ? 'bg-yellow-100 text-yellow-700 ring-yellow-200 dark:bg-yellow-900/40 dark:text-yellow-300 dark:ring-yellow-900/60'
                            : 'bg-white text-zinc-700 ring-zinc-200 hover:bg-zinc-100 dark:bg-zinc-900 dark:text-zinc-200 dark:ring-zinc-700 dark:hover:bg-zinc-800'"
                        @click="statusFilter = statusFilter === 'reserved' ? 'all' : 'reserved'"
                    >
                        <span class="h-2.5 w-2.5 rounded-full bg-yellow-500"></span> Reservado
                    </button>

                    <button
                        type="button"
                        class="inline-flex items-center gap-2 rounded-full px-3 py-1.5 text-sm font-medium ring-1 transition"
                        :class="statusFilter === 'sold'
                            ? 'bg-red-100 text-red-700 ring-red-200 dark:bg-red-900/40 dark:text-red-300 dark:ring-red-900/60'
                            : 'bg-white text-zinc-700 ring-zinc-200 hover:bg-zinc-100 dark:bg-zinc-900 dark:text-zinc-200 dark:ring-zinc-700 dark:hover:bg-zinc-800'"
                        @click="statusFilter = statusFilter === 'sold' ? 'all' : 'sold'"
                    >
                        <span class="h-2.5 w-2.5 rounded-full bg-red-500"></span> Vendido
                    </button>

                    <button
                        type="button"
                        class="inline-flex items-center gap-2 rounded-full px-3 py-1.5 text-sm font-medium ring-1 transition"
                        :class="statusFilter === 'blocked'
                            ? 'bg-gray-200 text-gray-700 ring-gray-300 dark:bg-zinc-700 dark:text-zinc-200 dark:ring-zinc-600'
                            : 'bg-white text-zinc-700 ring-zinc-200 hover:bg-zinc-100 dark:bg-zinc-900 dark:text-zinc-200 dark:ring-zinc-700 dark:hover:bg-zinc-800'"
                        @click="statusFilter = statusFilter === 'blocked' ? 'all' : 'blocked'"
                    >
                        <span class="h-2.5 w-2.5 rounded-full bg-zinc-400"></span> Bloqueado
                    </button>
                </div>

                <div x-show="viewMode === 'detailed'" x-transition.opacity>
                    @include('developments.partials.units-detailed', ['units' => $units])
                </div>

                <div x-show="viewMode === 'compact'" x-transition.opacity>
                    @include('developments.partials.units-compact', ['units' => $units])
                </div>
            </div>
        </div>
    </div>
</x-layouts::app>