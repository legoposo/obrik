<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Work;
use Illuminate\Http\Request;

class WorkController extends Controller
{
    public function index()
    {
        $works = Work::with('client')
            ->withCount('stages')
            ->withCount([
                'stages as completed_stages_count' => fn ($query) => $query->where('status', 'completed'),
            ])
            ->latest()
            ->paginate(10);

        return view('works.index', compact('works'));
    }

    public function create()
    {
        $clients = Client::orderBy('name')->get();

        return view('works.create', compact('clients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => ['required', 'exists:clients,id'],
            'name' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'state' => ['nullable', 'string', 'max:2'],
            'zip_code' => ['nullable', 'string', 'max:20'],
            'start_date' => ['nullable', 'date'],
            'expected_end_date' => ['nullable', 'date'],
            'status' => ['required', 'string'],
            'budget' => ['nullable', 'numeric'],
            'notes' => ['nullable', 'string'],
        ]);

        Work::create($validated);

        return redirect()
            ->route('works.index')
            ->with('success', 'Obra cadastrada com sucesso.');
    }

    public function edit(Work $work)
    {
        $clients = Client::orderBy('name')->get();

        return view('works.edit', compact('work', 'clients'));
    }

    public function update(Request $request, Work $work)
    {
        $validated = $request->validate([
            'client_id' => ['required', 'exists:clients,id'],
            'name' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'state' => ['nullable', 'string', 'max:2'],
            'zip_code' => ['nullable', 'string', 'max:20'],
            'start_date' => ['nullable', 'date'],
            'expected_end_date' => ['nullable', 'date'],
            'status' => ['required', 'string'],
            'budget' => ['nullable', 'numeric'],
            'notes' => ['nullable', 'string'],
        ]);

        $work->update($validated);

        return redirect()
            ->route('works.index')
            ->with('success', 'Obra atualizada com sucesso.');
    }

    public function destroy(Work $work)
    {
        $work->delete();

        return redirect()
            ->route('works.index')
            ->with('success', 'Obra removida com sucesso.');
    }
}
