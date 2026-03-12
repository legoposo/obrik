<x-layouts::app :title="__('Portal do Cliente')">
    <div class="p-6 space-y-6">
        <div class="page-header">
            <div>
                <h1 class="page-title">Portal do Cliente</h1>
                <p class="page-subtitle">Espaco dedicado para consolidar a experiencia do cliente com documentos, atualizacoes de obra, comunicados e acompanhamento de jornada.</p>
            </div>
        </div>

        <div class="panel-card">
            <div class="panel-card__body">
                <div class="panel-card__intro mb-0">
                    <p class="panel-card__eyebrow">Relacionamento</p>
                    <h2 class="panel-card__title">Modulo em evolucao</h2>
                    <p class="panel-card__text">A navegacao ja reserva um espaco proprio para o Portal do Cliente. Enquanto o modulo completo nao entra em operacao, voce pode usar os atalhos abaixo para gerenciar relacionamento e comunicacao.</p>
                </div>
            </div>
        </div>

        <div class="grid gap-4 md:grid-cols-3">
            <div class="report-stat-card report-stat-card--info">
                <p class="report-stat-card__label">Objetivo</p>
                <p class="mt-3 text-lg font-semibold text-zinc-900 dark:text-white">Centralizar a experiencia do cliente</p>
                <p class="report-stat-card__meta">Atualizacoes, documentos, comunicados e acompanhamento do empreendimento em um unico ambiente.</p>
            </div>

            <div class="report-stat-card report-stat-card--warning">
                <p class="report-stat-card__label">Momento atual</p>
                <p class="mt-3 text-lg font-semibold text-zinc-900 dark:text-white">Estruturacao da navegacao</p>
                <p class="report-stat-card__meta">Este espaco prepara o sistema para a proxima fase do relacionamento com compradores e pos-venda.</p>
            </div>

            <div class="report-stat-card report-stat-card--success">
                <p class="report-stat-card__label">Proximos passos</p>
                <p class="mt-3 text-lg font-semibold text-zinc-900 dark:text-white">Documentos, timeline e area autenticada</p>
                <p class="report-stat-card__meta">A base de clientes, comunicados e fotos da obra ja esta pronta para evoluir para um portal dedicado.</p>
            </div>
        </div>

        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
            <a href="{{ route('clients.index') }}" class="report-link-card">
                <p class="report-stat-card__label">Clientes</p>
                <h2 class="mt-2 text-lg font-semibold text-zinc-900 dark:text-white">Base comercial</h2>
                <p class="report-stat-card__meta">Gerencie leads, compradores e clientes de pos-venda.</p>
            </a>

            <a href="{{ route('construction.communications') }}" class="report-link-card">
                <p class="report-stat-card__label">Comunicacao</p>
                <h2 class="mt-2 text-lg font-semibold text-zinc-900 dark:text-white">Comunicados por empreendimento</h2>
                <p class="report-stat-card__meta">Publique avisos e acompanhe o historico de mensagens.</p>
            </a>

            <a href="{{ route('reports.clients') }}" class="report-link-card">
                <p class="report-stat-card__label">Analise</p>
                <h2 class="mt-2 text-lg font-semibold text-zinc-900 dark:text-white">Relatorio de clientes</h2>
                <p class="report-stat-card__meta">Avalie a carteira e a evolucao do relacionamento comercial.</p>
            </a>
        </div>
    </div>
</x-layouts::app>