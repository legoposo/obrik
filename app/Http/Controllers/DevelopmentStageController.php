<?php

namespace App\Http\Controllers;

use App\Models\Development;
use App\Models\DevelopmentStage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class DevelopmentStageController extends Controller
{
    public function index(Development $development): View
    {
        $development->loadCount([
            'stages',
            'stages as completed_stages_count' => fn ($query) => $query->where('status', 'concluido'),
            'stages as in_progress_stages_count' => fn ($query) => $query->where('status', 'em_andamento'),
            'stages as pending_stages_count' => fn ($query) => $query->where('status', 'pendente'),
        ]);

        $stages = $development->stages()
            ->orderByRaw("CASE status WHEN 'em_andamento' THEN 0 WHEN 'pendente' THEN 1 WHEN 'concluido' THEN 2 ELSE 3 END")
            ->orderBy('expected_date')
            ->paginate(10);

        $progress = $this->progress($development);

        return view('developments.stages.index', [
            'development' => $development,
            'stages' => $stages,
            'progress' => $progress,
            'statusOptions' => $this->statusOptions(),
        ]);
    }

    public function create(Development $development): View
    {
        $stage = new DevelopmentStage([
            'status' => 'pendente',
        ]);

        return view('developments.stages.create', [
            'development' => $development,
            'stage' => $stage,
            'statusOptions' => $this->statusOptions(),
            'stageSuggestions' => $this->stageSuggestions(),
        ]);
    }

    public function store(Request $request, Development $development): RedirectResponse
    {
        $validated = $this->validateStage($request);

        $development->stages()->create($validated);

        return redirect()
            ->route('developments.stages.index', $development)
            ->with('success', 'Etapa da obra cadastrada com sucesso.');
    }

    public function edit(Development $development, DevelopmentStage $stage): View
    {
        $this->ensureStageBelongsToDevelopment($development, $stage);

        return view('developments.stages.edit', [
            'development' => $development,
            'stage' => $stage,
            'statusOptions' => $this->statusOptions(),
            'stageSuggestions' => $this->stageSuggestions(),
        ]);
    }

    public function update(Request $request, Development $development, DevelopmentStage $stage): RedirectResponse
    {
        $this->ensureStageBelongsToDevelopment($development, $stage);

        $stage->update($this->validateStage($request));

        return redirect()
            ->route('developments.stages.index', $development)
            ->with('success', 'Etapa da obra atualizada com sucesso.');
    }

    public function destroy(Development $development, DevelopmentStage $stage): RedirectResponse
    {
        $this->ensureStageBelongsToDevelopment($development, $stage);

        $stage->delete();

        return redirect()
            ->route('developments.stages.index', $development)
            ->with('success', 'Etapa da obra removida com sucesso.');
    }

    public function updateStatus(Request $request, Development $development, DevelopmentStage $stage): RedirectResponse
    {
        $this->ensureStageBelongsToDevelopment($development, $stage);

        $validated = $request->validate([
            'status' => ['required', Rule::in(array_keys($this->statusOptions()))],
        ]);

        $payload = ['status' => $validated['status']];

        if ($validated['status'] === 'concluido' && ! $stage->finished_date) {
            $payload['finished_date'] = now()->toDateString();
        }

        if ($validated['status'] !== 'concluido') {
            $payload['finished_date'] = null;
        }

        if ($validated['status'] === 'em_andamento' && ! $stage->start_date) {
            $payload['start_date'] = now()->toDateString();
        }

        $stage->update($payload);

        return redirect()
            ->route('developments.stages.index', $development)
            ->with('success', 'Status da etapa atualizado com sucesso.');
    }

    protected function validateStage(Request $request): array
    {
        return $request->validate([
            'stage_name' => ['required', 'string', 'max:255'],
            'status' => ['required', Rule::in(array_keys($this->statusOptions()))],
            'start_date' => ['nullable', 'date'],
            'expected_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'finished_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'responsible' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ]);
    }

    protected function ensureStageBelongsToDevelopment(Development $development, DevelopmentStage $stage): void
    {
        abort_unless($stage->development_id === $development->id, 404);
    }

    protected function statusOptions(): array
    {
        return [
            'pendente' => 'Pendente',
            'em_andamento' => 'Em andamento',
            'concluido' => 'Concluido',
        ];
    }

    protected function stageSuggestions(): array
    {
        return [
            'Terraplanagem',
            'Fundacao',
            'Estrutura',
            'Alvenaria',
            'Instalacoes',
            'Acabamento',
            'Entrega',
        ];
    }

    protected function progress(Development $development): array
    {
        $total = (int) $development->stages_count;
        $completed = (int) $development->completed_stages_count;
        $inProgress = (int) $development->in_progress_stages_count;
        $pending = (int) $development->pending_stages_count;
        $percentage = $total > 0 ? (int) round(($completed / $total) * 100) : 0;

        return [
            'total' => $total,
            'completed' => $completed,
            'in_progress' => $inProgress,
            'pending' => $pending,
            'percentage' => $percentage,
        ];
    }
}