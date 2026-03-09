<?php

namespace App\Http\Controllers;

use App\Models\Client;

class DashboardController extends Controller
{
    public function index()
    {
        $clientsCount = Client::count();

        $recentClients = Client::latest()->take(5)->get();

        $clientsPerMonth = Client::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('dashboard', [
            'clientsCount' => $clientsCount,
            'recentClients' => $recentClients,
            'clientsPerMonth' => $clientsPerMonth
        ]);
    }
}
