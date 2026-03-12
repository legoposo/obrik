<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Development;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClientController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->string('search'));
        $status = trim((string) $request->string('status'));
        $developmentId = $request->integer('development_id') ?: null;

        $clients = Client::query()
            ->withCount('contracts')
            ->with(['developments' => fn ($query) => $query->select('developments.id', 'name')->orderBy('name')])
            ->when($developmentId, function ($query) use ($developmentId) {
                $query->whereHas('contracts', fn ($contractQuery) => $contractQuery->where('development_id', $developmentId));
            })
            ->when($status !== '', fn ($query) => $query->where('status', $status))
            ->when($search !== '', function ($query) use ($search) {
                $like = '%'.$search.'%';

                $query->where(function ($innerQuery) use ($like) {
                    $innerQuery
                        ->where('name', 'like', $like)
                        ->orWhere('email', 'like', $like)
                        ->orWhere('phone', 'like', $like)
                        ->orWhere('document', 'like', $like)
                        ->orWhere('cpf', 'like', $like)
                        ->orWhere('address', 'like', $like)
                        ->orWhere('notes', 'like', $like);
                });
            })
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        $developments = Development::query()
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('clients.index', compact('clients', 'developments', 'search', 'status', 'developmentId'));
    }

    public function create(): View
    {
        $client = new Client([
            'status' => 'lead',
        ]);

        return view('clients.create', compact('client'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateClient($request);

        Client::create($this->payload($validated, null));

        return redirect()
            ->route('clients.index')
            ->with('success', 'Cliente cadastrado com sucesso.');
    }

    public function edit(Client $client): View
    {
        return view('clients.edit', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $validated = $this->validateClient($request);

        $client->update($this->payload($validated, $client));

        return redirect()
            ->route('clients.index')
            ->with('success', 'Cliente atualizado com sucesso.');
    }

    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()
            ->route('clients.index')
            ->with('success', 'Cliente removido com sucesso.');
    }

    protected function validateClient(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:255'],
            'document' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
            'status' => ['required', 'in:lead,interessado,comprador,pos_venda'],
        ]);
    }

    protected function payload(array $validated, ?Client $client): array
    {
        return [
            ...$validated,
            'cpf' => $validated['document'] ?? $client?->cpf,
        ];
    }
}