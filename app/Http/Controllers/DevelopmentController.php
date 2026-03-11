<?php

namespace App\Http\Controllers;

use App\Models\Builder;
use App\Models\Development;
use Illuminate\Http\Request;

class DevelopmentController extends Controller
{
    public function index()
    {
        $developments = Development::with('builder')
            ->latest()
            ->paginate(10);

        return view('developments.index', compact('developments'));
    }

    public function create()
    {
        $builders = Builder::orderBy('name')->get();

        return view('developments.create', compact('builders'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'builder_id' => ['required', 'exists:builders,id'],
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:houses,apartments'],
            'city' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'size:2'],
            'address' => ['nullable', 'string', 'max:255'],
            'start_date' => ['nullable', 'date'],
            'expected_delivery_date' => ['nullable', 'date'],
            'status' => ['required', 'in:planning,in_progress,paused,completed,canceled'],
            'description' => ['nullable', 'string'],
        ]);

        Development::create($validated);

        return redirect()
            ->route('developments.index')
            ->with('success', 'Empreendimento cadastrado com sucesso.');
    }

    public function edit(Development $development)
    {
        $builders = Builder::orderBy('name')->get();

        return view('developments.edit', compact('development', 'builders'));
    }

    public function update(Request $request, Development $development)
    {
        $validated = $request->validate([
            'builder_id' => ['required', 'exists:builders,id'],
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:houses,apartments'],
            'city' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'size:2'],
            'address' => ['nullable', 'string', 'max:255'],
            'start_date' => ['nullable', 'date'],
            'expected_delivery_date' => ['nullable', 'date'],
            'status' => ['required', 'in:planning,in_progress,paused,completed,canceled'],
            'description' => ['nullable', 'string'],
        ]);

        $development->update($validated);

        return redirect()
            ->route('developments.index')
            ->with('success', 'Empreendimento atualizado com sucesso.');
    }

    public function destroy(Development $development)
    {
        $development->delete();

        return redirect()
            ->route('developments.index')
            ->with('success', 'Empreendimento excluído com sucesso.');
    }
}
