<x-layouts::app :title="$development->name">
    @php
        $statusMap = [
            'planejamento' => ['label' => 'Planejamento', 'class' => 'bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-200'],
            'lancamento' => ['label' => 'Lancamento', 'class' => 'bg-blue-100 text-blue-700 dark:bg-blue-950/40 dark:text-blue-300'],
            'em_obras' => ['label' => 'Em obras', 'class' => 'bg-amber-100 text-amber-700 dark:bg-amber-950/40 dark:text-amber-300'],
            'finalizado' => ['label' => 'Finalizado', 'class' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300'],
            'entregue' => ['label' => 'Entregue', 'class' => 'bg-violet-100 text-violet-700 dark:bg-violet-950/40 dark:text-violet-300'],
            'cancelado' => ['label' => 'Cancelado', 'class' => 'bg-red-100 text-red-700 dark:bg-red-950/40 dark:text-red-300'],
        ];

        $unitStatusMap = [
            'disponivel' => ['label' => 'Disponivel', 'class' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300'],
            'reservada' => ['label' => 'Reservada', 'class' => 'bg-amber-100 text-amber-700 dark:bg-amber-950/40 dark:text-amber-300'],
            'vendida' => ['label' => 'Vendida', 'class' => 'bg-blue-100 text-blue-700 dark:bg-blue-950/40 dark:text-blue-300'],
            'bloqueada' => ['label' => 'Bloqueada', 'class' => 'bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-200'],
        ];

        $contractStatusMap = [
            'reserva' => ['label' => 'Reserva', 'class' => 'bg-amber-100 text-amber-700 dark:bg-amber-950/40 dark:text-amber-300'],
            'proposta' => ['label' => 'Proposta', 'class' => 'bg-blue-100 text-blue-700 dark:bg-blue-950/40 dark:text-blue-300'],
            'contrato_assinado' => ['label' => 'Contrato assinado', 'class' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300'],
            'cancelado' => ['label' => 'Cancelado', 'class' => 'bg-red-100 text-red-700 dark:bg-red-950/40 dark:text-red-300'],
            'concluido' => ['label' => 'Concluido', 'class' => 'bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-200'],
        ];

        $stageStatusMap = [
            'pendente' => ['label' => 'Pendente', 'class' => 'bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-200'],
            'em_andamento' => ['label' => 'Em andamento', 'class' => 'bg-blue-100 text-blue-700 dark:bg-blue-950/40 dark:text-blue-300'],
            'concluido' => ['label' => 'Concluido', 'class' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300'],
        ];

        $communicationTypeMap = [
            'atualizacao_obra' => 'Atualizacao de obra',
            'aviso' => 'Aviso',
            'documento' => 'Documento',
            'entrega' => 'Entrega',
            'manutencao' => 'Manutencao',
        ];

        $developmentStatus = $statusMap[$development->status] ?? ['label' => ucfirst(str_replace('_', ' ', $development->status)), 'class' => 'bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-200'];
    @endphp

    <div class="p-6 space-y-6">
        <div class="page-header">
            <div>
                <div class="flex flex-wrap items-center gap-3 text-sm text-zinc-500 dark:text-zinc-400">
                    <a href="{{ route('developments.index') }}" class="hover:text-blue-600">Empreendimentos</a>
                    <span>/</span>
                    <span>{{ $development->name }}</span>
                </div>
                <div class="mt-3 flex flex-wrap items-center gap-3">
                    <h1 class="page-title">{{ $development->name }}</h1>
                    <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $developmentStatus['class'] }}">{{ $developmentStatus['label'] }}</span>
                </div>
                <p class="page-subtitle">Hub operacional do empreendimento com acesso rapido a unidades, clientes vinculados, reservas, andamento da obra, comunicados e fotos.</p>
            </div>

            <div class="flex flex-col gap-3 sm:flex-row sm:flex-wrap">
                <a href="{{ route('units.create', ['development_id' => $development->id]) }}" class="ghost-button">Nova unidade</a>
                <a href="{{ route('contracts.create', ['development_id' => $development->id]) }}" class="ghost-button">Nova reserva</a>
                <a href="{{ route('developments.edit', $development) }}" class="primary-button">Editar empreendimento</a>
            </div>
        </div>

        @if (session('success'))
            <div class="success-alert">{{ session('success') }}</div>
        @endif

        <div class="grid gap-6 xl:grid-cols-[minmax(0,1.5fr)_minmax(320px,0.8fr)] xl:items-start">
            <div class="panel-card">
                <div class="panel-card__body">
                    <div class="panel-card__intro mb-6">
                        <p class="panel-card__eyebrow">Resumo central</p>
                        <h2 class="panel-card__title">Visao do empreendimento</h2>
                        <p class="panel-card__text">{{ $development->description ?: 'Use este hub para acompanhar operacao comercial, estoque, obra e comunicacao com clientes.' }}</p>
                    </div>

                    <div class="grid gap-4 md:grid-cols-2">
                        <div class="rounded-2xl border border-zinc-200 bg-zinc-50 p-4 dark:border-zinc-800 dark:bg-zinc-800/70">
                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-zinc-500 dark:text-zinc-400">Localizacao</p>
                            <p class="mt-2 text-sm font-semibold text-zinc-900 dark:text-white">{{ $development->location ?: '-' }}</p>
                        </div>

                        <div class="rounded-2xl border border-zinc-200 bg-zinc-50 p-4 dark:border-zinc-800 dark:bg-zinc-800/70">
                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-zinc-500 dark:text-zinc-400">Lancamento</p>
                            <p class="mt-2 text-sm font-semibold text-zinc-900 dark:text-white">{{ $development->launch_date?->format('d/m/Y') ?? $development->start_date?->format('d/m/Y') ?? '-' }}</p>
                        </div>

                        <div class="rounded-2xl border border-zinc-200 bg-zinc-50 p-4 dark:border-zinc-800 dark:bg-zinc-800/70">
                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-zinc-500 dark:text-zinc-400">Entrega prevista</p>
                            <p class="mt-2 text-sm font-semibold text-zinc-900 dark:text-white">{{ $development->expected_delivery?->format('d/m/Y') ?? $development->expected_delivery_date?->format('d/m/Y') ?? '-' }}</p>
                        </div>

                        <div class="rounded-2xl border border-zinc-200 bg-zinc-50 p-4 dark:border-zinc-800 dark:bg-zinc-800/70">
                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-zinc-500 dark:text-zinc-400">Incorporadora</p>
                            <p class="mt-2 text-sm font-semibold text-zinc-900 dark:text-white">{{ $development->builder->name ?? '-' }}</p>
                        </div>

                        <div class="rounded-2xl border border-zinc-200 bg-zinc-50 p-4 dark:border-zinc-800 dark:bg-zinc-800/70 md:col-span-2">
                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-zinc-500 dark:text-zinc-400">Observacoes internas</p>
                            <p class="mt-2 text-sm leading-6 text-zinc-600 dark:text-zinc-300">{{ $development->notes ?: 'Nenhuma observacao registrada ate o momento.' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel-card">
                <div class="panel-card__body">
                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-blue-600 dark:text-blue-300">Andamento da obra</p>
                    <p class="mt-3 text-4xl font-bold tracking-tight text-zinc-900 dark:text-white">{{ $stageProgress }}%</p>
                    <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">{{ $stageProgress }}% das etapas cadastradas estao concluidas.</p>

                    <div class="mt-5 h-3 overflow-hidden rounded-full bg-zinc-200 dark:bg-zinc-800">
                        <div class="h-full rounded-full bg-blue-600 transition-all duration-500" style="width: {{ $stageProgress }}%"></div>
                    </div>

                    <div class="mt-6 grid gap-3 sm:grid-cols-2">
                        <div class="rounded-2xl border border-zinc-200 bg-zinc-50 p-4 dark:border-zinc-800 dark:bg-zinc-800/70">
                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-zinc-500 dark:text-zinc-400">Etapas</p>
                            <p class="mt-2 text-2xl font-bold text-zinc-900 dark:text-white">{{ number_format($development->stages_count, 0, ',', '.') }}</p>
                        </div>

                        <div class="rounded-2xl border border-zinc-200 bg-zinc-50 p-4 dark:border-zinc-800 dark:bg-zinc-800/70">
                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-zinc-500 dark:text-zinc-400">Comunicados</p>
                            <p class="mt-2 text-2xl font-bold text-zinc-900 dark:text-white">{{ number_format($development->communications_count, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <a href="{{ route('developments.stages.index', $development) }}" class="primary-button mt-6 w-full">Abrir andamento da obra</a>
                </div>
            </div>
        </div>

        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
            <a href="{{ route('units.index', ['development_id' => $development->id]) }}" class="report-link-card">
                <p class="report-stat-card__label">Unidades</p>
                <p class="report-stat-card__value">{{ number_format($development->units_count, 0, ',', '.') }}</p>
                <p class="report-stat-card__meta">Gerencie estoque, disponibilidade e dados comerciais das unidades.</p>
            </a>

            <a href="{{ route('clients.index', ['development_id' => $development->id]) }}" class="report-link-card">
                <p class="report-stat-card__label">Clientes vinculados</p>
                <p class="report-stat-card__value">{{ number_format($linkedClients->count(), 0, ',', '.') }}</p>
                <p class="report-stat-card__meta">Acesse os clientes relacionados a reservas e contratos deste empreendimento.</p>
            </a>

            <a href="{{ route('contracts.index', ['development_id' => $development->id]) }}" class="report-link-card">
                <p class="report-stat-card__label">Reservas / contratos</p>
                <p class="report-stat-card__value">{{ number_format($development->active_contracts_count, 0, ',', '.') }}</p>
                <p class="report-stat-card__meta">Monitore reservas, propostas e contratos assinados.</p>
            </a>

            <a href="{{ route('developments.stages.index', $development) }}" class="report-link-card">
                <p class="report-stat-card__label">Andamento da obra</p>
                <p class="report-stat-card__value">{{ $stageProgress }}%</p>
                <p class="report-stat-card__meta">Acompanhe as etapas construtivas e o percentual global do empreendimento.</p>
            </a>

            <a href="{{ route('developments.communications.index', $development) }}" class="report-link-card">
                <p class="report-stat-card__label">Comunicados</p>
                <p class="report-stat-card__value">{{ number_format($development->communications_count, 0, ',', '.') }}</p>
                <p class="report-stat-card__meta">Publique atualizacoes, avisos e documentos para os clientes.</p>
            </a>

            <a href="{{ route('developments.photos.index', $development) }}" class="report-link-card">
                <p class="report-stat-card__label">Fotos da obra</p>
                <p class="report-stat-card__value">{{ number_format($development->photos_count, 0, ',', '.') }}</p>
                <p class="report-stat-card__meta">Construa um historico visual da obra com galerias periodicas.</p>
            </a>
        </div>

        <div class="grid gap-6 xl:grid-cols-2">
            <div class="panel-card">
                <div class="panel-card__body space-y-5">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="panel-card__eyebrow">Unidades</p>
                            <h2 class="panel-card__title">Estoque do empreendimento</h2>
                        </div>
                        <a href="{{ route('units.index', ['development_id' => $development->id]) }}" class="ghost-button">Ver todas</a>
                    </div>

                    <div class="space-y-3">
                        @forelse ($units as $unit)
                            @php
                                $unitStatus = $unitStatusMap[$unit->status] ?? ['label' => ucfirst($unit->status), 'class' => 'bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-200'];
                            @endphp

                            <div class="rounded-2xl border border-zinc-200 bg-zinc-50 p-4 dark:border-zinc-800 dark:bg-zinc-800/60">
                                <div class="flex flex-wrap items-start justify-between gap-3">
                                    <div>
                                        <p class="text-sm font-semibold text-zinc-900 dark:text-white">Unidade {{ $unit->unit_number ?? $unit->identifier }}</p>
                                        <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">{{ $unit->block_or_tower ?: 'Sem bloco/torre' }} | {{ $unit->type }}</p>
                                    </div>
                                    <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $unitStatus['class'] }}">{{ $unitStatus['label'] }}</span>
                                </div>
                                <div class="mt-3 flex flex-wrap gap-4 text-xs text-zinc-500 dark:text-zinc-400">
                                    <span>Area: {{ $unit->area ? number_format((float) $unit->area, 2, ',', '.') . ' m2' : '-' }}</span>
                                    <span>Quartos: {{ $unit->bedrooms ?? '-' }}</span>
                                    <span>Vagas: {{ $unit->parking_spaces ?? '-' }}</span>
                                    <span>Preco: {{ $unit->price ? 'R$ '.number_format((float) $unit->price, 2, ',', '.') : '-' }}</span>
                                </div>
                            </div>
                        @empty
                            <div class="rounded-2xl border border-dashed border-zinc-300 px-5 py-8 text-sm text-zinc-500 dark:border-zinc-700 dark:text-zinc-400">
                                Nenhuma unidade cadastrada ainda para este empreendimento.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="panel-card">
                <div class="panel-card__body space-y-5">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="panel-card__eyebrow">Reservas / contratos</p>
                            <h2 class="panel-card__title">Movimentacao comercial recente</h2>
                        </div>
                        <a href="{{ route('contracts.index', ['development_id' => $development->id]) }}" class="ghost-button">Ver todos</a>
                    </div>

                    <div class="space-y-3">
                        @forelse ($contracts as $contract)
                            @php
                                $contractStatus = $contractStatusMap[$contract->status] ?? ['label' => ucfirst(str_replace('_', ' ', $contract->status)), 'class' => 'bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-200'];
                            @endphp

                            <div class="rounded-2xl border border-zinc-200 bg-zinc-50 p-4 dark:border-zinc-800 dark:bg-zinc-800/60">
                                <div class="flex flex-wrap items-start justify-between gap-3">
                                    <div>
                                        <p class="text-sm font-semibold text-zinc-900 dark:text-white">{{ $contract->client->name ?? '-' }}</p>
                                        <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Unidade {{ $contract->unit->unit_number ?? $contract->unit->identifier ?? '-' }} | {{ $contract->contract_number }}</p>
                                    </div>
                                    <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $contractStatus['class'] }}">{{ $contractStatus['label'] }}</span>
                                </div>
                                <div class="mt-3 flex flex-wrap gap-4 text-xs text-zinc-500 dark:text-zinc-400">
                                    <span>Data: {{ $contract->contract_date?->format('d/m/Y') ?? '-' }}</span>
                                    <span>Valor: {{ $contract->value ? 'R$ '.number_format((float) $contract->value, 2, ',', '.') : '-' }}</span>
                                </div>
                            </div>
                        @empty
                            <div class="rounded-2xl border border-dashed border-zinc-300 px-5 py-8 text-sm text-zinc-500 dark:border-zinc-700 dark:text-zinc-400">
                                Nenhuma reserva ou contrato vinculado a este empreendimento ate o momento.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <div class="grid gap-6 xl:grid-cols-2">
            <div class="panel-card">
                <div class="panel-card__body space-y-5">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="panel-card__eyebrow">Andamento</p>
                            <h2 class="panel-card__title">Etapas da obra</h2>
                        </div>
                        <a href="{{ route('developments.stages.index', $development) }}" class="ghost-button">Abrir cronograma</a>
                    </div>

                    <div class="space-y-3">
                        @forelse ($stages->take(5) as $stage)
                            @php
                                $stageStatus = $stageStatusMap[$stage->status] ?? ['label' => ucfirst(str_replace('_', ' ', $stage->status)), 'class' => 'bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-200'];
                            @endphp

                            <div class="rounded-2xl border border-zinc-200 bg-zinc-50 p-4 dark:border-zinc-800 dark:bg-zinc-800/60">
                                <div class="flex flex-wrap items-start justify-between gap-3">
                                    <div>
                                        <p class="text-sm font-semibold text-zinc-900 dark:text-white">{{ $stage->stage_name }}</p>
                                        <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Responsavel: {{ $stage->responsible ?: '-' }}</p>
                                    </div>
                                    <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $stageStatus['class'] }}">{{ $stageStatus['label'] }}</span>
                                </div>
                                <div class="mt-3 flex flex-wrap gap-4 text-xs text-zinc-500 dark:text-zinc-400">
                                    <span>Inicio: {{ $stage->start_date?->format('d/m/Y') ?? '-' }}</span>
                                    <span>Previsao: {{ $stage->expected_date?->format('d/m/Y') ?? '-' }}</span>
                                    <span>Conclusao: {{ $stage->finished_date?->format('d/m/Y') ?? '-' }}</span>
                                </div>
                            </div>
                        @empty
                            <div class="rounded-2xl border border-dashed border-zinc-300 px-5 py-8 text-sm text-zinc-500 dark:border-zinc-700 dark:text-zinc-400">
                                Nenhuma etapa cadastrada ainda. Crie o cronograma para iniciar o acompanhamento da obra.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="panel-card">
                <div class="panel-card__body space-y-5">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="panel-card__eyebrow">Comunicacao</p>
                            <h2 class="panel-card__title">Comunicados recentes</h2>
                        </div>
                        <a href="{{ route('developments.communications.index', $development) }}" class="ghost-button">Ver historico</a>
                    </div>

                    <div class="space-y-3">
                        @forelse ($communications as $communication)
                            <div class="rounded-2xl border border-zinc-200 bg-zinc-50 p-4 dark:border-zinc-800 dark:bg-zinc-800/60">
                                <div class="flex flex-wrap items-start justify-between gap-3">
                                    <div>
                                        <p class="text-sm font-semibold text-zinc-900 dark:text-white">{{ $communication->title }}</p>
                                        <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">{{ $communicationTypeMap[$communication->type] ?? ucfirst(str_replace('_', ' ', $communication->type)) }}</p>
                                    </div>
                                    <span class="text-xs text-zinc-500 dark:text-zinc-400">{{ $communication->created_at?->format('d/m/Y') ?? '-' }}</span>
                                </div>
                                <p class="mt-3 text-sm leading-6 text-zinc-600 dark:text-zinc-300">{{ \Illuminate\Support\Str::limit($communication->message, 140) }}</p>
                            </div>
                        @empty
                            <div class="rounded-2xl border border-dashed border-zinc-300 px-5 py-8 text-sm text-zinc-500 dark:border-zinc-700 dark:text-zinc-400">
                                Nenhum comunicado publicado ainda para este empreendimento.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <div class="panel-card">
            <div class="panel-card__body space-y-6">
                <div class="grid gap-6 xl:grid-cols-[minmax(0,0.9fr)_minmax(0,1.1fr)] xl:items-start">
                    <div>
                        <p class="panel-card__eyebrow">Clientes vinculados</p>
                        <h2 class="panel-card__title">Relacionamentos deste empreendimento</h2>
                        <p class="panel-card__text">Clientes associados por reservas ou contratos ativos e historicos no empreendimento.</p>

                        <div class="mt-5 space-y-3">
                            @forelse ($linkedClients as $client)
                                <div class="rounded-2xl border border-zinc-200 bg-zinc-50 p-4 dark:border-zinc-800 dark:bg-zinc-800/60">
                                    <p class="text-sm font-semibold text-zinc-900 dark:text-white">{{ $client->name }}</p>
                                    <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">{{ $client->email ?: 'Sem e-mail cadastrado' }}</p>
                                    <div class="mt-3 flex flex-wrap gap-4 text-xs text-zinc-500 dark:text-zinc-400">
                                        <span>Telefone: {{ $client->phone ?: '-' }}</span>
                                        <span>Status: {{ str_replace('_', ' ', $client->status ?: 'lead') }}</span>
                                    </div>
                                </div>
                            @empty
                                <div class="rounded-2xl border border-dashed border-zinc-300 px-5 py-8 text-sm text-zinc-500 dark:border-zinc-700 dark:text-zinc-400">
                                    Ainda nao existem clientes vinculados por reserva ou contrato neste empreendimento.
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <p class="panel-card__eyebrow">Fotos da obra</p>
                                <h2 class="panel-card__title">Galeria de atualizacoes</h2>
                            </div>
                            <a href="{{ route('developments.photos.index', $development) }}" class="ghost-button">Abrir galeria</a>
                        </div>

                        <div class="mt-5 grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
                            @forelse ($photos as $photo)
                                <article class="overflow-hidden rounded-3xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                                    <div class="aspect-[4/3] bg-zinc-100 dark:bg-zinc-800">
                                        <img src="{{ asset('storage/'.$photo->image_path) }}" alt="{{ $photo->title }}" class="h-full w-full object-cover">
                                    </div>
                                    <div class="p-4">
                                        <p class="text-sm font-semibold text-zinc-900 dark:text-white">{{ $photo->title }}</p>
                                        <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">{{ $photo->date?->format('d/m/Y') ?? '-' }}</p>
                                        @if ($photo->description)
                                            <p class="mt-3 text-sm leading-6 text-zinc-600 dark:text-zinc-300">{{ \Illuminate\Support\Str::limit($photo->description, 92) }}</p>
                                        @endif
                                    </div>
                                </article>
                            @empty
                                <div class="rounded-2xl border border-dashed border-zinc-300 px-5 py-8 text-sm text-zinc-500 dark:border-zinc-700 dark:text-zinc-400 sm:col-span-2 xl:col-span-3">
                                    Nenhuma foto cadastrada ainda. Adicione registros visuais para documentar a evolucao da obra.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts::app>