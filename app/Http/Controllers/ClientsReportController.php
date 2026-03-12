<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Development;
use Illuminate\Http\Request;

class ClientsReportController extends Controller
{
    public function index(Request $request)
    {
        $filters = [
            'status' => trim((string) $request->string('status')),
            'development_id' => trim((string) $request->string('development_id')),
            'search' => trim((string) $request->string('search')),
        ];

        $query = Client::query()
            ->with([
                'contracts' => function ($query) {
                    $query->with('development')->latest('contract_date');
                },
            ])
            ->withCount('contracts')
            ->when($filters['status'] === 'client', function ($query) {
                $query->has('contracts');
            })
            ->when($filters['status'] === 'lead', function ($query) {
                $query->doesntHave('contracts');
            })
            ->when($filters['development_id'] !== '', function ($query) use ($filters) {
                $query->whereHas('contracts', function ($contractQuery) use ($filters) {
                    $contractQuery->where('development_id', $filters['development_id']);
                });
            })
            ->when($filters['search'] !== '', function ($query) use ($filters) {
                $term = '%'.$filters['search'].'%';

                $query->where(function ($innerQuery) use ($term) {
                    $innerQuery
                        ->where('name', 'like', $term)
                        ->orWhere('email', 'like', $term)
                        ->orWhere('phone', 'like', $term);
                });
            });

        $totals = [
            'total' => (clone $query)->count(),
            'clients' => (clone $query)->has('contracts')->count(),
            'leads' => (clone $query)->doesntHave('contracts')->count(),
        ];

        $clients = $query
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        $developments = Development::query()
            ->orderBy('name')
            ->get(['id', 'name']);

        $statusOptions = [
            'lead' => 'Lead',
            'client' => 'Cliente',
        ];

        return view('reports.clients', compact('clients', 'filters', 'totals', 'developments', 'statusOptions'));
    }
}
