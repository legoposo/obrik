<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Contract;
use App\Models\Development;
use App\Models\FinancialEntry;
use App\Models\Unit;
use App\Models\Work;

class DashboardController extends Controller
{
    public function index()
    {
        $clientsCount = Client::count();
        $developmentsCount = Development::count();
        $unitsCount = Unit::count();
        $availableUnitsCount = Unit::where('status', 'available')->count();
        $soldUnitsCount = Unit::where('status', 'sold')->count();

        $contractsCount = Contract::count();
        $activeContractsCount = Contract::whereIn('status', ['ativo', 'assinado'])->count();
        $completedContractsCount = Contract::where('status', 'concluido')->count();
        $cancelledContractsCount = Contract::where('status', 'cancelado')->count();
        $contractedVolume = (float) Contract::sum('negotiated_value');

        $worksCount = Work::count();

        $financialOpenAmount = (float) FinancialEntry::where('status', 'pending')->sum('amount');
        $financialPaidAmount = (float) FinancialEntry::where('status', 'paid')->sum('amount');
        $financialOverdueCount = FinancialEntry::where('status', 'overdue')->count();

        $recentClients = Client::latest()->take(5)->get();
        $recentContracts = Contract::with(['client', 'development', 'unit'])
            ->latest()
            ->take(5)
            ->get();

        $latestClient = Client::latest()->first();
        $latestContract = Contract::latest()->first();

        return view('dashboard', compact(
            'clientsCount',
            'developmentsCount',
            'unitsCount',
            'availableUnitsCount',
            'soldUnitsCount',
            'contractsCount',
            'activeContractsCount',
            'completedContractsCount',
            'cancelledContractsCount',
            'contractedVolume',
            'worksCount',
            'financialOpenAmount',
            'financialPaidAmount',
            'financialOverdueCount',
            'recentClients',
            'recentContracts',
            'latestClient',
            'latestContract'
        ));
    }
}