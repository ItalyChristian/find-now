<?php

namespace App\Livewire\Panel\Announcement;

use App\Models\Category;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Finder\SplFileInfo;

class Create extends Component
{
    use WithFileUploads;

    public ?bool $modal = false;

    public ?int $category_id = null;
    public ?string $title = null;
    public ?string $description = null;
    public ?string $method_receipt = null;
    public ?float $price = null;
    public ?array $files = [];

    public $backup = [];


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
