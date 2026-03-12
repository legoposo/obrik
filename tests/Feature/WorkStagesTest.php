<?php

use App\Models\Client;
use App\Models\User;
use App\Models\Work;
use App\Models\WorkStage;

test('guests are redirected when trying to access the work schedule', function () {
    $client = Client::create([
        'name' => 'Cliente Visitante',
    ]);

    $work = Work::create([
        'client_id' => $client->id,
        'name' => 'Obra Visitante',
        'status' => 'planning',
    ]);

    $this->get(route('works.stages.index', $work))
        ->assertRedirect(route('login'));
});

test('authenticated users can create edit and delete work stages', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $client = Client::create([
        'name' => 'Cliente Obra',
    ]);

    $work = Work::create([
        'client_id' => $client->id,
        'name' => 'Residencial Aurora',
        'status' => 'in_progress',
        'start_date' => '2026-03-01',
        'expected_end_date' => '2026-12-20',
    ]);

    $this->post(route('works.stages.store', $work), [
        'name' => 'Fundacao',
        'status' => 'pending',
        'start_date' => '2026-03-05',
        'expected_date' => '2026-03-20',
        'responsible' => 'Carlos Lima',
        'notes' => 'Aguardando liberacao do terreno.',
    ])->assertRedirect(route('works.stages.index', $work));

    $stage = WorkStage::first();

    expect($stage)->not->toBeNull();

    $this->get(route('works.stages.index', $work))
        ->assertOk()
        ->assertSee('Fundacao')
        ->assertSee('0% da obra concluida');

    $this->put(route('works.stages.update', [$work, $stage]), [
        'name' => 'Fundacao profunda',
        'status' => 'in_progress',
        'start_date' => '2026-03-06',
        'expected_date' => '2026-03-22',
        'finished_date' => null,
        'responsible' => 'Carlos Lima',
        'notes' => 'Execucao iniciada.',
    ])->assertRedirect(route('works.stages.index', $work));

    expect($stage->fresh()->name)->toBe('Fundacao profunda');
    expect($stage->fresh()->status)->toBe('in_progress');

    $this->delete(route('works.stages.destroy', [$work, $stage]))
        ->assertRedirect(route('works.stages.index', $work));

    $this->assertDatabaseMissing('work_stages', [
        'id' => $stage->id,
    ]);
});

test('updating a stage status updates the work progress and completion date', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $client = Client::create([
        'name' => 'Cliente Cronograma',
    ]);

    $work = Work::create([
        'client_id' => $client->id,
        'name' => 'Condominio Horizonte',
        'status' => 'in_progress',
    ]);

    WorkStage::create([
        'work_id' => $work->id,
        'name' => 'Terraplanagem',
        'status' => 'completed',
        'finished_date' => '2026-03-01',
    ]);

    $stage = WorkStage::create([
        'work_id' => $work->id,
        'name' => 'Estrutura',
        'status' => 'pending',
    ]);

    $this->get(route('works.stages.index', $work))
        ->assertOk()
        ->assertSee('50% da obra concluida');

    $this->patch(route('works.stages.status', [$work, $stage]), [
        'status' => 'completed',
    ])->assertRedirect(route('works.stages.index', $work));

    $stage->refresh();

    expect($stage->status)->toBe('completed');
    expect($stage->finished_date)->not->toBeNull();

    $this->get(route('works.stages.index', $work))
        ->assertOk()
        ->assertSee('100% da obra concluida');
});
