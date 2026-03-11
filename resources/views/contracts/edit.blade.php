<x-layouts::app :title="__('Editar Contrato')">
    <div class="p-6">
        <div class="page-header">
            <div>
                <h1 class="page-title">Editar Contrato</h1>
                <p class="page-subtitle">Atualize os dados do contrato preservando o padrão visual e estrutural dos formulários já existentes.</p>
            </div>
        </div>

        <div class="panel-card">
            <div class="panel-card__body">
                <div class="panel-card__intro">
                    <p class="panel-card__eyebrow">Cadastro padronizado</p>
                    <h2 class="panel-card__title">Atualizar contrato</h2>
                    <p class="panel-card__text">Revise vínculo entre empreendimento, unidade e cliente, além das informações financeiras e contratuais.</p>
                </div>

                <form action="{{ route('contracts.update', $contract) }}" method="POST">
                    @csrf
                    @method('PUT')

                    @include('contracts._form')

                    <div class="form-actions">
                        <a href="{{ route('contracts.index') }}" class="ghost-button" wire:navigate>Cancelar</a>
                        <button type="submit" class="primary-button">Atualizar Contrato</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts::app>
