<x-layouts::app :title="__('Novo Comunicado')">
    <div class="p-6">
        <div class="page-header">
            <div>
                <h1 class="page-title">Novo Comunicado</h1>
                <p class="page-subtitle">Publique um novo comunicado para os clientes do empreendimento {{ $development->name }}.</p>
            </div>
        </div>

        <div class="panel-card">
            <div class="panel-card__body">
                <div class="panel-card__intro">
                    <p class="panel-card__eyebrow">Mensagem oficial</p>
                    <h2 class="panel-card__title">Dados do comunicado</h2>
                    <p class="panel-card__text">Escolha o tipo certo e registre a mensagem com clareza para que a comunicacao fique organizada no historico do empreendimento.</p>
                </div>

                <form action="{{ route('developments.communications.store', $development) }}" method="POST">
                    @csrf

                    @include('developments.communications._form')

                    <div class="form-actions">
                        <a href="{{ route('developments.communications.index', $development) }}" class="ghost-button">Cancelar</a>
                        <button type="submit" class="primary-button">Publicar comunicado</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts::app>