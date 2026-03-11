<x-layouts::app :title="__('Clientes')">
    <div class="p-6">
        <div class="page-header">
            <div>
                <h1 class="page-title">Clientes</h1>
                <p class="page-subtitle">Gerencie os clientes cadastrados no Obryn.</p>
            </div>

            <a href="{{ route('clients.create') }}" class="primary-button">Novo Cliente</a>
        </div>

        @if(session('success'))
            <div class="success-alert">{{ session('success') }}</div>
        @endif

        <div class="table-card">
            <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-800">
                <thead class="bg-zinc-50 dark:bg-zinc-800">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">Nome</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">E-mail</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">Telefone</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">CPF</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-zinc-500">Acoes</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                    @forelse($clients as $client)
                        <tr>
                            <td class="px-6 py-4 text-sm text-zinc-700 dark:text-zinc-200">{{ $client->name }}</td>
                            <td class="px-6 py-4 text-sm text-zinc-700 dark:text-zinc-200">{{ $client->email }}</td>
                            <td class="px-6 py-4 text-sm text-zinc-700 dark:text-zinc-200">{{ preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $client->phone) }}</td>
                            <td class="px-6 py-4 text-sm text-zinc-700 dark:text-zinc-200">{{ $client->cpf }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('clients.edit', $client->id) }}" class="action-icon action-icon--edit" title="Editar" aria-label="Editar cliente">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487a2.1 2.1 0 1 1 2.97 2.97L8.25 19.04 4 20l.96-4.25 11.902-11.263Z" />
                                        </svg>
                                    </a>

                                    <form action="{{ route('clients.destroy', $client->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este cliente?');">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="action-icon action-icon--delete" title="Excluir" aria-label="Excluir cliente">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 7h12M9 7V5.75A1.75 1.75 0 0 1 10.75 4h2.5A1.75 1.75 0 0 1 15 5.75V7m-7 0 1 11.25A1.75 1.75 0 0 0 10.74 20h2.52A1.75 1.75 0 0 0 15 18.25L16 7" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-sm text-zinc-700 dark:text-zinc-200">Nenhum cliente cadastrado ainda</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts::app>
