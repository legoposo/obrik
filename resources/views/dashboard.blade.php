<x-layouts::app :title="__('Dashboard')">

<div class="p-6 space-y-8">

    <div>
        <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">
            Painel do Sistema
        </h1>
        
        <p class="mt-1 text-sm text-zinc-500">
            Visão geral da plataforma de acompanhamento para construtoras e clientes.
        </p>
    </div>
    <p class="text-sm text-zinc-400 mt-1">
{{ now()->format('d/m/Y') }}
</p>

    <!-- KPIs -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

    <div class="rounded-2xl bg-white p-6 shadow-sm hover:shadow-md transition dark:bg-zinc-900">
        <p class="text-sm text-zinc-500">Clientes cadastrados</p>
        <h2 class="mt-2 text-4xl font-bold text-zinc-800 dark:text-white">{{ $clientsCount }}</h2>
    </div>

    <div class="rounded-2xl bg-white p-6 shadow-sm hover:shadow-md transition dark:bg-zinc-900">
        <p class="text-sm text-zinc-500">Contratos ativos</p>
        <h2 class="mt-2 text-4xl font-bold text-zinc-800 dark:text-white">0</h2>
    </div>

    <div class="rounded-2xl bg-white p-6 shadow-sm hover:shadow-md transition dark:bg-zinc-900">
        <p class="text-sm text-zinc-500">Parcelas pendentes</p>
        <h2 class="mt-2 text-4xl font-bold text-zinc-800 dark:text-white">0</h2>
    </div>

    <div class="rounded-2xl bg-white p-6 shadow-sm hover:shadow-md transition dark:bg-zinc-900">
        <p class="text-sm text-zinc-500">Empreendimentos</p>
        <h2 class="mt-2 text-4xl font-bold text-zinc-800 dark:text-white">0</h2>
    </div>

</div>

    </div>

    <!-- Pilares -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        <div class="rounded-2xl bg-gradient-to-r from-blue-500 to-blue-600 p-6 text-white shadow-lg">
            <h2 class="text-xl font-bold">Financeiro</h2>
            <p class="mt-2 text-sm text-blue-100">
                Controle de contratos, parcelas e pagamentos.
            </p>

            <div class="mt-6 text-3xl font-bold">
                R$ 0,00
            </div>

            <p class="mt-1 text-sm text-blue-100">
                Em cobranças cadastradas
            </p>
        </div>

        <div class="rounded-2xl bg-gradient-to-r from-orange-500 to-orange-600 p-6 text-white shadow-lg">
            <h2 class="text-xl font-bold">Obra</h2>
            <p class="mt-2 text-sm text-orange-100">
                Acompanhamento do progresso da construção.
            </p>

            <div class="mt-6 text-3xl font-bold">
                0%
            </div>

            <p class="mt-1 text-sm text-orange-100">
                Progresso médio das obras
            </p>
        </div>

        <div class="rounded-2xl bg-gradient-to-r from-green-500 to-green-600 p-6 text-white shadow-lg">
            <h2 class="text-xl font-bold">Clientes</h2>
            <p class="mt-2 text-sm text-green-100">
                Gestão de clientes e relacionamento.
            </p>

            <div class="mt-6 text-3xl font-bold">
                3
            </div>

            <p class="mt-1 text-sm text-green-100">
                Clientes cadastrados
            </p>
        </div>

    </div>

    <!-- Clientes recentes + resumo -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        <div class="rounded-2xl bg-white p-6 shadow-sm dark:bg-zinc-900 xl:col-span-2">

            <div class="mb-4 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-zinc-800 dark:text-white">
                    Clientes recentes
                </h3>

                <a href="{{ route('clients.index') }}"
                
                   class="text-sm text-blue-600 hover:text-blue-800">
                    Ver todos
                </a>
            </div>

            <div class="space-y-3">

@forelse($recentClients as $client)

    <div class="flex items-center justify-between rounded-xl border border-zinc-200 p-3 hover:bg-zinc-50 transition dark:border-zinc-800 dark:hover:bg-zinc-800">

        <div class="flex items-center gap-3">

            <div class="flex h-9 w-9 items-center justify-center rounded-full bg-blue-100 text-sm font-semibold text-blue-600">
                {{ strtoupper(substr($client->name,0,1)) }}
            </div>

            <div>
                <p class="text-sm font-medium text-zinc-800 dark:text-white">
                    {{ $client->name }}
                </p>

                <p class="text-xs text-zinc-500">
                    {{ $client->created_at->format('d/m/Y') }}
                </p>
            </div>

        </div>

        <a href="{{ route('clients.edit',$client->id) }}"
           class="text-xs text-blue-600 hover:text-blue-800">
            abrir
        </a>

    </div>

@empty

    <p class="text-sm text-zinc-500">
        Nenhum cliente recente.
    </p>

@endforelse

</div>

        </div>

        <div class="rounded-2xl bg-white p-6 shadow-sm dark:bg-zinc-900">

            <h3 class="mb-4 text-lg font-semibold text-zinc-800 dark:text-white">
                Resumo rápido
            </h3>

            <div class="space-y-4">

                <div class="rounded-xl bg-zinc-50 p-4 dark:bg-zinc-800">
                    <p class="text-sm text-zinc-500">
                        Último cliente cadastrado
                    </p>

                    <p class="mt-1 font-medium text-zinc-800 dark:text-white">
                        Leonardo de Souza
                    </p>
                </div>

                <div class="rounded-xl bg-zinc-50 p-4 dark:bg-zinc-800">
                    <p class="text-sm text-zinc-500">
                        Módulo atual
                    </p>

                    <p class="mt-1 font-medium text-zinc-800 dark:text-white">
                        Clientes
                    </p>
                </div>

                <div class="rounded-xl bg-zinc-50 p-4 dark:bg-zinc-800">
                    <p class="text-sm text-zinc-500">
                        Status do sistema
                    </p>

                    <p class="mt-1 font-medium text-green-600">
                        Em evolução
                    </p>
                </div>

            </div>

        </div>

    </div>

</div>

</x-layouts::app>
