<x-layouts::app :title="__('Editar Comunicado')">
    <div class="p-6">
        <div class="page-header">
            <div>
                <h1 class="page-title">Editar Comunicado</h1>
                <p class="page-subtitle">Atualize o comunicado {{ $communication->title }} do empreendimento {{ $development->name }}.</p>
            </div>
        </div>

        <div class="panel-card">
            <div class="panel-card__body">
                <div class="panel-card__intro">
                    <p class="panel-card__eyebrow">Ajuste da mensagem</p>
                    <h2 class="panel-card__title">Atualizar comunicado</h2>
                    <p class="panel-card__text">Mantenha a comunicacao institucional consistente e alinhada com o momento da obra ou da entrega.</p>
                </div>

                <form action="{{ route('developments.communications.update', [$development, $communication]) }}" method="POST">
                    @csrf
                    @method('PUT')

                    @include('developments.communications._form')

                    <div class="form-actions">
                        <a href="{{ route('developments.communications.index', $development) }}" class="ghost-button">Cancelar</a>
                        <button type="submit" class="primary-button">Atualizar comunicado</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts::app>