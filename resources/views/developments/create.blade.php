<x-layouts::app :title="__('Novo Empreendimento')">
    <div class="p-6">
        <div class="page-header">
            <div>
                <div class="flex items-center gap-3 text-sm text-zinc-500 dark:text-zinc-400">
                    <a href="{{ route('developments.index') }}" class="hover:text-blue-600">Empreendimentos</a>
                    <span>/</span>
                    <span>Novo cadastro</span>
                </div>
                <h1 class="page-title mt-3">Novo Empreendimento</h1>
                <p class="page-subtitle">Cadastre o empreendimento e prepare a base para unidades, reservas, andamento, comunicados e fotos da obra.</p>
            </div>
        </div>

        <div class="panel-card">
            <div class="panel-card__body">
                <div class="panel-card__intro">
                    <p class="panel-card__eyebrow">Centro da operacao</p>
                    <h2 class="panel-card__title">Dados principais do empreendimento</h2>
                    <p class="panel-card__text">A partir deste cadastro a OBRYN organiza toda a operacao da incorporadora em torno do empreendimento.</p>
                </div>

                <form action="{{ route('developments.store') }}" method="POST">
                    @csrf

                    @include('developments._form')

                    <div class="form-actions">
                        <a href="{{ route('developments.index') }}" class="ghost-button">Cancelar</a>
                        <button type="submit" class="primary-button">Salvar empreendimento</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts::app>