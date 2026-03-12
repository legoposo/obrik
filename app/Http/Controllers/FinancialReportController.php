<?php

namespace App\Http\Controllers;

use App\Models\FinancialEntry;
use App\Models\Work;
use Illuminate\Http\Request;

class FinancialReportController extends Controller
{
    public function index(Request $request)
    {
        $filters = [
            'type' => trim((string) $request->string('type')),
            'status' => trim((string) $request->string('status')),
            'work_id' => trim((string) $request->string('work_id')),
            'period_from' => trim((string) $request->string('period_from')),
            'period_to' => trim((string) $request->string('period_to')),
        ];

        $query = FinancialEntry::query()
            ->with('work')
            ->when($filters['type'] !== '', function ($query) use ($filters) {
                $query->where('type', $filters['type']);
            })
            ->when($filters['status'] !== '', function ($query) use ($filters) {
                $query->where('status', $filters['status']);
            })
            ->when($filters['work_id'] !== '', function ($query) use ($filters) {
                $query->where('work_id', $filters['work_id']);
            })
            ->when($filters['period_from'] !== '', function ($query) use ($filters) {
                $query->whereDate('due_date', '>=', $filters['period_from']);
            })
            ->when($filters['period_to'] !== '', function ($query) use ($filters) {
                $query->whereDate('due_date', '<=', $filters['period_to']);
            });

        $totals = [
            'income' => (float) (clone $query)->where('type', 'income')->sum('amount'),
            'expense' => (float) (clone $query)->where('type', 'expense')->sum('amount'),
        ];
        $totals['balance'] = $totals['income'] - $totals['expense'];

        $entries = $query
            ->orderByDesc('due_date')
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        $works = Work::query()
            ->orderBy('name')
            ->get(['id', 'name']);

        $typeOptions = [
            'income' => 'Receita',
            'expense' => 'Despesa',
        ];

        $statusOptions = [
            'pending' => 'Pendente',
            'paid' => 'Pago',
            'overdue' => 'Atrasado',
        ];

        return view('reports.financial', compact('entries', 'filters', 'totals', 'works', 'typeOptions', 'statusOptions'));
    }
}
