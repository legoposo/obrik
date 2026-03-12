<?php

namespace App\Http\Controllers;

use App\Models\Development;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UnitController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->string('search'));
        $status = trim((string) $request->string('status'));
        $developmentId = $request->integer('development_id') ?: null;

        $units = Unit::query()
            ->with('development:id,name')
            ->when($developmentId, fn ($query) => $query->where('development_id', $developmentId))
            ->when($status !== '', fn ($query) => $query->where('status', $status))
            ->when($search !== '', function ($query) use ($search) {
                $like = '%'.$search.'%';

                $query->where(function ($innerQuery) use ($like) {
                    $innerQuery
                        ->where('unit_number', 'like', $like)
                        ->orWhere('identifier', 'like', $like)
                        ->orWhere('block_or_tower', 'like', $like)
                        ->orWhere('block', 'like', $like)
                        ->orWhere('type', 'like', $like)
                        ->orWhere('notes', 'like', $like)
                        ->orWhereHas('development', fn ($developmentQuery) => $developmentQuery->where('name', 'like', $like));
                });
            })
            ->orderBy('development_id')
            ->orderBy('block_or_tower')
            ->orderBy('unit_number')
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        $developments = Development::query()
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('units.index', compact('units', 'developments', 'search', 'status', 'developmentId'));
    }

    public function create(Request $request): View
    {
        $developments = Development::orderBy('name')->get();
        $unit = new Unit([
            'development_id' => $request->integer('development_id') ?: null,
            'status' => 'disponivel',
        ]);

        return view('units.create', compact('developments', 'unit'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

        Unit::create($this->payload($validated, null));

        return redirect()
            ->route('units.index', ['development_id' => $validated['development_id']])
            ->with('success', 'Unidade cadastrada com sucesso.');
    }

    public function edit(Unit $unit): View
    {
        $developments = Development::orderBy('name')->get();

        return view('units.edit', compact('unit', 'developments'));
    }

    public function update(Request $request, Unit $unit)
    {
        $validated = $request->validate($this->rules($unit));

        $unit->update($this->payload($validated, $unit));

        return redirect()
            ->route('units.index', ['development_id' => $validated['development_id']])
            ->with('success', 'Unidade atualizada com sucesso.');
    }

    public function destroy(Unit $unit)
    {
        $developmentId = $unit->development_id;
        $unit->delete();

        return redirect()
            ->route('units.index', ['development_id' => $developmentId])
            ->with('success', 'Unidade removida com sucesso.');
    }

    protected function rules(?Unit $unit = null): array
    {
        return [
            'development_id' => ['required', 'exists:developments,id'],
            'block_or_tower' => ['nullable', 'string', 'max:255'],
            'unit_number' => [
                'required',
                'string',
                'max:255',
                Rule::unique('units', 'unit_number')
                    ->where(fn ($query) => $query->where('development_id', request('development_id')))
                    ->ignore($unit),
            ],
            'type' => ['required', 'string', 'max:255'],
            'area' => ['nullable', 'numeric', 'min:0'],
            'bedrooms' => ['nullable', 'integer', 'min:0'],
            'parking_spaces' => ['nullable', 'integer', 'min:0'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'status' => ['required', 'in:disponivel,reservada,vendida,bloqueada'],
            'notes' => ['nullable', 'string'],
        ];
    }

    protected function payload(array $validated, ?Unit $unit): array
    {
        return [
            ...$validated,
            'identifier' => $validated['unit_number'],
            'block' => $validated['block_or_tower'] ?? null,
            'private_area' => $validated['area'] ?? null,
            'total_area' => $validated['area'] ?? $unit?->total_area,
        ];
    }
}