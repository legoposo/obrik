<x-layouts::app :title="__('Editar Foto da Obra')">
    <div class="p-6">
        <div class="page-header">
            <div>
                <h1 class="page-title">Editar Foto da Obra</h1>
                <p class="page-subtitle">Atualize o registro visual {{ $photo->title }} do empreendimento {{ $development->name }}.</p>
            </div>
        </div>

        <div class="panel-card">
            <div class="panel-card__body">
                <div class="panel-card__intro">
                    <p class="panel-card__eyebrow">Ajuste da galeria</p>
                    <h2 class="panel-card__title">Atualizar foto</h2>
                    <p class="panel-card__text">Refine descricao, data ou imagem para manter a memoria visual da obra consistente.</p>
                </div>

                <form action="{{ route('developments.photos.update', [$development, $photo]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    @include('developments.photos._form')

                    <div class="form-actions">
                        <a href="{{ route('developments.photos.index', $development) }}" class="ghost-button">Cancelar</a>
                        <button type="submit" class="primary-button">Atualizar foto</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts::app>