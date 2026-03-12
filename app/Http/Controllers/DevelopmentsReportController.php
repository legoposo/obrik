<?php

namespace App\Http\Controllers;

use App\Models\Builder;
use App\Models\Development;
use Illuminate\Http\Request;

class DevelopmentsReportController extends Controller
{
    public function index(Request $request)
    {
        $filters = [
            'status' => trim((string) $request->string('status')),
            'builder_id' => trim((string) $request->string('builder_id')),
            'search' => trim((string) $request->string('search')),
        ];

        $query = Development::query()
            ->with('builder')
            ->withCount('units')
            ->withCount([
                'units as available_units_count' => function ($query) {
                    $query->where('status', 'available');
                },
            ])
            ->when($filters['status'] !== '', function ($query) use ($filters) {
                $query->where('status', $filters['status']);
            })
            ->when($filters['builder_id'] !== '', function ($query) use ($filters) {
                $query->where('builder_id', $filters['builder_id']);
            })
            ->when($filters['search'] !== '', function ($query) use ($filters) {
                $term = '%'.$filters['search'].'%';

                $query->where(function ($innerQuery) use ($term) {
                    $innerQuery
                        ->where('name', 'like', $term)
                        ->orWhere('city', 'like', $term)
                        ->orWhereHas('builder', function ($builderQuery) use ($term) {
                            $builderQuery->where('name', 'like', $term);
                        });
                });
            });

        $summary = (clone $query)->get();

        $totals = [
            'developments' => $summary->count(),
            'units' => $summary->sum('units_count'),
            'available_units' => $summary->sum('available_units_count'),
        ];

        $developments = $query
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        $builders = Builder::query()
            ->orderBy('name')
            ->get(['id', 'name']);

        $statusOptions = [
            'planning' => 'Planejamento',
            'in_progress' => 'Em andamento',
            'paused' => 'Pausado',
            'completed' => 'Concluido',
            'canceled' => 'Cancelado',
        ];

        return view('reports.developments', compact('developments', 'filters', 'totals', 'builders', 'statusOptions'));
    }
}
