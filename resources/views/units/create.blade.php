<x-layouts::app :title="__('Nova Unidade')">
    <div class="p-6">
        <div class="page-header">
            <div>
                <div class="flex items-center gap-3 text-sm text-zinc-500 dark:text-zinc-400">
                    <a href="{{ route('developments.index') }}" class="hover:text-blue-600">Empreendimentos</a>
                    @if ($unit->development_id)
                        <span>/</span>
                        <span>Nova unidade</span>
                    @endif
                </div>
                <h1 class="page-title mt-3">Nova Unidade</h1>
                <p class="page-subtitle">Cadastre uma unidade para compor o estoque comercial e operacional do empreendimento.</p>
            </div>
        </div>

        <div class="panel-card">
            <div class="panel-card__body">
                <div class="panel-card__intro">
                    <p class="panel-card__eyebrow">Estoque imobiliario</p>
                    <h2 class="panel-card__title">Dados da unidade</h2>
                    <p class="panel-card__text">Registre tipologia, metragem, valor e status para apoiar reservas, contratos e analises de disponibilidade.</p>
                </div>

                <form action="{{ route('units.store') }}" method="POST">
                    @csrf

                    @include('units._form')

                    <div class="form-actions">
                        <a href="{{ route('units.index', array_filter(['development_id' => $unit->development_id])) }}" class="ghost-button">Cancelar</a>
                        <button type="submit" class="primary-button">Salvar unidade</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts::app>