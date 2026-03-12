<x-layouts::app :title="__('Nova Reserva / Contrato')">
    <div class="p-6">
        <div class="page-header">
            <div>
                <h1 class="page-title">Nova Reserva / Contrato</h1>
                <p class="page-subtitle">Formalize a vinculacao entre cliente e unidade com um fluxo mais direto e alinhado a operacao da incorporadora.</p>
            </div>
        </div>

        <div class="panel-card">
            <div class="panel-card__body">
                <div class="panel-card__intro">
                    <p class="panel-card__eyebrow">Operacao comercial</p>
                    <h2 class="panel-card__title">Dados da reserva ou contrato</h2>
                    <p class="panel-card__text">A OBRYN organiza o processo comercial por empreendimento e sincroniza o status da unidade automaticamente.</p>
                </div>

                <form action="{{ route('contracts.store') }}" method="POST">
                    @csrf

                    @include('contracts._form')

                    <div class="form-actions">
                        <a href="{{ route('contracts.index', array_filter(['development_id' => $contract->development_id])) }}" class="ghost-button">Cancelar</a>
                        <button type="submit" class="primary-button">Salvar operacao</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts::app>