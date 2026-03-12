<x-layouts::app :title="__('Editar Reserva / Contrato')">
    <div class="p-6">
        <div class="page-header">
            <div>
                <h1 class="page-title">Editar Reserva / Contrato</h1>
                <p class="page-subtitle">Atualize o relacionamento comercial preservando o historico do cliente, da unidade e do empreendimento.</p>
            </div>
        </div>

        <div class="panel-card">
            <div class="panel-card__body">
                <div class="panel-card__intro">
                    <p class="panel-card__eyebrow">Ajuste da operacao</p>
                    <h2 class="panel-card__title">Atualizar dados comerciais</h2>
                    <p class="panel-card__text">Revise valor, status e observacoes da reserva ou contrato conforme a negociacao evolui.</p>
                </div>

                <form action="{{ route('contracts.update', $contract) }}" method="POST">
                    @csrf
                    @method('PUT')

                    @include('contracts._form')

                    <div class="form-actions">
                        <a href="{{ route('contracts.index', ['development_id' => $contract->development_id]) }}" class="ghost-button">Cancelar</a>
                        <button type="submit" class="primary-button">Atualizar operacao</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts::app>