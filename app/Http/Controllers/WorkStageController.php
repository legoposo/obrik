<?php

namespace App\Http\Controllers;

use App\Models\Work;
use App\Models\WorkStage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class WorkStageController extends Controller
{
    public function index(Work $work): View
    {
        $work->load('client')->loadCount([
            'stages',
            'stages as completed_stages_count' => fn ($query) => $query->where('status', 'completed'),
            'stages as in_progress_stages_count' => fn ($query) => $query->where('status', 'in_progress'),
            'stages as pending_stages_count' => fn ($query) => $query->where('status', 'pending'),
        ]);

        $stages = $work->stages()
            ->orderByRaw("CASE status WHEN 'in_progress' THEN 0 WHEN 'pending' THEN 1 WHEN 'completed' THEN 2 ELSE 3 END")
            ->orderByRaw('CASE WHEN expected_date IS NULL THEN 1 ELSE 0 END')
            ->orderBy('expected_date')
            ->orderBy('id')
            ->paginate(10);

        $progress = $this->buildProgressData($work);

        return view('works.stages.index', [
            'work' => $work,
            'stages' => $stages,
            'progress' => $progress,
            'statusOptions' => $this->statusOptions(),
        ]);
    }

    public function create(Work $work): View
    {
        $work->load('client');

        return view('works.stages.create', [
            'work' => $work,
            'statusOptions' => $this->statusOptions(),
            'stageSuggestions' => $this->stageSuggestions(),
        ]);
    }

    public function store(Request $request, Work $work): RedirectResponse
    {
        $validated = $this->validateStage($request);

        $work->stages()->create($validated);

        return redirect()
            ->route('works.stages.index', $work)
            ->with('success', 'Etapa cadastrada com sucesso.');
    }

    public function edit(Work $work, WorkStage $stage): View
    {
        $this->ensureStageBelongsToWork($work, $stage);
        $work->load('client');

        return view('works.stages.edit', [
            'work' => $work,
            'stage' => $stage,
            'statusOptions' => $this->statusOptions(),
            'stageSuggestions' => $this->stageSuggestions(),
        ]);
    }

    public function update(Request $request, Work $work, WorkStage $stage): RedirectResponse
    {
        $this->ensureStageBelongsToWork($work, $stage);

        $validated = $this->validateStage($request);

        $stage->update($validated);

        return redirect()
            ->route('works.stages.index', $work)
            ->with('success', 'Etapa atualizada com sucesso.');
    }

    public function destroy(Work $work, WorkStage $stage): RedirectResponse
    {
        $this->ensureStageBelongsToWork($work, $stage);

        $stage->delete();

        return redirect()
            ->route('works.stages.index', $work)
            ->with('success', 'Etapa removida com sucesso.');
    }

    public function updateStatus(Request $request, Work $work, WorkStage $stage): RedirectResponse
    {
        $this->ensureStageBelongsToWork($work, $stage);

        $validated = $request->validate([
            'status' => ['required', Rule::in(array_keys($this->statusOptions()))],
        ]);

        $payload = [
            'status' => $validated['status'],
        ];

        if ($validated['status'] === 'completed' && ! $stage->finished_date) {
            $payload['finished_date'] = now()->toDateString();
        }

        if ($validated['status'] !== 'completed') {
            $payload['finished_date'] = null;
        }

        if ($validated['status'] === 'in_progress' && ! $stage->start_date) {
            $payload['start_date'] = now()->toDateString();
        }

        $stage->update($payload);

        return redirect()
            ->route('works.stages.index', $work)
            ->with('success', 'Status da etapa atualizado com sucesso.');
    }

    protected function validateStage(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'status' => ['required', Rule::in(array_keys($this->statusOptions()))],
            'start_date' => ['nullable', 'date'],
            'expected_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'finished_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'responsible' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ]);
    }

    protected function ensureStageBelongsToWork(Work $work, WorkStage $stage): void
    {
        abort_unless($stage->work_id === $work->id, 404);
    }

    protected function statusOptions(): array
    {
        return [
            'pending' => 'Pendente',
            'in_progress' => 'Em andamento',
            'completed' => 'Concluido',
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

    protected function buildProgressData(Work $work): array
    {
        $total = (int) $work->stages_count;
        $completed = (int) $work->completed_stages_count;
        $inProgress = (int) $work->in_progress_stages_count;
        $pending = (int) $work->pending_stages_count;
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
