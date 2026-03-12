<?php

use App\Models\Builder;
use App\Models\Communication;
use App\Models\Development;
use App\Models\DevelopmentPhoto;
use App\Models\DevelopmentStage;
use App\Models\User;

function createDevelopmentForNavigationHubTests(): Development
{
    $builder = Builder::create([
        'name' => 'Incorporadora Navegacao',
        'city' => 'Sao Paulo',
        'state' => 'SP',
    ]);

    return Development::create([
        'builder_id' => $builder->id,
        'name' => 'Parque das Aguas',
        'type' => 'apartments',
        'city' => 'Sao Paulo',
        'state' => 'SP',
        'address' => 'Rua Central, 100',
        'location' => 'Sao Paulo - Centro',
        'status' => 'em_obras',
    ]);
}

test('authenticated users can access the new navigation hubs', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $development = createDevelopmentForNavigationHubTests();

    DevelopmentStage::create([
        'development_id' => $development->id,
        'stage_name' => 'Estrutura',
        'status' => 'em_andamento',
    ]);

    Communication::create([
        'development_id' => $development->id,
        'title' => 'Aviso importante',
        'message' => 'Atualizacao da obra enviada aos clientes.',
        'type' => 'aviso',
        'created_at' => now(),
    ]);

    DevelopmentPhoto::create([
        'development_id' => $development->id,
        'title' => 'Foto do canteiro',
        'description' => 'Registro visual da etapa atual.',
        'date' => now()->toDateString(),
        'image_path' => 'development-photos/exemplo.jpg',
    ]);

    $this->get(route('construction.stages'))
        ->assertOk()
        ->assertSee('Andamento da Obra')
        ->assertSee($development->name);

    $this->get(route('construction.communications'))
        ->assertOk()
        ->assertSee('Comunicados')
        ->assertSee('Aviso importante');

    $this->get(route('construction.photos'))
        ->assertOk()
        ->assertSee('Fotos da Obra')
        ->assertSee('Foto do canteiro');

    $this->get(route('client-portal.index'))
        ->assertOk()
        ->assertSee('Portal do Cliente')
        ->assertSee('Modulo em evolucao');
});