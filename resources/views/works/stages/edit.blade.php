<x-layouts::app :title="__('Editar Etapa')">
    <div class="p-6">
        <div class="page-header">
            <div>
                <h1 class="page-title">Editar Etapa</h1>
                <p class="page-subtitle">Atualize os dados da etapa {{ $stage->name }} e mantenha o cronograma da obra em dia.</p>
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
                    <p class="panel-card__text">Cliente: {{ $work->client->name ?? '-' }}. Ajuste status, datas e observacoes conforme a execucao real da etapa.</p>
                </div>

                <form action="{{ route('works.stages.update', [$work, $stage]) }}" method="POST">
                    @csrf
                    @method('PUT')

                    @include('works.stages._form')

                    <div class="form-actions">
                        <a href="{{ route('works.stages.index', $work) }}" class="ghost-button">Cancelar</a>
                        <button type="submit" class="primary-button">Atualizar Etapa</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts::app>
