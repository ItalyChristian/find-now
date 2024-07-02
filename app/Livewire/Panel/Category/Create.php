<?php

namespace App\Livewire\Panel\Category;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class Create extends Component
{
    public ?bool $modal = false;

    public function render(): View
    {
        return view('livewire.panel.category.create');
    }
}
