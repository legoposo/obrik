<x-layouts::app :title="__('Editar Obra')">
    <div class="p-6">
        <div class="page-header">
            <div>
                <h1 class="page-title">Editar Obra</h1>
                <p class="page-subtitle">Atualize os dados da obra cadastrada e acesse o cronograma sempre que precisar revisar as etapas.</p>
            </div>

            <div class="flex flex-col gap-3 sm:flex-row">
                <a href="{{ route('works.index') }}" class="ghost-button">Voltar para obras</a>
                <a href="{{ route('works.stages.index', $work) }}" class="primary-button">Abrir Cronograma</a>
            </div>
        </div>

        <div class="panel-card">
            <div class="panel-card__body">
                <div class="panel-card__intro">
                    <p class="panel-card__eyebrow">Cadastro padronizado</p>
                    <h2 class="panel-card__title">Atualizar informacoes</h2>
                    <p class="panel-card__text">Os campos seguem o mesmo padrao dos formularios de clientes e financeiro para manter a experiencia consistente.</p>
                </div>

                <form action="{{ route('works.update', $work) }}" method="POST">
                    @csrf
                    @method('PUT')

                    @include('works._form')

                    <div class="form-actions">
                        <a href="{{ route('works.index') }}" class="ghost-button">Cancelar</a>
                        <button type="submit" class="primary-button">Atualizar Obra</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts::app>
