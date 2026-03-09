<?php

namespace App\Http\Controllers;

use App\Models\Builder;
use Illuminate\Http\Request;

class BuilderController extends Controller
{
    /**
     * Listagem
     */
    public function index()
    {
        $builders = Builder::latest()->paginate(10);

        return view('builders.index', compact('builders'));
    }

    /**
     * Formulário de criação
     */
    public function create()
    {
        return view('builders.create');
    }

    /**
     * Salvar construtora
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'cnpj' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:2',
            'address' => 'nullable|string|max:255',
            'responsible' => 'nullable|string|max:255',
        ]);

        Builder::create($request->all());

        return redirect()
            ->route('builders.index')
            ->with('success', 'Construtora cadastrada com sucesso!');
    }

    /**
     * Formulário de edição
     */
    public function edit(Builder $builder)
    {
        return view('builders.edit', compact('builder'));
    }

    /**
     * Atualizar
     */
    public function update(Request $request, Builder $builder)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'cnpj' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:2',
            'address' => 'nullable|string|max:255',
            'responsible' => 'nullable|string|max:255',
        ]);

        $builder->update($request->all());

        return redirect()
            ->route('builders.index')
            ->with('success', 'Construtora atualizada com sucesso!');
    }

    /**
     * Excluir
     */
    public function destroy(Builder $builder)
    {
        $builder->delete();

        return redirect()
            ->route('builders.index')
            ->with('success', 'Construtora removida com sucesso!');
    }
}
