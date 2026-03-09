<x-layouts::app :title="__('Editar Construtora')">

    <div class="p-6">

        <div class="mb-6">
            <h1 class="text-2xl font-bold text-zinc-800 dark:text-white">
                Editar Construtora
            </h1>

            <p class="mt-1 text-sm text-zinc-500">
                Atualize os dados da construtora cadastrada.
            </p>
        </div>

        <div class="rounded-2xl bg-white p-6 shadow dark:bg-zinc-900">

            <form method="POST" action="{{ route('builders.update', $builder->id) }}"
                class="grid grid-cols-1 gap-6 md:grid-cols-2">

                @csrf
                @method('PUT')


                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-200">
                        Nome
                    </label>

                    <input type="text" name="name" value="{{ old('name', $builder->name) }}"
                        class="w-full rounded-xl border border-zinc-300 px-4 py-2 text-sm focus:border-blue-500 focus:outline-none dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                </div>


                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-200">
                        CNPJ
                    </label>

                    <input type="text" name="cnpj" value="{{ old('cnpj', $builder->cnpj) }}"
                        class="w-full rounded-xl border border-zinc-300 px-4 py-2 text-sm focus:border-blue-500 focus:outline-none dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                </div>


                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-200">
                        Email
                    </label>

                    <input type="email" name="email" value="{{ old('email', $builder->email) }}"
                        class="w-full rounded-xl border border-zinc-300 px-4 py-2 text-sm focus:border-blue-500 focus:outline-none dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                </div>


                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-200">
                        Telefone
                    </label>

                    <input type="text" name="phone" value="{{ old('phone', $builder->phone) }}"
                        class="w-full rounded-xl border border-zinc-300 px-4 py-2 text-sm focus:border-blue-500 focus:outline-none dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                </div>


                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-200">
                        Cidade
                    </label>

                    <input type="text" name="city" value="{{ old('city', $builder->city) }}"
                        class="w-full rounded-xl border border-zinc-300 px-4 py-2 text-sm focus:border-blue-500 focus:outline-none dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                </div>


                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-200">
                        Estado
                    </label>

                    <input type="text" name="state" value="{{ old('state', $builder->state) }}"
                        class="w-full rounded-xl border border-zinc-300 px-4 py-2 text-sm focus:border-blue-500 focus:outline-none dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                </div>


                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-200">
                        Endereço
                    </label>

                    <input type="text" name="address" value="{{ old('address', $builder->address) }}"
                        class="w-full rounded-xl border border-zinc-300 px-4 py-2 text-sm focus:border-blue-500 focus:outline-none dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                </div>


                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-200">
                        Responsável
                    </label>

                    <input type="text" name="responsible" value="{{ old('responsible', $builder->responsible) }}"
                        class="w-full rounded-xl border border-zinc-300 px-4 py-2 text-sm focus:border-blue-500 focus:outline-none dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                </div>


                <div class="md:col-span-2 flex justify-end gap-3">

                    <a href="{{ route('builders.index') }}"
                        class="rounded-xl border border-zinc-300 px-4 py-2 text-sm font-medium text-zinc-700 hover:bg-zinc-100 dark:border-zinc-700 dark:text-zinc-200 dark:hover:bg-zinc-800">
                        Cancelar
                    </a>

                    <button type="submit"
                        class="rounded-xl bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">
                        Atualizar Construtora
                    </button>

                </div>

            </form>

        </div>

    </div>

</x-layouts::app>
