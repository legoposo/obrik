<x-layouts::app :title="__('Nova Obra')">
    <div class="p-6">
        <div class="page-header">
            <div>
                <h1 class="page-title">Nova Obra</h1>
                <p class="page-subtitle">Preencha os dados para cadastrar uma nova obra.</p>
            </div>
        </div>

        <div class="panel-card">
            <div class="panel-card__body">
                <div class="panel-card__intro">
                    <p class="panel-card__eyebrow">Cadastro padronizado</p>
                    <h2 class="panel-card__title">Detalhes da obra</h2>
                    <p class="panel-card__text">Use este formulario para registrar a obra com o mesmo padrao visual dos modulos de clientes e financeiro.</p>
                </div>

                <form action="{{ route('works.store') }}" method="POST">
                    @csrf

                    @include('works._form')

                    <div class="form-actions">
                        <a href="{{ route('works.index') }}" class="ghost-button">Cancelar</a>
                        <button type="submit" class="primary-button">Salvar Obra</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts::app>
