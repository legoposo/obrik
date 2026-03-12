<x-layouts::app :title="__('Editar Cliente')">
    <div class="p-6">
        <div class="page-header">
            <div>
                <h1 class="page-title">Editar Cliente</h1>
                <p class="page-subtitle">Atualize o relacionamento do cliente com a incorporadora e mantenha a jornada comercial organizada.</p>
            </div>
        </div>

        <div class="panel-card">
            <div class="panel-card__body">
                <div class="panel-card__intro">
                    <p class="panel-card__eyebrow">Atualizacao do cadastro</p>
                    <h2 class="panel-card__title">Informacoes do cliente</h2>
                    <p class="panel-card__text">Revise status, dados de contato e observacoes para apoiar reservas, contratos e pos-venda.</p>
                </div>

                <form action="{{ route('clients.update', $client) }}" method="POST">
                    @csrf
                    @method('PUT')

                    @include('clients._form')

                    <div class="form-actions">
                        <a href="{{ route('clients.index') }}" class="ghost-button">Cancelar</a>
                        <button type="submit" class="primary-button">Atualizar cliente</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts::app>