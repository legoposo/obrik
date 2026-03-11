<?php

namespace App\Http\Controllers;

use App\Models\Builder;
use App\Models\Development;
use Illuminate\Http\Request;

class DevelopmentController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->string('search'));
        $matchedTypes = $this->matchedDevelopmentTypes($search);
        $matchedStatuses = $this->matchedDevelopmentStatuses($search);

        $developments = Development::with('builder')
            ->when($search !== '', function ($query) use ($search, $matchedTypes, $matchedStatuses) {
                $query->where(function ($innerQuery) use ($search, $matchedTypes, $matchedStatuses) {
                    $like = '%'.$search.'%';

                    $innerQuery
                        ->where('name', 'like', $like)
                        ->orWhere('city', 'like', $like)
                        ->orWhere('state', 'like', $like)
                        ->orWhere('address', 'like', $like)
                        ->orWhere('description', 'like', $like)
                        ->orWhereHas('builder', function ($builderQuery) use ($like) {
                            $builderQuery
                                ->where('name', 'like', $like)
                                ->orWhere('city', 'like', $like)
                                ->orWhere('responsible', 'like', $like);
                        });

                    if ($matchedTypes !== []) {
                        $innerQuery->orWhereIn('type', $matchedTypes);
                    }

                    if ($matchedStatuses !== []) {
                        $innerQuery->orWhereIn('status', $matchedStatuses);
                    }
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('developments.index', compact('developments', 'search'));
    }

    public function create()
    {
        return view('developments.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
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

        $builder = Builder::query()->first();

        if (! $builder) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['name' => 'Cadastre uma construtora antes de criar um empreendimento.']);
        }

        Development::create([
            ...$validated,
            'builder_id' => $builder->id,
        ]);

        return redirect()
            ->route('developments.index')
            ->with('success', 'Empreendimento cadastrado com sucesso.');
    }

    public function show(Development $development)
    {
        $development->load([
            'builder',
            'units' => fn ($query) => $query->orderByRaw('LENGTH(identifier)')->orderBy('identifier'),
        ]);

        $units = $development->units;

        $unitStats = [
            'available' => $units->where('status', 'available')->count(),
            'reserved' => $units->where('status', 'reserved')->count(),
            'sold' => $units->where('status', 'sold')->count(),
            'blocked' => $units->where('status', 'blocked')->count(),
        ];

        return view('developments.show', compact('development', 'units', 'unitStats'));
    }

    public function edit(Development $development)
    {
        return view('developments.edit', compact('development'));
    }

    public function update(Request $request, Development $development)
    {
        $validated = $request->validate([
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
            ->with('success', 'Empreendimento excluido com sucesso.');
    }

    protected function matchedDevelopmentTypes(string $search): array
    {
        $normalized = mb_strtolower($search);
        $matchedTypes = [];

        if (str_contains($normalized, 'casa')) {
            $matchedTypes[] = 'houses';
        }

        if (str_contains($normalized, 'apart')) {
            $matchedTypes[] = 'apartments';
        }

        return array_values(array_unique($matchedTypes));
    }

    protected function matchedDevelopmentStatuses(string $search): array
    {
        $normalized = mb_strtolower($search);
        $statusMap = [
            'planejamento' => 'planning',
            'andamento' => 'in_progress',
            'em andamento' => 'in_progress',
            'pausado' => 'paused',
            'concluido' => 'completed',
            'concluído' => 'completed',
            'cancelado' => 'canceled',
        ];

        $matches = [];

        foreach ($statusMap as $term => $status) {
            if (str_contains($normalized, $term)) {
                $matches[] = $status;
            }
        }

        return array_values(array_unique($matches));
    }
}