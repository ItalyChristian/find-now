<?php

namespace App\Livewire\Panel\Category;

use App\Models\Category;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;

class All extends Component
{
    c

    #[On('category:created')]
    #[On('category:deleted')]
    #[On('category:update')]

    public function render()
    {
        return view('livewire.panel.category.all', [
            'rows' =>
            Category::query()
                ->when($this->search, function (Builder $query) {
                    return $query->where('name', 'like', "%{$this->search}%");
                })
                ->paginate($this->quantity)
                ->withQueryString(),

            'headers' => [
                ['index' => 'id', 'label' => '#'],
                ['index' => 'name', 'label' => 'Member'],
                ['index' => 'action', 'label' => 'Actions'],
            ]
        ]);
    }
}
