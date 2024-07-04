<?php

use App\Livewire\Panel\Category\{All, Create};
use App\Models\User;

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
todo('check if open modal in click the component');
todo('check is message error in create category');
todo('Check component list all update exist in the page');
// Update
todo('check open dialog in click component for update category');
todo('check is message success in create category');
todo('check is message error in update category');
todo('check is message success in update category');
// Delete
todo('Check component list all delete exist in the page');
todo('check open dialog in click component for delete category');
todo('check is message error in delete category');
todo('check is message success in delete category');
