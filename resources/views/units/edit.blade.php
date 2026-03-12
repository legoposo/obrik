<x-layouts::app :title="__('Editar Unidade')">
    <div class="p-6">
        <div class="page-header">
            <div>
                <div class="flex items-center gap-3 text-sm text-zinc-500 dark:text-zinc-400">
                    <a href="{{ route('developments.index') }}" class="hover:text-blue-600">Empreendimentos</a>
                    <span>/</span>
                    <a href="{{ route('developments.show', $unit->development) }}" class="hover:text-blue-600">{{ $unit->development->name }}</a>
                    <span>/</span>
                    <span>Editar unidade</span>
                </div>
                <h1 class="page-title mt-3">Editar Unidade</h1>
                <p class="page-subtitle">Atualize os dados da unidade mantendo coerencia com o estoque e a operacao comercial do empreendimento.</p>
            </div>
        </div>

        <div class="panel-card">
            <div class="panel-card__body">
                <div class="panel-card__intro">
                    <p class="panel-card__eyebrow">Ajuste do estoque</p>
                    <h2 class="panel-card__title">Atualizar cadastro da unidade</h2>
                    <p class="panel-card__text">Revise dados fisicos e comerciais antes de avancar para reserva, contrato ou pos-venda.</p>
                </div>

                <form action="{{ route('units.update', $unit) }}" method="POST">
                    @csrf
                    @method('PUT')

                    @include('units._form')

                    <div class="form-actions">
                        <a href="{{ route('units.index', ['development_id' => $unit->development_id]) }}" class="ghost-button">Cancelar</a>
                        <button type="submit" class="primary-button">Atualizar unidade</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts::app>