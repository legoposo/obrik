<x-layouts::app :title="__('Editar Etapa da Obra')">
    <div class="p-6">
        <div class="page-header">
            <div>
                <h1 class="page-title">Editar Etapa da Obra</h1>
                <p class="page-subtitle">Atualize a etapa {{ $stage->stage_name }} do empreendimento {{ $development->name }}.</p>
            </div>
        </div>

        <div class="panel-card">
            <div class="panel-card__body">
                <div class="panel-card__intro">
                    <p class="panel-card__eyebrow">Ajuste do cronograma</p>
                    <h2 class="panel-card__title">Atualizar etapa</h2>
                    <p class="panel-card__text">Mantenha o andamento da obra fiel ao campo com informacoes consistentes e atualizadas.</p>
                </div>

                <form action="{{ route('developments.stages.update', [$development, $stage]) }}" method="POST">
                    @csrf
                    @method('PUT')

                    @include('developments.stages._form')

                    <div class="form-actions">
                        <a href="{{ route('developments.stages.index', $development) }}" class="ghost-button">Cancelar</a>
                        <button type="submit" class="primary-button">Atualizar etapa</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts::app>