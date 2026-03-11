<?php

namespace App\Http\Controllers;

use App\Models\Development;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UnitController extends Controller
{
    public function index()
    {
        $units = Unit::with('development')
            ->latest()
            ->paginate(10);

        return view('units.index', compact('units'));
    }

    public function create()
    {
        $developments = Development::orderBy('name')->get();
        $unit = new Unit();

        return view('units.create', compact('developments', 'unit'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

        Unit::create($validated);

        return redirect()
            ->route('units.index')
            ->with('success', 'Unidade cadastrada com sucesso.');
    }

    public function edit(Unit $unit)
    {
        $developments = Development::orderBy('name')->get();

        return view('units.edit', compact('unit', 'developments'));
    }

    public function update(Request $request, Unit $unit)
    {
        $validated = $request->validate($this->rules($unit));

        $unit->update($validated);

        return redirect()
            ->route('units.index')
            ->with('success', 'Unidade atualizada com sucesso.');
    }

    public function destroy(Unit $unit)
    {
        $unit->delete();

        return redirect()
            ->route('units.index')
            ->with('success', 'Unidade removida com sucesso.');
    }

    protected function rules(?Unit $unit = null): array
    {
        return [
            'development_id' => ['required', 'exists:developments,id'],
            'identifier' => [
                'required',
                'string',
                'max:255',
                Rule::unique('units')
                    ->where(fn ($query) => $query->where('development_id', request('development_id')))
                    ->ignore($unit),
            ],
            'type' => ['required', 'string', 'max:255'],
            'block' => ['nullable', 'string', 'max:255'],
            'floor' => ['nullable', 'string', 'max:255'],
            'private_area' => ['nullable', 'numeric', 'min:0'],
            'total_area' => ['nullable', 'numeric', 'min:0'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'status' => ['required', 'in:available,reserved,sold,blocked'],
            'notes' => ['nullable', 'string'],
        ];
    }
}
