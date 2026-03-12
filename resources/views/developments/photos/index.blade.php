<x-layouts::app :title="__('Fotos da Obra')">
    <div class="p-6 space-y-6">
        <div class="page-header">
            <div>
                <div class="flex flex-wrap items-center gap-3 text-sm text-zinc-500 dark:text-zinc-400">
                    <a href="{{ route('developments.index') }}" class="hover:text-blue-600">Empreendimentos</a>
                    <span>/</span>
                    <a href="{{ route('developments.show', $development) }}" class="hover:text-blue-600">{{ $development->name }}</a>
                    <span>/</span>
                    <span>Fotos da obra</span>
                </div>
                <h1 class="page-title mt-3">Fotos da Obra</h1>
                <p class="page-subtitle">Mantenha um historico visual da evolucao do empreendimento com galerias organizadas por data e contexto.</p>
            </div>

            <div class="flex flex-col gap-3 sm:flex-row">
                <a href="{{ route('developments.show', $development) }}" class="ghost-button">Voltar ao empreendimento</a>
                <a href="{{ route('developments.photos.create', $development) }}" class="primary-button">Adicionar foto</a>
            </div>
        </div>

        @if (session('success'))
            <div class="success-alert">{{ session('success') }}</div>
        @endif

        <div class="panel-card">
            <div class="panel-card__body">
                <div class="panel-card__intro mb-0">
                    <p class="panel-card__eyebrow">Memoria visual</p>
                    <h2 class="panel-card__title">Galeria do empreendimento</h2>
                    <p class="panel-card__text">Cada imagem ajuda a construir um historico claro da obra para operacao interna, clientes e futuras entregas.</p>
                </div>
            </div>
        </div>

        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
            @forelse ($photos as $photo)
                <article class="overflow-hidden rounded-3xl border border-zinc-200 bg-white shadow-sm shadow-zinc-200/50 dark:border-zinc-800 dark:bg-zinc-900 dark:shadow-none">
                    <div class="aspect-[4/3] bg-zinc-100 dark:bg-zinc-800">
                        <img src="{{ asset('storage/'.$photo->image_path) }}" alt="{{ $photo->title }}" class="h-full w-full object-cover">
                    </div>

                    <div class="p-5 space-y-4">
                        <div>
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="text-sm font-semibold text-zinc-900 dark:text-white">{{ $photo->title }}</p>
                                    <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">{{ $photo->date?->format('d/m/Y') ?? '-' }}</p>
                                </div>
                            </div>

                            @if ($photo->description)
                                <p class="mt-3 text-sm leading-6 text-zinc-600 dark:text-zinc-300">{{ \Illuminate\Support\Str::limit($photo->description, 140) }}</p>
                            @endif
                        </div>

                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('developments.photos.edit', [$development, $photo]) }}" class="action-icon action-icon--edit" title="Editar foto">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487a2.1 2.1 0 1 1 2.97 2.97L8.25 19.04 4 20l.96-4.25 11.902-11.263Z" />
                                </svg>
                            </a>

                            <form action="{{ route('developments.photos.destroy', [$development, $photo]) }}" method="POST" onsubmit="return confirm('Deseja realmente excluir esta foto?')">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="action-icon action-icon--delete" title="Excluir foto">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 7h12M9 7V5.75A1.75 1.75 0 0 1 10.75 4h2.5A1.75 1.75 0 0 1 15 5.75V7m-7 0 1 11.25A1.75 1.75 0 0 0 10.74 20h2.52A1.75 1.75 0 0 0 15 18.25L16 7" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </article>
            @empty
                <div class="rounded-3xl border border-dashed border-zinc-300 bg-white px-6 py-12 text-center text-sm text-zinc-500 shadow-sm md:col-span-2 xl:col-span-3 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-400 dark:shadow-none">
                    Nenhuma foto cadastrada ainda. Use o botao "Adicionar foto" para iniciar a galeria do empreendimento.
                </div>
            @endforelse
        </div>

        <div class="table-card">
            <div class="border-t border-zinc-100 px-6 py-4 dark:border-zinc-800">
                {{ $photos->links() }}
            </div>
        </div>
    </div>
</x-layouts::app>