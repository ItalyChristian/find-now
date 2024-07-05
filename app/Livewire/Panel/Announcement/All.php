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
        return Auth::user()->announcements()->with('category', 'images', 'user.address')->get();
    }

    #[On('announcement:created')]
    public function render(): View
    {
        return view('livewire.panel.announcement.all', [
            'announcements' => $this->getAllAnnouncements()
        ]);
    }
}
