<?php

use App\Livewire\Panel\Announcement\{All, Create, Delete, Update};
use App\Models\Announcement;
use App\Models\User;
use Livewire\Livewire;

it('Check if route exists and user is logged in', function () {

    $this->actingAs(User::factory()->create());

    $this->get('/panel/dashboard')
        ->assertOk();
});
it('Check component list all announcement exist in the page', function () {

    $this->actingAs(User::factory()->create())
        ->get('/panel/dashboard')
        ->assertOK()
        ->assertSeeLivewire(All::class);
});
// Create
it('check component create announcement exist in the page', function () {

    $this->actingAs(User::factory()->create())
        ->get('/panel/dashboard')
        ->assertOK()
        ->assertSeeLivewire(Create::class);
});
it('check if open modal in click the component', function () {

    $this->actingAs(User::factory()->create())
        ->get('/panel/dashboard')
        ->assertOK()
        ->assertSeeLivewire(Create::class);

    Livewire::test(Create::class)
        ->toggle('modal', true)
        ->assertSeeText('Cadastrar Anuncio');
});
todo('check is message error in create announcement empty', function () {

    $this->actingAs(User::factory()->create())
        ->get('/panel/dashboard')
        ->assertOK();

    Livewire::test(Create::class)
        ->set('name', 'asf')
        ->call('store')
        ->assertHasErrors();
});
todo('check announcement is register and dispatch event for component list all categories', function () {

    $this->actingAs(User::factory()->create())
        ->get('/panel/dashboard')
        ->assertOK();

    Livewire::test(Create::class)
        ->toggle('modal', true)
        ->set('name', 'announcement Test')
        ->call('store')
        ->assertDispatched('announcement:created')
        ->toggle('modal', false);

    $this->assertDatabaseHas('categories', [
        'name' => 'announcement Test'
    ]);
});
todo('check display categories', function () {

    $this->actingAs(User::factory()->create())
        ->get('/panel/dashboard')
        ->assertOK();

    Announcement::create(['name' => 'announcement One']);
    Announcement::create(['name' => 'announcement Two']);

    $this->assertDatabaseCount('categories', 2);

    Livewire::test(All::class)
        ->assertSee('announcement One')
        ->assertSee('announcement Two');
});
// Update
todo('Check component update exist in the page', function () {

    $this->actingAs(User::factory()->create())
        ->get('/panel/dashboard')
        ->assertOK();

    Announcement::create(['name' => 'announcement One']);
    Announcement::create(['name' => 'announcement Two']);

    Livewire::test(All::class)
        ->assertSee('announcement One')
        ->assertSee('announcement Two')
        ->assertSeeLivewire(Update::class);
});
todo('check if open modal in click button for update announcement', function () {

    $this->actingAs(User::factory()->create())
        ->get('/panel/dashboard')
        ->assertOK();

    $announcement = Announcement::create(['name' => 'announcement One']);

    Livewire::test(All::class)
        ->assertSee('announcement One')
        ->assertSeeLivewire(Update::class);

    Livewire::test(Update::class, ['announcement' => $announcement])
        ->toggle('modal', true)
        ->assertSeeText('Editar Categoria');
});
todo('check is message error in update announcement', function () {

    $this->actingAs(User::factory()->create())
        ->get('/panel/dashboard')
        ->assertOK();

    $announcement = Announcement::create(['name' => 'announcement One']);

    Livewire::test(All::class)
        ->assertSee('announcement One')
        ->assertSeeLivewire(Update::class);

    Livewire::test(Update::class, ['announcement' => $announcement])
        ->set('name', '')
        ->call('update')
        ->assertHasErrors();
});
todo('check is message success in update announcement', function () {

    $this->actingAs(User::factory()->create())
        ->get('/panel/dashboard')
        ->assertOK();

    $announcement = Announcement::create(['name' => 'announcement One']);

    Livewire::test(All::class)
        ->assertSee('announcement One')
        ->assertSeeLivewire(Update::class);

    Livewire::test(Update::class, ['announcement' => $announcement])
        ->toggle('modal', true)
        ->set('name', 'announcement Two')
        ->call('update')
        ->toggle('modal', false);

    $this->assertDatabaseHas('categories', [
        'name' => 'announcement Two'
    ]);
});
// Delete
todo('Check component delete exist in the page', function () {

    $this->actingAs(User::factory()->create())
        ->get('/panel/dashboard')
        ->assertOK();

    Announcement::create(['name' => 'announcement One']);
    Announcement::create(['name' => 'announcement Two']);

    Livewire::test(All::class)
        ->assertSee('announcement One')
        ->assertSee('announcement Two')
        ->assertSeeLivewire(Delete::class);
});
todo('check register deleted in method confirmed', function () {
    $this->actingAs(User::factory()->create())
        ->get('/panel/dashboard')
        ->assertOK();

    $announcement = Announcement::create(['name' => 'announcement One']);

    Livewire::test(All::class)
        ->assertSee('announcement One')
        ->assertSeeLivewire(Delete::class);


    Livewire::test(Delete::class, ['announcement' => $announcement])
        ->call('delete')
        ->call('confirmed', 'Categoria deletada com sucesso');

    $this->assertDatabaseCount('categories', 0);
});
