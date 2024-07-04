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
    use WithPagination;

    public ?int $quantity = 5;

    public ?string $search = null;

    #[On('category:created')]
    #[On('category:deleted')]
    #[On('category:update')]

    public function mount(): void
    {
        $this->resetPage();
    }
    public function render(): View
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
