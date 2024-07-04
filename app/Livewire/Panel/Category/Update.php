<?php

namespace App\Livewire\Panel\Category;

use Illuminate\Contracts\View\View;
use Livewire\Component;
use App\Models\Category;
use TallStackUi\Traits\Interactions;

class Update extends Component
{
    use Interactions;

    public ?Category $category;

    public ?bool $modal = false;

    public ?string $name = null;

    public function mount(Category $category): void
    {
        $this->name = $category->name;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|min:6|max:255|string',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'O campo nome é obrigatório.',
            'name.string' => 'O campo nome deve ser uma string.',
            'name.max' => 'O campo nome deve ter menos de 255 caracteres.',
            'name.min' => 'O campo nome deve ter no minimo 6 caracteres.',
        ];
    }
    public function update(): void
    {

        $validated = $this->validate();

        $this->category->update($validated);
        $this->toast()->success('Categoria editada com sucesso!')->send();
        $this->dispatch('category:update');
        $this->reset();
    }
    public function render(): View
    {
        return view('livewire.panel.category.update');
    }
}
