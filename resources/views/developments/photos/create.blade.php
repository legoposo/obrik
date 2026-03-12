<x-layouts::app :title="__('Nova Foto da Obra')">
    <div class="p-6">
        <div class="page-header">
            <div>
                <h1 class="page-title">Nova Foto da Obra</h1>
                <p class="page-subtitle">Adicione um novo registro visual para o empreendimento {{ $development->name }}.</p>
            </div>
        </div>

        <div class="panel-card">
            <div class="panel-card__body">
                <div class="panel-card__intro">
                    <p class="panel-card__eyebrow">Atualizacao visual</p>
                    <h2 class="panel-card__title">Dados da foto</h2>
                    <p class="panel-card__text">Organize a galeria da obra com imagens, datas e descricoes que facilitem a leitura do historico.</p>
                </div>

                <form action="{{ route('developments.photos.store', $development) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    @include('developments.photos._form')

                    <div class="form-actions">
                        <a href="{{ route('developments.photos.index', $development) }}" class="ghost-button">Cancelar</a>
                        <button type="submit" class="primary-button">Salvar foto</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts::app>