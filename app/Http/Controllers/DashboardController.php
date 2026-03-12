<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Development;
use App\Models\Unit;
use App\Models\Client;

class DashboardController extends Controller
{
    public function index()
    {
        $developmentsCount = Development::count();
        $availableUnitsCount = Unit::where('status', 'disponivel')->count();
        $reservedUnitsCount = Unit::where('status', 'reservada')->count();
        $soldUnitsCount = Unit::where('status', 'vendida')->count();
        $clientsCount = Client::count();
        $activeContractsCount = Contract::whereIn('status', ['reserva', 'proposta', 'contrato_assinado'])->count();

        $recentDevelopments = Development::latest()->take(4)->get();
        $recentContracts = Contract::with(['development', 'unit', 'client'])
            ->latest('contract_date')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'developmentsCount',
            'availableUnitsCount',
            'reservedUnitsCount',
            'soldUnitsCount',
            'clientsCount',
            'activeContractsCount',
            'recentDevelopments',
            'recentContracts'
        ));
    }
}
