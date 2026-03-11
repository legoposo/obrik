<x-layouts::app :title="__('Nova Unidade')">
    <div class="p-6">
        <div class="page-header">
            <div>
                <h1 class="page-title">Nova Unidade</h1>
                <p class="page-subtitle">Cadastre uma unidade vinculada a um empreendimento seguindo o padrão visual dos demais formulários.</p>
            </div>
        </div>

        <div class="panel-card">
            <div class="panel-card__body">
                <div class="panel-card__intro">
                    <p class="panel-card__eyebrow">Cadastro padronizado</p>
                    <h2 class="panel-card__title">Detalhes da unidade</h2>
                    <p class="panel-card__text">Informe empreendimento, identificação, áreas, valor e status comercial da unidade.</p>
                </div>

                <form action="{{ route('units.store') }}" method="POST">
                    @csrf

                    @include('units._form')

                    <div class="form-actions">
                        <a href="{{ route('units.index') }}" class="ghost-button">Cancelar</a>
                        <button type="submit" class="primary-button">Salvar Unidade</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts::app>
