<?php

namespace App\Http\Controllers;

use App\Models\Builder;
use App\Models\Work;
use Illuminate\Http\Request;

class WorksReportController extends Controller
{
    public function index(Request $request)
    {
        $filters = [
            'status' => trim((string) $request->string('status')),
            'period_from' => trim((string) $request->string('period_from')),
            'period_to' => trim((string) $request->string('period_to')),
            'responsible' => trim((string) $request->string('responsible')),
        ];

        $query = Work::query()
            ->with(['client.builder'])
            ->when($filters['status'] !== '', function ($query) use ($filters) {
                $query->where('status', $filters['status']);
            })
            ->when($filters['period_from'] !== '', function ($query) use ($filters) {
                $query->whereDate('start_date', '>=', $filters['period_from']);
            })
            ->when($filters['period_to'] !== '', function ($query) use ($filters) {
                $query->whereDate('start_date', '<=', $filters['period_to']);
            })
            ->when($filters['responsible'] !== '', function ($query) use ($filters) {
                $term = '%'.$filters['responsible'].'%';

                $query->where(function ($innerQuery) use ($term) {
                    $innerQuery
                        ->whereHas('client', function ($clientQuery) use ($term) {
                            $clientQuery->where('name', 'like', $term);
                        })
                        ->orWhereHas('client.builder', function ($builderQuery) use ($term) {
                            $builderQuery
                                ->where('name', 'like', $term)
                                ->orWhere('responsible', 'like', $term);
                        });
                });
            });

        $totals = [
            'works' => (clone $query)->count(),
            'budget' => (float) (clone $query)->sum('budget'),
        ];

        $works = $query
            ->orderByDesc('start_date')
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        $responsibles = Builder::query()
            ->whereNotNull('responsible')
            ->where('responsible', '!=', '')
            ->orderBy('responsible')
            ->distinct()
            ->pluck('responsible');

        $statusOptions = [
            'planning' => 'Planejamento',
            'in_progress' => 'Em andamento',
            'paused' => 'Pausada',
            'finished' => 'Concluida',
            'completed' => 'Concluida',
            'canceled' => 'Cancelada',
        ];

        return view('reports.works', compact('works', 'filters', 'totals', 'responsibles', 'statusOptions'));
    }
}
