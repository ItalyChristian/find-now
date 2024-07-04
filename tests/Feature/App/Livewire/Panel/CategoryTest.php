<?php

use App\Livewire\Panel\Category\{All, Create, Delete, Update};
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
it('Check component update exist in the page', function () {

    $this->actingAs(User::factory()->create())
        ->get('/panel/categories')
        ->assertOK();

    Category::create(['name' => 'Category One']);
    Category::create(['name' => 'Category Two']);

    Livewire::test(All::class)
        ->assertSee('Category One')
        ->assertSee('Category Two')
        ->assertSeeLivewire(Update::class);
});

it('check if open modal in click button for update category', function () {

    $this->actingAs(User::factory()->create())
        ->get('/panel/categories')
        ->assertOK();

    $category = Category::create(['name' => 'Category One']);

    Livewire::test(All::class)
        ->assertSee('Category One')
        ->assertSeeLivewire(Update::class);

    Livewire::test(Update::class, ['category' => $category])
        ->toggle('modal', true)
        ->assertSeeText('Editar Categoria');
});
it('check is message error in update category', function () {

    $this->actingAs(User::factory()->create())
        ->get('/panel/categories')
        ->assertOK();

    $category = Category::create(['name' => 'Category One']);

    Livewire::test(All::class)
        ->assertSee('Category One')
        ->assertSeeLivewire(Update::class);

    Livewire::test(Update::class, ['category' => $category])
        ->set('name', '')
        ->call('update')
        ->assertHasErrors();
});
it('check is message success in update category', function () {

    $this->actingAs(User::factory()->create())
        ->get('/panel/categories')
        ->assertOK();

    $category = Category::create(['name' => 'Category One']);

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
todo('check open dialog in click component for delete category', function () {
    $this->actingAs(User::factory()->create())
        ->get('/panel/categories')
        ->assertOK();

    $category = Category::create(['name' => 'Category One']);

    Livewire::test(All::class)
        ->assertSee('Category One')
        ->assertSeeLivewire(Delete::class);


    Livewire::test(Delete::class, ['category' => $category])
        ->call('delete')
        ->call('confirmed');
});
todo('check is message error in delete category');
todo('check is message success in delete category');
