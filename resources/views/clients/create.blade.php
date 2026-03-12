<x-layouts::app :title="__('Novo Cliente')">
    <div class="p-6">
        <div class="page-header">
            <div>
                <h1 class="page-title">Novo Cliente</h1>
                <p class="page-subtitle">Cadastre leads, interessados, compradores e clientes de pos-venda no mesmo fluxo da operacao comercial da incorporadora.</p>
            </div>
        </div>

        <div class="panel-card">
            <div class="panel-card__body">
                <div class="panel-card__intro">
                    <p class="panel-card__eyebrow">Relacionamento comercial</p>
                    <h2 class="panel-card__title">Dados do cliente</h2>
                    <p class="panel-card__text">Mantenha o cadastro pronto para vinculacao com unidades, reservas, contratos e comunicados.</p>
                </div>

                <form action="{{ route('clients.store') }}" method="POST">
                    @csrf

                    @include('clients._form')

                    <div class="form-actions">
                        <a href="{{ route('clients.index') }}" class="ghost-button">Cancelar</a>
                        <button type="submit" class="primary-button">Salvar cliente</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts::app>