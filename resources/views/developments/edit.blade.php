<x-layouts::app :title="__('Editar Empreendimento')">
    <div class="p-6">
        <div class="page-header">
            <div>
                <h1 class="page-title">Editar Empreendimento</h1>
                <p class="page-subtitle">Atualize os dados do empreendimento cadastrado.</p>
            </div>
        </div>

        <div class="panel-card">
            <div class="panel-card__body">
                <div class="panel-card__intro">
                    <p class="panel-card__eyebrow">Cadastro padronizado</p>
                    <h2 class="panel-card__title">Atualizar informações</h2>
                    <p class="panel-card__text">Mantenha o mesmo padrão visual aplicado aos formulários do sistema.</p>
                </div>

                <form action="{{ route('developments.update', $development) }}" method="POST">
                    @csrf
                    @method('PUT')

                    @include('developments._form')

                    <div class="form-actions">
                        <a href="{{ route('developments.index') }}" class="ghost-button">Cancelar</a>
                        <button type="submit" class="primary-button">Atualizar Empreendimento</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts::app>
