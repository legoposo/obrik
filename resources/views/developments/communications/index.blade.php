<x-layouts::app :title="__('Comunicados')">
    @php
        $typeColors = [
            'atualizacao_obra' => 'bg-blue-100 text-blue-700 dark:bg-blue-950/40 dark:text-blue-300',
            'aviso' => 'bg-amber-100 text-amber-700 dark:bg-amber-950/40 dark:text-amber-300',
            'documento' => 'bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-200',
            'entrega' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300',
            'manutencao' => 'bg-violet-100 text-violet-700 dark:bg-violet-950/40 dark:text-violet-300',
        ];
    @endphp

    <div class="p-6 space-y-6">
        <div class="page-header">
            <div>
                <div class="flex flex-wrap items-center gap-3 text-sm text-zinc-500 dark:text-zinc-400">
                    <a href="{{ route('developments.index') }}" class="hover:text-blue-600">Empreendimentos</a>
                    <span>/</span>
                    <a href="{{ route('developments.show', $development) }}" class="hover:text-blue-600">{{ $development->name }}</a>
                    <span>/</span>
                    <span>Comunicados</span>
                </div>
                <h1 class="page-title mt-3">Comunicados</h1>
                <p class="page-subtitle">Publique avisos, atualizacoes e documentos para manter os clientes alinhados com a evolucao do empreendimento.</p>
            </div>

            <div class="flex flex-col gap-3 sm:flex-row">
                <a href="{{ route('developments.show', $development) }}" class="ghost-button">Voltar ao empreendimento</a>
                <a href="{{ route('developments.communications.create', $development) }}" class="primary-button">Novo comunicado</a>
            </div>
        </div>

        @if (session('success'))
            <div class="success-alert">{{ session('success') }}</div>
        @endif

        <div class="panel-card">
            <div class="panel-card__body">
                <div class="panel-card__intro mb-0">
                    <p class="panel-card__eyebrow">Comunicacao com clientes</p>
                    <h2 class="panel-card__title">Historico oficial do empreendimento</h2>
                    <p class="panel-card__text">Utilize esta area para centralizar todas as atualizacoes relevantes para compradores, leads e pos-venda.</p>
                </div>
            </div>
        </div>

        <div class="table-card">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-800">
                    <thead class="bg-zinc-50 dark:bg-zinc-800">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">Titulo</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">Tipo</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">Mensagem</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">Publicado em</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-zinc-500">Acoes</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                        @forelse ($communications as $communication)
                            <tr class="report-table-row align-top">
                                <td class="px-6 py-4 text-sm font-semibold text-zinc-900 dark:text-white">{{ $communication->title }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $typeColors[$communication->type] ?? 'bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-200' }}">
                                        {{ $typeOptions[$communication->type] ?? ucfirst(str_replace('_', ' ', $communication->type)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm leading-6 text-zinc-600 dark:text-zinc-300">{{ \Illuminate\Support\Str::limit($communication->message, 180) }}</td>
                                <td class="px-6 py-4 text-sm text-zinc-600 dark:text-zinc-300">{{ $communication->created_at?->format('d/m/Y H:i') ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('developments.communications.edit', [$development, $communication]) }}" class="action-icon action-icon--edit" title="Editar comunicado">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487a2.1 2.1 0 1 1 2.97 2.97L8.25 19.04 4 20l.96-4.25 11.902-11.263Z" />
                                            </svg>
                                        </a>

                                        <form action="{{ route('developments.communications.destroy', [$development, $communication]) }}" method="POST" onsubmit="return confirm('Deseja realmente excluir este comunicado?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="action-icon action-icon--delete" title="Excluir comunicado">
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
                                <td colspan="5" class="px-6 py-10 text-center text-sm text-zinc-500 dark:text-zinc-400">
                                    Nenhum comunicado publicado ainda para este empreendimento.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="border-t border-zinc-100 px-6 py-4 dark:border-zinc-800">
                {{ $communications->links() }}
            </div>
        </div>
    </div>
</x-layouts::app>