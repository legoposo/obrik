<x-layouts::app :title="__('Adicionar Etapa')">
    <div class="p-6">
        <div class="page-header">
            <div>
                <h1 class="page-title">Adicionar Etapa</h1>
                <p class="page-subtitle">Cadastre uma nova etapa para acompanhar o andamento da obra {{ $work->name }}.</p>
            </div>

            <div class="flex flex-col gap-3 sm:flex-row">
                <a href="{{ route('works.index') }}" class="ghost-button">Voltar para obras</a>
                <a href="{{ route('works.stages.index', $work) }}" class="ghost-button">Ver cronograma</a>
            </div>
        </div>

        <div class="panel-card">
            <div class="panel-card__body">
                <div class="panel-card__intro">
                    <p class="panel-card__eyebrow">Cronograma da obra</p>
                    <h2 class="panel-card__title">{{ $work->name }}</h2>
                    <p class="panel-card__text">Cliente: {{ $work->client->name ?? '-' }}. Use este formulario para registrar a etapa com datas, responsavel e observacoes de execucao.</p>
                </div>

                <form action="{{ route('works.stages.store', $work) }}" method="POST">
                    @csrf

                    @include('works.stages._form', ['stage' => null])

                    <div class="form-actions">
                        <a href="{{ route('works.stages.index', $work) }}" class="ghost-button">Cancelar</a>
                        <button type="submit" class="primary-button">Salvar Etapa</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts::app>
