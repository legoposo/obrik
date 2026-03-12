<?php

namespace App\Http\Controllers;

use App\Models\Builder;
use App\Models\Client;
use App\Models\Development;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DevelopmentController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->string('search'));

        $developments = Development::query()
            ->withCount([
                'units',
                'units as available_units_count' => fn ($query) => $query->where('status', 'disponivel'),
                'contracts as active_contracts_count' => fn ($query) => $query->whereIn('status', ['reserva', 'proposta', 'contrato_assinado']),
            ])
            ->when($search !== '', function ($query) use ($search) {
                $like = '%'.$search.'%';

                $query->where(function ($innerQuery) use ($like) {
                    $innerQuery
                        ->where('name', 'like', $like)
                        ->orWhere('location', 'like', $like)
                        ->orWhere('description', 'like', $like)
                        ->orWhere('notes', 'like', $like)
                        ->orWhere('status', 'like', $like);
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('developments.index', compact('developments', 'search'));
    }

    public function create(): View
    {
        $development = new Development([
            'status' => 'planejamento',
        ]);

        return view('developments.create', compact('development'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateDevelopment($request);
        $builder = Builder::query()->first();

        if (! $builder) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['name' => 'Cadastre uma incorporadora/construtora antes de criar um empreendimento.']);
        }

        Development::create($this->developmentPayload($validated, null, $builder->id));

        return redirect()
            ->route('developments.index')
            ->with('success', 'Empreendimento cadastrado com sucesso.');
    }

    public function show(Development $development): View
    {
        $development->loadCount([
            'units',
            'units as available_units_count' => fn ($query) => $query->where('status', 'disponivel'),
            'units as reserved_units_count' => fn ($query) => $query->where('status', 'reservada'),
            'units as sold_units_count' => fn ($query) => $query->where('status', 'vendida'),
            'contracts as active_contracts_count' => fn ($query) => $query->whereIn('status', ['reserva', 'proposta', 'contrato_assinado']),
            'communications',
            'photos',
            'stages',
        ]);

        $units = $development->units()
            ->orderBy('block_or_tower')
            ->orderBy('unit_number')
            ->take(6)
            ->get();

        $contracts = $development->contracts()
            ->with(['client', 'unit'])
            ->latest('contract_date')
            ->take(5)
            ->get();

        $linkedClients = Client::query()
            ->select('clients.*')
            ->whereHas('contracts', fn ($query) => $query->where('development_id', $development->id))
            ->orderBy('name')
            ->distinct()
            ->take(6)
            ->get();

        $stages = $development->stages()
            ->orderByRaw("CASE status WHEN 'em_andamento' THEN 0 WHEN 'pendente' THEN 1 WHEN 'concluido' THEN 2 ELSE 3 END")
            ->orderBy('expected_date')
            ->get();

        $communications = $development->communications()
            ->latest('created_at')
            ->take(4)
            ->get();

        $photos = $development->photos()
            ->latest('date')
            ->latest('id')
            ->take(6)
            ->get();

        $concludedStages = $stages->where('status', 'concluido')->count();
        $stageProgress = $stages->count() > 0
            ? (int) round(($concludedStages / $stages->count()) * 100)
            : 0;

        return view('developments.show', compact(
            'development',
            'units',
            'contracts',
            'linkedClients',
            'stages',
            'communications',
            'photos',
            'stageProgress'
        ));
    }

    public function edit(Development $development): View
    {
        return view('developments.edit', compact('development'));
    }

    public function update(Request $request, Development $development)
    {
        $validated = $this->validateDevelopment($request);

        $development->update($this->developmentPayload($validated, $development, $development->builder_id));

        return redirect()
            ->route('developments.index')
            ->with('success', 'Empreendimento atualizado com sucesso.');
    }

    public function destroy(Development $development)
    {
        $development->delete();

        return redirect()
            ->route('developments.index')
            ->with('success', 'Empreendimento removido com sucesso.');
    }

    protected function validateDevelopment(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'location' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:planejamento,lancamento,em_obras,finalizado,entregue,cancelado'],
            'launch_date' => ['nullable', 'date'],
            'expected_delivery' => ['nullable', 'date', 'after_or_equal:launch_date'],
            'notes' => ['nullable', 'string'],
        ]);
    }

    protected function developmentPayload(array $validated, ?Development $development, int $builderId): array
    {
        return [
            ...$validated,
            'builder_id' => $builderId,
            'type' => $development?->type ?? 'apartments',
            'address' => $validated['location'] ?? null,
            'start_date' => $validated['launch_date'] ?? null,
            'expected_delivery_date' => $validated['expected_delivery'] ?? null,
        ];
    }
}
