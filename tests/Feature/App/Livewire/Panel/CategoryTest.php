<?php

use App\Livewire\Panel\Category\{All, Create, Delete};
use App\Models\Category;
use App\Models\User;
use Livewire\Livewire;

it('Check if route exists and user is logged in', function () {

    $this->actingAs(User::factory()->create());

    $this->get('/panel/categories')
        ->assertOk();
});
it('Check component list all categories exist in the page', function () {

    $this->actingAs(User::factory()->create())
        ->get('/panel/categories')
        ->assertOK()
        ->assertSeeLivewire(All::class);
});
// Create
it('check component create category exist in the page', function () {

    $this->actingAs(User::factory()->create())
        ->get('/panel/categories')
        ->assertOK()
        ->assertSeeLivewire(Create::class);
});
it('check if open modal in click the component', function () {

    $this->actingAs(User::factory()->create())
        ->get('/panel/categories')
        ->assertOK()
        ->assertSeeLivewire(Create::class);

    Livewire::test(Create::class)
        ->toggle('modal', true)
        ->assertSeeText('Cadastrar Categoria');
});
it('check is message error in create category empty', function () {

    $this->actingAs(User::factory()->create())
        ->get('/panel/categories')
        ->assertOK();

    Livewire::test(Create::class)
        ->set('name', 'asf')
        ->call('store')
        ->assertHasErrors();
});
it('check category is register and dispatch event for component list all categories', function () {

    $this->actingAs(User::factory()->create())
        ->get('/panel/categories')
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
it('check display categories', function () {

    $this->actingAs(User::factory()->create())
        ->get('/panel/categories')
        ->assertOK();

    Category::create(['name' => 'Category One']);
    Category::create(['name' => 'Category Two']);

    $this->assertDatabaseCount('categories', 2);

    Livewire::test(All::class)
        ->assertSee('Category One')
        ->assertSee('Category Two');
});
// Update
todo('Check component update exist in the page');
todo('check open dialog in click component for update category');
todo('check is message success in create category');
todo('check is message error in update category');
todo('check is message success in update category');
// Delete
it('Check component delete exist in the page', function () {

    $this->actingAs(User::factory()->create())
        ->get('/panel/categories')
        ->assertOK();

    Category::create(['name' => 'Category One']);
    Category::create(['name' => 'Category Two']);

    Livewire::test(All::class)
        ->assertSee('Category One')
        ->assertSee('Category Two')
        ->assertSeeLivewire(Delete::class);
});
it('check open dialog in click component for delete category');
todo('check is message error in delete category');
todo('check is message success in delete category');
