<?php

namespace App\Http\Controllers;

use App\Models\Communication;
use App\Models\Development;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CommunicationController extends Controller
{
    public function index(Development $development): View
    {
        $communications = $development->communications()
            ->latest('created_at')
            ->paginate(10);

        return view('developments.communications.index', [
            'development' => $development,
            'communications' => $communications,
            'typeOptions' => $this->typeOptions(),
        ]);
    }

    public function create(Development $development): View
    {
        $communication = new Communication([
            'type' => 'aviso',
        ]);

        return view('developments.communications.create', [
            'development' => $development,
            'communication' => $communication,
            'typeOptions' => $this->typeOptions(),
        ]);
    }

    public function store(Request $request, Development $development): RedirectResponse
    {
        $validated = $this->validateCommunication($request);
        $development->communications()->create([
            ...$validated,
            'created_at' => now(),
        ]);

        return redirect()
            ->route('developments.communications.index', $development)
            ->with('success', 'Comunicado publicado com sucesso.');
    }

    public function edit(Development $development, Communication $communication): View
    {
        $this->ensureBelongsToDevelopment($development, $communication);

        return view('developments.communications.edit', [
            'development' => $development,
            'communication' => $communication,
            'typeOptions' => $this->typeOptions(),
        ]);
    }

    public function update(Request $request, Development $development, Communication $communication): RedirectResponse
    {
        $this->ensureBelongsToDevelopment($development, $communication);
        $communication->update($this->validateCommunication($request));

        return redirect()
            ->route('developments.communications.index', $development)
            ->with('success', 'Comunicado atualizado com sucesso.');
    }

    public function destroy(Development $development, Communication $communication): RedirectResponse
    {
        $this->ensureBelongsToDevelopment($development, $communication);
        $communication->delete();

        return redirect()
            ->route('developments.communications.index', $development)
            ->with('success', 'Comunicado removido com sucesso.');
    }

    protected function validateCommunication(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string'],
            'type' => ['required', 'in:atualizacao_obra,aviso,documento,entrega,manutencao'],
        ]);
    }

    protected function ensureBelongsToDevelopment(Development $development, Communication $communication): void
    {
        abort_unless($communication->development_id === $development->id, 404);
    }

    protected function typeOptions(): array
    {
        return [
            'atualizacao_obra' => 'Atualizacao de obra',
            'aviso' => 'Aviso',
            'documento' => 'Documento',
            'entrega' => 'Entrega',
            'manutencao' => 'Manutencao',
        ];
    }
}
