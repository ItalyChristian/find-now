<?php

namespace App\Livewire\Panel\Announcement;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class All extends Component
{

    private function getAllAnnouncements(): ?Object
    {
        return Auth::user()->announcements()->with('category', 'images', 'user.address')
            ->get()
            ->map(function ($announcement) {
                return [
                    'id' => $announcement->id,
                    'title' => $announcement->title,
                    'description' => $announcement->description,
                    'price' => $announcement->price,
                    'category' => $announcement->category->name,
                    'user' => $announcement->user->name,
                    'status' => $announcement->status,
                    'images' => $announcement->images->map(function ($image) {
                        return [
                            'images_id' => $image->images_id,
                            'url' => $image->path
                        ];
                    }),
                    'address' => $announcement->user->address->map(function ($address) {
                        return [
                            'city' => $address->city,
                            'state' => $address->state,
                            'neighborhood' => $address->neighborhood,
                            'street' => $address->street,
                            'number' => $address->number,
                            'complement' => $address->complement,
                            'cep' => $address->cep,
                        ];
                    })
                ];
            });
    }

    #[On('announcement:created')]
    #[On('announcement:deleted')]
    #[On('announcement:updated')]
    public function render(): View
    {
        return view('livewire.panel.announcement.all', [
            'rows' => $this->getAllAnnouncements(),
            'headers' => [
                ['index' => 'id', 'label' => '#'],
                ['index' => 'title', 'label' => 'Titulo'],
                ['index' => 'description', 'label' => 'Descrição'],
                ['index' => 'price', 'label' => 'Preço'],
                ['index' => 'category', 'label' => 'Categoria'],
                ['index' => 'status', 'label' => 'Status'],
                ['index' => 'action', 'label' => 'Actions'],
            ]
        ]);
    }
}
