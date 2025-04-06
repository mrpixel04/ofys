<?php

namespace App\Livewire\Provider;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Profile extends Component
{
    public $user;

    public function mount()
    {
        $this->user = Auth::user();
    }

    public function render()
    {
        return view('livewire.provider.profile');
    }
}
