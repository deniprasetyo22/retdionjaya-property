<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\CompanyProfile;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Title('Tentang Kami')]
class About extends Component
{
    public function render()
    {
        return view('livewire.about', [
            'about' => CompanyProfile::first()
        ]);
    }
}