<x-layouts::app>
    <div class="p-6">
        <div class="page-header">
            <div>
                <h1 class="page-title">Novo lancamento</h1>
                <p class="page-subtitle">Cadastre uma nova entrada financeira vinculada a uma obra.</p>
            </div>

            <a href="{{ route('financial.index') }}" class="ghost-button">Voltar</a>
        </div>

        <div class="panel-card">
            <div class="panel-card__body">
                <div class="panel-card__intro">
                    <p class="panel-card__eyebrow">Cadastro padronizado</p>
                    <h2 class="panel-card__title">Lancamento financeiro</h2>
                    <p class="panel-card__text">A estrutura visual agora acompanha os modulos de obras e clientes, com campos e acoes consistentes.</p>
                </div>

                <form action="{{ route('financial.store') }}" method="POST">
                    @csrf

                    @include('financial._form')

                    <div class="form-actions">
                        <a href="{{ route('financial.index') }}" class="ghost-button">Cancelar</a>
                        <button type="submit" class="primary-button">Salvar lancamento</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts::app>
