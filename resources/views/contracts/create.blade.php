<x-layouts::app :title="__('Novo Contrato')">
    <div class="p-6">
        <div class="page-header">
            <div>
                <h1 class="page-title">Novo Contrato</h1>
                <p class="page-subtitle">Formalize a venda de uma unidade para um cliente mantendo o mesmo padrão visual dos módulos da OBRYN.</p>
            </div>
        </div>

        <div class="panel-card">
            <div class="panel-card__body">
                <div class="panel-card__intro">
                    <p class="panel-card__eyebrow">Cadastro padronizado</p>
                    <h2 class="panel-card__title">Dados do contrato</h2>
                    <p class="panel-card__text">Organize informações principais, valores comerciais e observações do contrato em um fluxo pronto para futuras parcelas e recebimentos.</p>
                </div>

                <form action="{{ route('contracts.store') }}" method="POST">
                    @csrf

                    @include('contracts._form')

                    <div class="form-actions">
                        <a href="{{ route('contracts.index') }}" class="ghost-button" wire:navigate>Cancelar</a>
                        <button type="submit" class="primary-button">Salvar Contrato</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts::app>
