<?php

namespace App\Livewire\Panel\Announcement;

use App\Models\Announcement;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

class Delete extends Component
{

    use Interactions;
    public ?int $announcement_id;
    public ?Announcement $announcement;

    public function mount(Announcement $announcement): void
    {
        $this->announcement = Announcement::find($this->announcement_id);
    }
    public function delete(): void
    {
        $this->dialog()
            ->question('Atenção!', 'Tem certeza?')
            ->confirm('Confirmar', 'confirmed', 'Anúncio deletada com sucesso')
            ->cancel('Cancelar', 'cancelled', 'Ação foi cancelada com sucesso')
            ->send();
    }
    public function confirmed(string $message): void
    {
        if (count($this->announcement->images) > 0) {

            $this->announcement->images->map(fn ($image) => Storage::delete($image->path));
        }

        $this->announcement->delete();

        $this->dispatch('announcement:deleted');
        $this->dialog()->success('Sucesso', $message)->send();
    }

    public function cancelled(string $message): void
    {
        $this->dialog()->error('Cancelado', $message)->send();
    }
    public function render(): View
    {
        return view('livewire.panel.announcement.delete');
    }
}
