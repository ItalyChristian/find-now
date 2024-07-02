<?php

namespace App\Livewire\Panel\Category;

use App\Models\Category;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Validate;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

class Create extends Component
{
    use Interactions;

    public ?bool $modal = false;

    public ?string $name = null;

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'O campo nome é obrigatório.',
            'name.string' => 'O campo nome deve ser uma string.',
            'name.max' => 'O campo nome deve ter menos de 255 caracteres.',
        ];
    }

    public function store(): void
    {

        $validated = $this->validate();

        Category::create($validated);
        $this->toast()->success('Categoria cadastrada com sucesso!')->send();
        $this->dispatch('category:created');
        $this->reset();
    }
    public function render(): View
    {
        return view('livewire.panel.category.create');
    }
}
