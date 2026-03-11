<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContractRequest;
use App\Http\Requests\UpdateContractRequest;
use App\Models\Client;
use App\Models\Contract;
use App\Models\Development;
use App\Models\Unit;
use Barryvdh\DomPDF\Facade\Pdf;

class ContractController extends Controller
{
    public function index()
    {
        $contracts = Contract::with(['client', 'unit.development', 'development'])
            ->latest()
            ->paginate(10);

        return view('contracts.index', compact('contracts'));
    }

    public function create()
    {
        $contract = new Contract([
            'status' => 'ativo',
            'sale_date' => now()->format('Y-m-d'),
            'contract_date' => now()->format('Y-m-d'),
            'discount' => 0,
            'down_payment' => 0,
            'financed_amount' => 0,
            'installments_count' => 0,
        ]);

        return view('contracts.create', $this->formData($contract));
    }

    public function store(StoreContractRequest $request)
    {
        $contract = Contract::create($request->validated());

        $this->prepareFutureInstallments($contract);
        $this->prepareFutureUnitStatusSync($contract);

        return redirect()
            ->route('contracts.index')
            ->with('success', 'Contrato cadastrado com sucesso.');
    }

    public function edit(Contract $contract)
    {
        $contract->load(['development', 'unit', 'client']);

        return view('contracts.edit', $this->formData($contract));
    }

    public function update(UpdateContractRequest $request, Contract $contract)
    {
        $contract->update($request->validated());

        $this->prepareFutureInstallments($contract);
        $this->prepareFutureUnitStatusSync($contract);

        return redirect()
            ->route('contracts.index')
            ->with('success', 'Contrato atualizado com sucesso.');
    }

    public function destroy(Contract $contract)
    {
        $contract->delete();

        return redirect()
            ->route('contracts.index')
            ->with('success', 'Contrato removido com sucesso.');
    }

    public function print(Contract $contract)
    {
        $contract->load(['client', 'development', 'unit']);

        $pdf = Pdf::loadView('contracts.pdf', compact('contract'))
            ->setPaper('a4', 'portrait')
            ->setOption(['isRemoteEnabled' => false]);

        return $pdf->stream('contrato-'.$contract->contract_number.'.pdf');
    }

    protected function formData(Contract $contract): array
    {
        $developments = Development::orderBy('name')->get(['id', 'name']);
        $clients = Client::orderBy('name')->get(['id', 'name']);

        $units = Unit::with('development:id,name')
            ->where(function ($query) use ($contract) {
                $query->whereDoesntHave('contracts', function ($contractQuery) use ($contract) {
                    $contractQuery->whereIn('status', ['ativo', 'assinado', 'concluido']);

                    if ($contract->exists) {
                        $contractQuery->where('id', '!=', $contract->id);
                    }
                });

                if ($contract->unit_id) {
                    $query->orWhere('id', $contract->unit_id);
                }
            })
            ->orderBy('identifier')
            ->get([
                'id',
                'development_id',
                'identifier',
                'block',
                'floor',
                'status',
                'price',
            ]);

        return compact('contract', 'developments', 'clients', 'units');
    }

    protected function prepareFutureInstallments(Contract $contract): void
    {
        // Ponto central para futura geracao de parcelas e recebimentos a partir do contrato.
    }

    protected function prepareFutureUnitStatusSync(Contract $contract): void
    {
        // Ponto central para futura sincronizacao automatica do status da unidade.
    }
}