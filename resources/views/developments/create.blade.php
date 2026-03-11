<x-layouts::app :title="__('Novo Empreendimento')">
    <div class="p-6">
        <div class="page-header">
            <div>
                <h1 class="page-title">Novo Empreendimento</h1>
                <p class="page-subtitle">Cadastre um novo condomínio ou edifício no mesmo padrão dos outros módulos.</p>
            </div>
        </div>

        <div class="panel-card">
            <div class="panel-card__body">
                <div class="panel-card__intro">
                    <p class="panel-card__eyebrow">Cadastro padronizado</p>
                    <h2 class="panel-card__title">Detalhes do empreendimento</h2>
                    <p class="panel-card__text">Organize as informações principais do empreendimento com a mesma experiência visual de obras, clientes e financeiro.</p>
                </div>

                <form action="{{ route('developments.store') }}" method="POST">
                    @csrf

                    @include('developments._form')

                    <div class="form-actions">
                        <a href="{{ route('developments.index') }}" class="ghost-button">Cancelar</a>
                        <button type="submit" class="primary-button">Salvar Empreendimento</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts::app>
