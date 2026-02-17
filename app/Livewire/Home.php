<?php

namespace App\Livewire;

use App\Models\Article;
use App\Models\CompanyProfile;
use App\Models\Project;
use Livewire\Component;
use App\Models\Property;
use App\Models\Residence;
use App\Models\Testimonial;
use Livewire\Attributes\Title;

#[Title('Beranda')]
class Home extends Component
{
    public $showVideo = false;

    public function toggleModalVideo()
    {
        $this->showVideo = !$this->showVideo;
    }

    public function render()
    {
        return view('livewire.home', [
            'projects' => Project::latest()->paginate(3),
            'articles' => Article::latest()->paginate(3),
            'testimonials' => Testimonial::has('project')->latest()->paginate(3),
            'company_profile' => CompanyProfile::first(),
        ]);
    }
}