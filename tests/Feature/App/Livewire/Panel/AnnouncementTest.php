<?php

use App\Livewire\Panel\Announcement\{All, Create, Delete, Update};
use App\Models\Announcement;
use App\Models\Category;
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
it('check is message error in create announcement empty', function () {

    $this->actingAs(User::factory()->create())
        ->get('/panel/dashboard')
        ->assertOK();

    Livewire::test(Create::class)
        ->set('title', '')
        ->set('description', '')
        ->set('category_id', '')
        ->set('method_receipt', '')
        ->set('price', '')
        ->call('store')
        ->assertHasErrors();
});
it('check announcement is register no passed photos and dispatch event for component list all announcements', function () {

    $user = User::factory()->create();
    $this->actingAs($user)
        ->get('/panel/dashboard')
        ->assertOK();

    Category::create(['name' => 'Category One']);

    Livewire::actingAs($user)
        ->test(Create::class)
        ->toggle('modal', true)
        ->set('title', 'Announcement Teste')
        ->set('description', 'Description Teste')
        ->set('category_id', 1)
        ->set('method_receipt', 'recevied')
        ->set('price', '10.30')
        ->call('store')
        ->assertDispatched('announcement:created')
        ->toggle('modal', false);

    $this->assertDatabaseHas('announcements', [
        'title' => 'Announcement Teste',
        'description' => 'Description Teste',
        'category_id' => 1,
        'method_receipt' => 'recevied',
        'price' => '10.30'
    ]);
});
it('check display announcements', function () {

    $user  = User::factory()->create();
    $category = Category::factory()->create();

    $this->actingAs($user)
        ->get('/panel/dashboard')
        ->assertOK();

    Announcement::create([
        'user_id' => $user->id,
        'category_id' => $category->id,
        'title' => 'Announcement Teste',
        'description' => 'Description Teste',
        'method_receipt' => 'recevied',
        'price' => '10.30'
    ]);

    $this->assertDatabaseCount('announcements', 1);

    Livewire::test(All::class)
        ->assertSee('Announcement Teste');
});
// Update
it('Check component update exist in the page', function () {

    $user  = User::factory()->create();
    $category = Category::factory()->create();

    $this->actingAs($user)
        ->get('/panel/dashboard')
        ->assertOK();

    Announcement::create([
        'user_id' => $user->id,
        'category_id' => $category->id,
        'title' => 'Announcement Teste',
        'description' => 'Description Teste',
        'method_receipt' => 'recevied',
        'price' => '10.30'
    ]);

    Livewire::test(All::class)
        ->assertSee('Announcement Teste')
        ->assertSeeLivewire(Update::class);
});
it('check if open modal in click button for update announcement', function () {

    $user  = User::factory()->create();
    $category = Category::factory()->create();

    $this->actingAs($user)
        ->get('/panel/dashboard')
        ->assertOK();

    $announcement = Announcement::create([
        'user_id' => $user->id,
        'category_id' => $category->id,
        'title' => 'Announcement Teste',
        'description' => 'Description Teste',
        'method_receipt' => 'recevied',
        'price' => '10.30'
    ]);

    Livewire::test(Update::class, ['announcement_id' => $announcement->id])
        ->toggle('modal', true)
        ->assertSeeText('Editar Anuncio');
});
it('check is message error in update announcement', function () {

    $user = User::factory()->create();
    $category = Category::factory()->create();


    $this->actingAs($user)
        ->get('/panel/dashboard')
        ->assertOK();

    $announcement = Announcement::create([
        'user_id' => $user->id,
        'category_id' => $category->id,
        'title' => 'Announcement Teste',
        'description' => 'Description Teste',
        'method_receipt' => 'recevied',
        'price' => '10.30'
    ]);

    Livewire::test(All::class)
        ->assertSee('Announcement Teste')
        ->assertSeeLivewire(Update::class);

    Livewire::test(Update::class, ['announcement_id' => $announcement->id])
        ->set('title', '')
        ->set('description', '')
        ->set('category_id', '')
        ->set('method_receipt', '')
        ->set('price', '')
        ->call('update')
        ->assertHasErrors();
});
it('check is message success in update announcement', function () {

    $user = User::factory()->create();
    $category = Category::factory()->create();


    $this->actingAs($user)
        ->get('/panel/dashboard')
        ->assertOK();

    $announcement = Announcement::create([
        'user_id' => $user->id,
        'category_id' => $category->id,
        'title' => 'Announcement Teste',
        'description' => 'Description Teste',
        'method_receipt' => 'recevied',
        'price' => '10.30'
    ]);

    Livewire::test(All::class)
        ->assertSee('Announcement Teste')
        ->assertSeeLivewire(Update::class);

    Livewire::test(Update::class, ['announcement_id' => $announcement->id])
        ->set('title', 'Announcement Teste -Updated')
        ->set('description', 'Description Teste')
        ->set('category_id', $category->id)
        ->set('method_receipt', 'recevied')
        ->set('price', 250.00)
        ->call('update')
        ->toggle('modal', false);

    $this->assertDatabaseHas('announcements', [
        'title' => 'Announcement Teste -Updated'
    ]);
});
// Delete
it('Check component delete exist in the page', function () {

    $user = User::factory()->create();
    $category = Category::factory()->create();

    $this->actingAs($user)
        ->get('/panel/dashboard')
        ->assertOK();

    $announcement = Announcement::create([
        'user_id' => $user->id,
        'category_id' => $category->id,
        'title' => 'Announcement Teste',
        'description' => 'Description Teste',
        'method_receipt' => 'recevied',
        'price' => '10.30'
    ]);

    Livewire::test(All::class)
        ->assertSee('Announcement Teste')
        ->assertSeeLivewire(Delete::class);
});
it('check register deleted in method confirmed', function () {

    $user = User::factory()->create();
    $category = Category::factory()->create();

    $this->actingAs($user)
        ->get('/panel/dashboard')
        ->assertOK();

    $announcement = Announcement::create([
        'user_id' => $user->id,
        'category_id' => $category->id,
        'title' => 'Announcement Teste',
        'description' => 'Description Teste',
        'method_receipt' => 'recevied',
        'price' => '10.30'
    ]);


    Livewire::test(All::class)
        ->assertSee('Announcement Teste')
        ->assertSeeLivewire(Delete::class);


    Livewire::test(Delete::class, ['announcement_id' => $announcement->id])
        ->call('delete')
        ->call('confirmed', 'Anuncio deletada com sucesso');

    $this->assertDatabaseCount('announcements', 0);
});
