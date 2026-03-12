<x-layouts::app :title="__('Nova Etapa da Obra')">
    <div class="p-6">
        <div class="page-header">
            <div>
                <h1 class="page-title">Nova Etapa da Obra</h1>
                <p class="page-subtitle">Adicione uma nova etapa ao cronograma do empreendimento {{ $development->name }}.</p>
            </div>
        </div>

        <div class="panel-card">
            <div class="panel-card__body">
                <div class="panel-card__intro">
                    <p class="panel-card__eyebrow">Planejamento executivo</p>
                    <h2 class="panel-card__title">Dados da etapa</h2>
                    <p class="panel-card__text">Organize o cronograma do empreendimento com status, datas e responsabilidade claramente definidos.</p>
                </div>

                <form action="{{ route('developments.stages.store', $development) }}" method="POST">
                    @csrf

                    @include('developments.stages._form')

                    <div class="form-actions">
                        <a href="{{ route('developments.stages.index', $development) }}" class="ghost-button">Cancelar</a>
                        <button type="submit" class="primary-button">Salvar etapa</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts::app>