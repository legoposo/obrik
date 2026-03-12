<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Development;
use App\Models\FinancialEntry;
use App\Models\Work;

class ReportController extends Controller
{
    public function index()
    {
        $cards = [
            [
                'title' => 'Relatorio de Obras',
                'description' => 'Acompanhe status, prazos, responsaveis e orcamento das obras em um unico lugar.',
                'route' => route('reports.works'),
                'metric' => Work::count(),
                'metric_label' => 'obras cadastradas',
                'accent' => 'blue',
            ],
            [
                'title' => 'Relatorio Financeiro',
                'description' => 'Consulte receitas, despesas, saldo e filtros por obra e periodo.',
                'route' => route('reports.financial'),
                'metric' => FinancialEntry::count(),
                'metric_label' => 'lancamentos registrados',
                'accent' => 'emerald',
            ],
            [
                'title' => 'Relatorio de Clientes',
                'description' => 'Veja contatos, situacao comercial e empreendimentos ligados a cada cliente.',
                'route' => route('reports.clients'),
                'metric' => Client::count(),
                'metric_label' => 'clientes cadastrados',
                'accent' => 'amber',
            ],
            [
                'title' => 'Relatorio de Empreendimentos',
                'description' => 'Monitore status, quantidade de unidades e disponibilidade por empreendimento.',
                'route' => route('reports.developments'),
                'metric' => Development::count(),
                'metric_label' => 'empreendimentos cadastrados',
                'accent' => 'violet',
            ],
        ];

        return view('reports.index', compact('cards'));
    }
}
