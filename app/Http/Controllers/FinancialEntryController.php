<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\FinancialEntry;
use App\Models\Work;
use Illuminate\Http\Request;

class FinancialEntryController extends Controller
{
    public function index()
    {
        $entries = FinancialEntry::with(['work', 'client'])
            ->latest()
            ->paginate(10);

        return view('financial.index', compact('entries'));
    }

    public function create()
    {
        $works = Work::orderBy('name')->get();
        $clients = Client::orderBy('name')->get();

        return view('financial.create', compact('works', 'clients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'work_id' => ['required', 'exists:works,id'],
            'client_id' => ['nullable', 'exists:clients,id'],
            'type' => ['required', 'in:income,expense'],
            'description' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:0'],
            'due_date' => ['nullable', 'date'],
            'paid_at' => ['nullable', 'date'],
            'status' => ['required', 'in:pending,paid,overdue'],
            'notes' => ['nullable', 'string'],
        ]);

        FinancialEntry::create($validated);

        return redirect()
            ->route('financial.index')
            ->with('success', 'Lançamento financeiro cadastrado com sucesso.');
    }

    public function edit(FinancialEntry $financial)
    {
        $works = Work::orderBy('name')->get();
        $clients = Client::orderBy('name')->get();

        return view('financial.edit', compact('financial', 'works', 'clients'));
    }

    public function update(Request $request, FinancialEntry $financial)
    {
        $validated = $request->validate([
            'work_id' => ['required', 'exists:works,id'],
            'client_id' => ['nullable', 'exists:clients,id'],
            'type' => ['required', 'in:income,expense'],
            'description' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:0'],
            'due_date' => ['nullable', 'date'],
            'paid_at' => ['nullable', 'date'],
            'status' => ['required', 'in:pending,paid,overdue'],
            'notes' => ['nullable', 'string'],
        ]);

        $financial->update($validated);

        return redirect()
            ->route('financial.index')
            ->with('success', 'Lançamento financeiro atualizado com sucesso.');
    }

    public function destroy(FinancialEntry $financial)
    {
        $financial->delete();

        return redirect()
            ->route('financial.index')
            ->with('success', 'Lançamento financeiro removido com sucesso.');
    }
}
