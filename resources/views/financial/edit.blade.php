<x-layouts::app>
    <div class="p-6">
        <div class="page-header">
            <div>
                <h1 class="page-title">Editar lancamento</h1>
                <p class="page-subtitle">Atualize as informacoes do lancamento financeiro.</p>
            </div>

            <a href="{{ route('financial.index') }}" class="ghost-button">Voltar</a>
        </div>

        <div class="panel-card">
            <div class="panel-card__body">
                <div class="panel-card__intro">
                    <p class="panel-card__eyebrow">Cadastro padronizado</p>
                    <h2 class="panel-card__title">Atualizar lancamento</h2>
                    <p class="panel-card__text">Os mesmos padroes de espacamento, campos e acoes deixam a edicao mais clara em todo o sistema.</p>
                </div>

                <form action="{{ route('financial.update', $financial) }}" method="POST">
                    @csrf
                    @method('PUT')

                    @include('financial._form')

                    <div class="form-actions">
                        <a href="{{ route('financial.index') }}" class="ghost-button">Cancelar</a>
                        <button type="submit" class="primary-button">Atualizar lancamento</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts::app>
