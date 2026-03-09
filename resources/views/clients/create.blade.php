<x-layouts::app :title="__('Novo Cliente')">
    <div class="p-6">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-zinc-800 dark:text-white">
                Novo Cliente
            </h1>
            <p class="mt-1 text-sm text-zinc-500">
                Cadastre um novo cliente no Obryn.
            </p>
        </div>

        <div class="rounded-2xl bg-white p-6 shadow dark:bg-zinc-900">
            <form action="{{ route('clients.store') }}" method="POST" class="grid grid-cols-1 gap-6 md:grid-cols-2">
                @csrf

                <div class="md:col-span-2">
                    <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-200">Nome</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        class="w-full rounded-xl border border-zinc-300 px-4 py-2 focus:border-blue-500 focus:outline-none">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-200">E-mail</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="w-full rounded-xl border border-zinc-300 px-4 py-2 focus:border-blue-500 focus:outline-none">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-200">Telefone</label>
                    <input type="text" name="phone" value="{{ old('phone') }}"
                        class="w-full rounded-xl border border-zinc-300 px-4 py-2 focus:border-blue-500 focus:outline-none">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-200">CPF</label>
                    <input type="text" name="cpf" value="{{ old('cpf') }}"
                        class="w-full rounded-xl border border-zinc-300 px-4 py-2 focus:border-blue-500 focus:outline-none">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-200">RG</label>
                    <input type="text" name="rg" value="{{ old('rg') }}"
                        class="w-full rounded-xl border border-zinc-300 px-4 py-2 focus:border-blue-500 focus:outline-none">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-200">Data de nascimento</label>
                    <input type="date" name="birth_date" value="{{ old('birth_date') }}"
                        class="w-full rounded-xl border border-zinc-300 px-4 py-2 focus:border-blue-500 focus:outline-none">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-200">CEP</label>
                    <input type="text" name="zip_code" value="{{ old('zip_code') }}"
                        class="w-full rounded-xl border border-zinc-300 px-4 py-2 focus:border-blue-500 focus:outline-none">
                </div>

                <div class="md:col-span-2">
                    <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-200">Endereço</label>
                    <input type="text" name="address" value="{{ old('address') }}"
                        class="w-full rounded-xl border border-zinc-300 px-4 py-2 focus:border-blue-500 focus:outline-none">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-200">Cidade</label>
                    <input type="text" name="city" value="{{ old('city') }}"
                        class="w-full rounded-xl border border-zinc-300 px-4 py-2 focus:border-blue-500 focus:outline-none">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-200">Estado</label>
                    <input type="text" name="state" value="{{ old('state') }}" maxlength="2"
                        class="w-full rounded-xl border border-zinc-300 px-4 py-2 focus:border-blue-500 focus:outline-none">
                </div>

                <div class="md:col-span-2 flex justify-end gap-3">
                    <a href="{{ route('clients.index') }}"
                       class="rounded-xl border border-zinc-300 px-4 py-2 text-sm font-medium text-zinc-700 hover:bg-zinc-100">
                        Cancelar
                    </a>

                    <button type="submit"
                        class="rounded-xl bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">
                        Salvar Cliente
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts::app>