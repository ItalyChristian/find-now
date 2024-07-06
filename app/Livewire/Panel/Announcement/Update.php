<?php

namespace App\Livewire\Panel\Announcement;

use App\Models\Announcement;
use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use TallStackUi\Traits\Interactions;

class Update extends Component
{
    use WithFileUploads;
    use Interactions;

    public ?bool $modal = false;

    public ?int $category_id = null;
    public ?string $title = null;
    public ?string $description = null;
    public ?string $method_receipt = null;
    public ?float $price = null;
    public ?bool $status = null;
    public ?array $files = [];

    public $backup = [];
    public ?int $announcement_id;
    public ?Announcement $announcement;

    public function mount(Announcement $announcement): void
    {
        $this->announcement = Announcement::find($this->announcement_id);
        $this->category_id = $this->announcement->category_id;
        $this->title = $this->announcement->title;
        $this->description = $this->announcement->description;
        $this->method_receipt = $this->announcement->method_receipt;
        $this->price = $this->announcement->price;
        $this->status = $this->announcement->status;
    }
    public function rules(): array
    {
        return [
            'title' => 'required|min:6|max:255|string',
            'description' => 'required|min:6|max:255|string',
            'category_id' => 'required|int',
            'method_receipt' => 'required|string',
            'price' => 'required|numeric',
            'files.*' => 'nullable|image|max:2024',
            'status' => 'nullable|bool',
        ];
    }
    public function messages(): array
    {
        return [
            'title.required' => 'O campo nome é obrigatório.',
            'title.string' => 'O campo nome deve ser uma string.',
            'title.max' => 'O campo nome deve ter menos de 255 caracteres.',
            'title.min' => 'O campo nome deve ter no minimo 6 caracteres.',
            'description.required' => 'O campo descrição é obrigatório.',
            'description.string' => 'O campo descrição deve ser uma string.',
            'description.max' => 'O campo descrição deve ter menos de 255 caracteres.',
            'description.min' => 'O campo descrição deve ter no minimo 6 caracteres.',
            'category_id.required' => 'O campo categoria é obrigatório.',
            'method_receipt.required' => 'O campo forma de cobrança é obrigatório.',
            'price.required' => 'O campo preço é obrigatório.',
            'price.numeric' => 'O campo preço deve ser um número.',
        ];
    }
    public function update(): void
    {
        $validated = $this->validate();

        $this->announcement->update(Arr::except($validated, ['files']));


        if (count($this->files) > 0) {

            $this->announcement->images->map(fn ($image) => Storage::delete($image->path));
            $this->announcement->images()->delete();

            collect($this->files)->map(function ($file) {

                $filename = str_replace(' ', '', date('YmdHi') . $file->getClientOriginalName());
                $imagePath = $file->storeAs('public/images', $filename);
                $this->announcement->images()->create(['path' => $imagePath]);
            });
        }

        $this->toast()->success('Anúncio editado com sucesso!')->send();
        $this->dispatch('announcement:updated');
        $this->reset();
    }
    public function getAllCategories(): ?Object
    {
        return Category::all();
    }
    public function render(): View
    {
        return view('livewire.panel.announcement.update', [
            'categories' => $this->getAllCategories()->toArray()
        ]);
    }
}
