<x-layouts::app :title="__('Editar Empreendimento')">
    <div class="p-6">
        <div class="page-header">
            <div>
                <div class="flex items-center gap-3 text-sm text-zinc-500 dark:text-zinc-400">
                    <a href="{{ route('developments.index') }}" class="hover:text-blue-600">Empreendimentos</a>
                    <span>/</span>
                    <a href="{{ route('developments.show', $development) }}" class="hover:text-blue-600">{{ $development->name }}</a>
                    <span>/</span>
                    <span>Editar</span>
                </div>
                <h1 class="page-title mt-3">Editar Empreendimento</h1>
                <p class="page-subtitle">Atualize as informacoes do hub principal do empreendimento sem perder o historico dos modulos vinculados.</p>
            </div>
        </div>

        <div class="panel-card">
            <div class="panel-card__body">
                <div class="panel-card__intro">
                    <p class="panel-card__eyebrow">Ajustes operacionais</p>
                    <h2 class="panel-card__title">Atualizar cadastro central</h2>
                    <p class="panel-card__text">Mantenha localizacao, cronograma macro e contexto comercial sempre alinhados com a operacao da incorporadora.</p>
                </div>

                <form action="{{ route('developments.update', $development) }}" method="POST">
                    @csrf
                    @method('PUT')

                    @include('developments._form')

                    <div class="form-actions">
                        <a href="{{ route('developments.show', $development) }}" class="ghost-button">Cancelar</a>
                        <button type="submit" class="primary-button">Atualizar empreendimento</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts::app>