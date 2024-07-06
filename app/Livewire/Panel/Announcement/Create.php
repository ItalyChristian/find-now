<?php

namespace App\Livewire\Panel\Announcement;

use App\Models\Category;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use TallStackUi\Traits\Interactions;

class Create extends Component
{
    use WithFileUploads;
    use Interactions;

    public ?bool $modal = false;

    public ?int $category_id = null;
    public ?string $title = null;
    public ?string $description = null;
    public ?string $method_receipt = null;
    public ?float $price = null;
    public ?array $files = [];

    public $backup = [];

    public function rules(): array
    {
        return [
            'title' => 'required|min:6|max:255|string',
            'description' => 'required|min:6|max:255|string',
            'category_id' => 'required|int',
            'method_receipt' => 'required|string',
            'price' => 'required|numeric',
            'files.*' => 'nullable|image|max:2024'
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
    public function updatingFiles(): void
    {

        $this->backup = $this->files;
    }

    public function updatedFiles(): void
    {
        if (!$this->files) {
            return;
        }

        $file = Arr::flatten(array_merge($this->backup, [$this->files]));

        $this->files = collect($file)->unique(fn (UploadedFile $item) => $item->getClientOriginalName())->toArray();
    }
    public function store(): void
    {
        $validated = $this->validate();
        $announcement = Auth::user()->announcements()->create(Arr::except($validated, ['files']));

        if (count($this->files) > 0) {

            collect($this->files)->map(function ($file) use ($announcement) {

                $filename = str_replace(' ', '', date('YmdHi') . $file->getClientOriginalName());
                $imagePath = $file->storeAs('public/images', $filename);
                $announcement->images()->create(['path' => $imagePath]);
            });
        }

        $this->toast()->success('Anúncio cadastrado com sucesso!')->send();
        $this->dispatch('announcement:created');
        $this->reset();
    }
    public function getAllCategories(): ?Object
    {
        return Category::all();
    }
    public function render(): View
    {

        return view('livewire.panel.announcement.create', [
            'categories' => $this->getAllCategories()->toArray()
        ]);
    }
}
