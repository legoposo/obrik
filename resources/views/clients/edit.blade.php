<x-layouts::app :title="__('Editar Cliente')">
    <div class="p-6">
        <div class="page-header">
            <div>
                <h1 class="page-title">Editar Cliente</h1>
                <p class="page-subtitle">Atualize os dados do cliente no Obryn.</p>
            </div>
        </div>

        <div class="panel-card">
            <div class="panel-card__body">
                <div class="panel-card__intro">
                    <p class="panel-card__eyebrow">Cadastro padronizado</p>
                    <h2 class="panel-card__title">Atualizar cadastro</h2>
                    <p class="panel-card__text">Os campos e acoes seguem a mesma linguagem visual dos outros modulos para facilitar a navegacao.</p>
                </div>

                <form action="{{ route('clients.update', $client->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    @include('clients._form')

                    <div class="form-actions">
                        <a href="{{ route('clients.index') }}" class="ghost-button">Cancelar</a>
                        <button type="submit" class="primary-button">Salvar Alteracoes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts::app>
