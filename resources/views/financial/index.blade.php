<x-layouts::app>
    <div class="p-6">
        <div class="page-header">
            <div>
                <h1 class="page-title">Financeiro</h1>
                <p class="page-subtitle">Gerencie receitas e despesas vinculadas as obras.</p>
            </div>

            <a href="{{ route('financial.create') }}" class="primary-button">Novo lancamento</a>
        </div>

        @if (session('success'))
            <div class="success-alert">{{ session('success') }}</div>
        @endif

        <div class="table-card">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-zinc-100 text-left text-zinc-600 dark:bg-zinc-800 dark:text-zinc-300">
                        <tr>
                            <th class="px-6 py-4 font-semibold">Obra</th>
                            <th class="px-6 py-4 font-semibold">Cliente</th>
                            <th class="px-6 py-4 font-semibold">Descricao</th>
                            <th class="px-6 py-4 font-semibold">Tipo</th>
                            <th class="px-6 py-4 font-semibold">Valor</th>
                            <th class="px-6 py-4 font-semibold">Vencimento</th>
                            <th class="px-6 py-4 font-semibold">Status</th>
                            <th class="px-6 py-4 font-semibold text-right">Acoes</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                        @forelse ($entries as $entry)
                            <tr class="text-zinc-700 dark:text-zinc-200">
                                <td class="px-6 py-4">{{ $entry->work->name ?? '-' }}</td>
                                <td class="px-6 py-4">{{ $entry->client->name ?? '-' }}</td>
                                <td class="px-6 py-4">{{ $entry->description }}</td>
                                <td class="px-6 py-4">{{ $entry->type === 'income' ? 'Receita' : 'Despesa' }}</td>
                                <td class="px-6 py-4">R$ {{ number_format($entry->amount, 2, ',', '.') }}</td>
                                <td class="px-6 py-4">{{ $entry->due_date ? $entry->due_date->format('d/m/Y') : '-' }}</td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusMap = [
                                            'pending' => ['label' => 'Pendente', 'class' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-300'],
                                            'paid' => ['label' => 'Pago', 'class' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300'],
                                            'overdue' => ['label' => 'Atrasado', 'class' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300'],
                                        ];
                                        $status = $statusMap[$entry->status] ?? ['label' => $entry->status, 'class' => 'bg-zinc-100 text-zinc-700'];
                                    @endphp

                                    <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $status['class'] }}">{{ $status['label'] }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('financial.edit', $entry) }}" class="action-icon action-icon--edit" title="Editar" aria-label="Editar lancamento">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487a2.1 2.1 0 1 1 2.97 2.97L8.25 19.04 4 20l.96-4.25 11.902-11.263Z" />
                                            </svg>
                                        </a>

                                        <form action="{{ route('financial.destroy', $entry) }}" method="POST" onsubmit="return confirm('Deseja remover este lancamento?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="action-icon action-icon--delete" title="Excluir" aria-label="Excluir lancamento">
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
                                <td colspan="8" class="px-6 py-8 text-center text-zinc-500 dark:text-zinc-400">Nenhum lancamento financeiro cadastrado.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="border-t border-zinc-200 px-6 py-4 dark:border-zinc-800">{{ $entries->links() }}</div>
        </div>
    </div>
</x-layouts::app>
