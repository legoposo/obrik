<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContractRequest;
use App\Http\Requests\UpdateContractRequest;
use App\Models\Client;
use App\Models\Contract;
use App\Models\Development;
use App\Models\Unit;
use App\Support\ContractPrintData;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContractController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->string('search'));
        $status = trim((string) $request->string('status'));
        $developmentId = $request->integer('development_id') ?: null;

        $contracts = Contract::query()
            ->with(['client', 'unit.development', 'development'])
            ->when($developmentId, fn ($query) => $query->where('development_id', $developmentId))
            ->when($status !== '', fn ($query) => $query->where('status', $status))
            ->when($search !== '', function ($query) use ($search) {
                $like = '%'.$search.'%';

                $query->where(function ($innerQuery) use ($like) {
                    $innerQuery
                        ->where('contract_number', 'like', $like)
                        ->orWhere('notes', 'like', $like)
                        ->orWhereHas('client', fn ($clientQuery) => $clientQuery->where('name', 'like', $like))
                        ->orWhereHas('development', fn ($developmentQuery) => $developmentQuery->where('name', 'like', $like))
                        ->orWhereHas('unit', function ($unitQuery) use ($like) {
                            $unitQuery
                                ->where('unit_number', 'like', $like)
                                ->orWhere('identifier', 'like', $like)
                                ->orWhere('block_or_tower', 'like', $like);
                        });
                });
            })
            ->latest('contract_date')
            ->paginate(10)
            ->withQueryString();

        $developments = Development::query()
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('contracts.index', [
            'contracts' => $contracts,
            'developments' => $developments,
            'search' => $search,
            'status' => $status,
            'developmentId' => $developmentId,
            'statusOptions' => $this->statusOptions(),
        ]);
    }

    public function create(): View
    {
        $contract = new Contract([
            'status' => 'reserva',
            'contract_date' => now()->format('Y-m-d'),
        ]);

        return view('contracts.create', $this->formData($contract));
    }

    public function store(StoreContractRequest $request)
    {
        $contract = Contract::create($this->contractPayload($request->validated()));

        $this->syncUnitStatus($contract);
        $this->prepareFutureInstallments($contract);

        return redirect()
            ->route('contracts.index', ['development_id' => $contract->development_id])
            ->with('success', 'Reserva/contrato cadastrado com sucesso.');
    }

    public function edit(Contract $contract): View
    {
        $contract->load(['development', 'unit', 'client']);

        return view('contracts.edit', $this->formData($contract));
    }

    public function update(UpdateContractRequest $request, Contract $contract)
    {
        $contract->update($this->contractPayload($request->validated(), $contract));

        $this->syncUnitStatus($contract);
        $this->prepareFutureInstallments($contract);

        return redirect()
            ->route('contracts.index', ['development_id' => $contract->development_id])
            ->with('success', 'Reserva/contrato atualizado com sucesso.');
    }

    public function destroy(Contract $contract)
    {
        $developmentId = $contract->development_id;
        $unit = $contract->unit;
        $contract->delete();

        if ($unit) {
            $hasOpenContract = Contract::query()
                ->where('unit_id', $unit->id)
                ->whereIn('status', ['reserva', 'proposta', 'contrato_assinado', 'concluido'])
                ->exists();

            if (! $hasOpenContract) {
                $unit->update(['status' => 'disponivel']);
            }
        }

        return redirect()
            ->route('contracts.index', ['development_id' => $developmentId])
            ->with('success', 'Reserva/contrato removido com sucesso.');
    }

    public function print(Contract $contract)
    {
        $contract->load(['client', 'development.builder', 'unit']);
        $document = ContractPrintData::from($contract);

        $pdf = Pdf::loadView('contracts.pdf', compact('contract', 'document'))
            ->setPaper('a4', 'portrait')
            ->setOption(['isRemoteEnabled' => false]);

        return $pdf->stream('contrato-'.$contract->contract_number.'.pdf');
    }

    protected function formData(Contract $contract): array
    {
        $requestedDevelopmentId = request()->integer('development_id');

        if (! $contract->exists && $requestedDevelopmentId) {
            $contract->development_id = $requestedDevelopmentId;
        }

        $developments = Development::orderBy('name')->get(['id', 'name']);
        $clients = Client::orderBy('name')->get(['id', 'name']);

        $units = Unit::with('development:id,name')
            ->when($contract->development_id, fn ($query) => $query->where('development_id', $contract->development_id))
            ->where(function ($query) use ($contract) {
                $query->whereDoesntHave('contracts', function ($contractQuery) use ($contract) {
                    $contractQuery->whereIn('status', ['reserva', 'proposta', 'contrato_assinado', 'concluido']);

                    if ($contract->exists) {
                        $contractQuery->where('id', '!=', $contract->id);
                    }
                });

                if ($contract->unit_id) {
                    $query->orWhere('id', $contract->unit_id);
                }
            })
            ->orderBy('development_id')
            ->orderBy('block_or_tower')
            ->orderBy('unit_number')
            ->get([
                'id',
                'development_id',
                'identifier',
                'unit_number',
                'block_or_tower',
                'type',
                'status',
                'price',
            ]);

        return [
            'contract' => $contract,
            'developments' => $developments,
            'clients' => $clients,
            'units' => $units,
            'statusOptions' => $this->statusOptions(),
        ];
    }

    protected function contractPayload(array $validated, ?Contract $contract = null): array
    {
        $value = (float) $validated['value'];

        return [
            'development_id' => $validated['development_id'],
            'unit_id' => $validated['unit_id'],
            'client_id' => $validated['client_id'],
            'contract_number' => $contract?->contract_number ?? $this->generateContractNumber(),
            'sale_date' => $validated['contract_date'],
            'contract_date' => $validated['contract_date'],
            'value' => $value,
            'unit_price' => $value,
            'discount' => 0,
            'negotiated_value' => $value,
            'down_payment' => 0,
            'financed_amount' => 0,
            'installments_count' => 0,
            'status' => $validated['status'],
            'notes' => $validated['notes'] ?? null,
        ];
    }

    protected function syncUnitStatus(Contract $contract): void
    {
        $contract->loadMissing('unit');

        if (! $contract->unit) {
            return;
        }

        $statusMap = [
            'reserva' => 'reservada',
            'proposta' => 'reservada',
            'contrato_assinado' => 'vendida',
            'concluido' => 'vendida',
        ];

        if ($contract->status === 'cancelado') {
            $hasOtherOpenContract = Contract::query()
                ->where('unit_id', $contract->unit_id)
                ->where('id', '!=', $contract->id)
                ->whereIn('status', ['reserva', 'proposta', 'contrato_assinado', 'concluido'])
                ->exists();

            if (! $hasOtherOpenContract) {
                $contract->unit->update(['status' => 'disponivel']);
            }

            return;
        }

        if (isset($statusMap[$contract->status])) {
            $contract->unit->update(['status' => $statusMap[$contract->status]]);
        }
    }

    protected function prepareFutureInstallments(Contract $contract): void
    {
        // Ponto central para futura geracao de parcelas e recebimentos a partir do contrato.
    }

    protected function generateContractNumber(): string
    {
        return 'OBR-'.now()->format('YmdHis');
    }

    protected function statusOptions(): array
    {
        return [
            'reserva' => 'Reserva',
            'proposta' => 'Proposta',
            'contrato_assinado' => 'Contrato assinado',
            'cancelado' => 'Cancelado',
            'concluido' => 'Concluido',
        ];
    }
}