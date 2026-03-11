<x-layouts::app :title="__('Editar Unidade')">
    <div class="p-6">
        <div class="page-header">
            <div>
                <h1 class="page-title">Editar Unidade</h1>
                <p class="page-subtitle">Atualize os dados da unidade mantendo o mesmo padrão aplicado aos demais cadastros.</p>
            </div>
        </div>

        <div class="panel-card">
            <div class="panel-card__body">
                <div class="panel-card__intro">
                    <p class="panel-card__eyebrow">Cadastro padronizado</p>
                    <h2 class="panel-card__title">Atualizar informações</h2>
                    <p class="panel-card__text">Revise empreendimento, tipologia, metragem, valor e situação comercial da unidade.</p>
                </div>

                <form action="{{ route('units.update', $unit) }}" method="POST">
                    @csrf
                    @method('PUT')

                    @include('units._form')

                    <div class="form-actions">
                        <a href="{{ route('units.index') }}" class="ghost-button">Cancelar</a>
                        <button type="submit" class="primary-button">Atualizar Unidade</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts::app>
