<?php

namespace App\Livewire\Panel\Category;

use App\Models\Category;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class All extends Component
{

    #[On('category:created')]
    public function render(): View
    {
        return view('livewire.panel.category.all', ['categories' => Category::all()]);
    }
}
