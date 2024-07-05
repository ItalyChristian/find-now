<?php

namespace App\Livewire\Panel\Category;

use App\Models\Category;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

class Delete extends Component
{

    use Interactions;

    public ?Category $category;

    public function delete(): void
    {
        $this->dialog()
            ->question('Atenção!', 'Tem certeza?')
            ->confirm('Confirmar', 'confirmed', 'Categoria deletada com sucesso')
            ->cancel('Cancelar', 'cancelled', 'Ação foi cancelada com sucesso')
            ->send();
    }
    public function confirmed(string $message): void
    {

        $this->category->delete();
        $this->dispatch('category:deleted');
        $this->dialog()->success('Sucesso', $message)->send();
    }

    public function cancelled(string $message): void
    {
        $this->dialog()->error('Cancelado', $message)->send();
    }
    public function render(): View
    {
        return view('livewire.panel.category.delete');
    }
}
