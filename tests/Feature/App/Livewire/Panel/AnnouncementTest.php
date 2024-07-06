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
todo('Check component list all categories exist in the page', function () {

    $this->actingAs(User::factory()->create())
        ->get('/panel/dashboard')
        ->assertOK()
        ->assertSeeLivewire(All::class);
});
// Create
todo('check component create category exist in the page', function () {

    $this->actingAs(User::factory()->create())
        ->get('/panel/dashboard')
        ->assertOK()
        ->assertSeeLivewire(Create::class);
});
todo('check if open modal in click the component', function () {

    $this->actingAs(User::factory()->create())
        ->get('/panel/dashboard')
        ->assertOK()
        ->assertSeeLivewire(Create::class);

    Livewire::test(Create::class)
        ->toggle('modal', true)
        ->assertSeeText('Cadastrar Categoria');
});
todo('check is message error in create category empty', function () {

    $this->actingAs(User::factory()->create())
        ->get('/panel/dashboard')
        ->assertOK();

    Livewire::test(Create::class)
        ->set('name', 'asf')
        ->call('store')
        ->assertHasErrors();
});
todo('check category is register and dispatch event for component list all categories', function () {

    $this->actingAs(User::factory()->create())
        ->get('/panel/dashboard')
        ->assertOK();

    Livewire::test(Create::class)
        ->toggle('modal', true)
        ->set('name', 'Category Test')
        ->call('store')
        ->assertDispatched('category:created')
        ->toggle('modal', false);

    $this->assertDatabaseHas('categories', [
        'name' => 'Category Test'
    ]);
});
todo('check display categories', function () {

    $this->actingAs(User::factory()->create())
        ->get('/panel/dashboard')
        ->assertOK();

    Announcement::create(['name' => 'Category One']);
    Announcement::create(['name' => 'Category Two']);

    $this->assertDatabaseCount('categories', 2);

    Livewire::test(All::class)
        ->assertSee('Category One')
        ->assertSee('Category Two');
});
// Update
todo('Check component update exist in the page', function () {

    $this->actingAs(User::factory()->create())
        ->get('/panel/dashboard')
        ->assertOK();

    Announcement::create(['name' => 'Category One']);
    Announcement::create(['name' => 'Category Two']);

    Livewire::test(All::class)
        ->assertSee('Category One')
        ->assertSee('Category Two')
        ->assertSeeLivewire(Update::class);
});
todo('check if open modal in click button for update category', function () {

    $this->actingAs(User::factory()->create())
        ->get('/panel/dashboard')
        ->assertOK();

    $category = Announcement::create(['name' => 'Category One']);

    Livewire::test(All::class)
        ->assertSee('Category One')
        ->assertSeeLivewire(Update::class);

    Livewire::test(Update::class, ['category' => $category])
        ->toggle('modal', true)
        ->assertSeeText('Editar Categoria');
});
todo('check is message error in update category', function () {

    $this->actingAs(User::factory()->create())
        ->get('/panel/dashboard')
        ->assertOK();

    $category = Announcement::create(['name' => 'Category One']);

    Livewire::test(All::class)
        ->assertSee('Category One')
        ->assertSeeLivewire(Update::class);

    Livewire::test(Update::class, ['category' => $category])
        ->set('name', '')
        ->call('update')
        ->assertHasErrors();
});
todo('check is message success in update category', function () {

    $this->actingAs(User::factory()->create())
        ->get('/panel/dashboard')
        ->assertOK();

    $category = Announcement::create(['name' => 'Category One']);

    Livewire::test(All::class)
        ->assertSee('Category One')
        ->assertSeeLivewire(Update::class);

    Livewire::test(Update::class, ['category' => $category])
        ->toggle('modal', true)
        ->set('name', 'Category Two')
        ->call('update')
        ->toggle('modal', false);

    $this->assertDatabaseHas('categories', [
        'name' => 'Category Two'
    ]);
});
// Delete
todo('Check component delete exist in the page', function () {

    $this->actingAs(User::factory()->create())
        ->get('/panel/dashboard')
        ->assertOK();

    Announcement::create(['name' => 'Category One']);
    Announcement::create(['name' => 'Category Two']);

    Livewire::test(All::class)
        ->assertSee('Category One')
        ->assertSee('Category Two')
        ->assertSeeLivewire(Delete::class);
});
todo('check register deleted in method confirmed', function () {
    $this->actingAs(User::factory()->create())
        ->get('/panel/dashboard')
        ->assertOK();

    $category = Announcement::create(['name' => 'Category One']);

    Livewire::test(All::class)
        ->assertSee('Category One')
        ->assertSeeLivewire(Delete::class);


    Livewire::test(Delete::class, ['category' => $category])
        ->call('delete')
        ->call('confirmed', 'Categoria deletada com sucesso');

    $this->assertDatabaseCount('categories', 0);
});
