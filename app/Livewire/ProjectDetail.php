<?php

namespace App\Livewire;

use App\Models\Project;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Detail Proyek')]
class ProjectDetail extends Component
{
    public $project;
    public $showAll = false;

    // Gallery State
    public $showModal = false;
    public $activeImage = null;
    public $currentIndex = 0;

    public function mount(Project $project)
    {
        $this->project = $project;
    }

    // --- HELPER: Mengambil Array Gambar (Media/FloorPlan) ---
    private function getImagesArray($source)
    {
        if (is_array($source)) {
            return array_values(array_filter($source));
        }
        $decoded = json_decode($source, true);
        return is_array($decoded) ? array_values(array_filter($decoded)) : [];
    }

    public function toggleShow()
    {
        $this->showAll = !$this->showAll;
    }

    public function openModal($img)
    {
        $this->activeImage = $img;
        $this->showModal = true;

        // Cari index gambar yang sedang diklik dari galeri
        $rawMedia = $this->project->media;
        $gallery = is_array($rawMedia) ? $rawMedia : json_decode($rawMedia, true) ?? [];
        $gallery = array_values(array_filter($gallery)); // reset keys

        $this->currentIndex = array_search($img, $gallery);
    }

    // Tambahkan fungsi navigasi baru
    public function nextImage()
    {
        $rawMedia = $this->project->media;
        $gallery = array_values(array_filter(is_array($rawMedia) ? $rawMedia : json_decode($rawMedia, true) ?? []));

        if ($this->currentIndex < count($gallery) - 1) {
            $this->currentIndex++;
        } else {
            $this->currentIndex = 0; // Loop ke awal
        }
        $this->activeImage = $gallery[$this->currentIndex];
    }

    public function prevImage()
    {
        $rawMedia = $this->project->media;
        $gallery = array_values(array_filter(is_array($rawMedia) ? $rawMedia : json_decode($rawMedia, true) ?? []));

        if ($this->currentIndex > 0) {
            $this->currentIndex--;
        } else {
            $this->currentIndex = count($gallery) - 1; // Loop ke akhir
        }
        $this->activeImage = $gallery[$this->currentIndex];
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function render()
    {
        return view('livewire.project-detail');
    }
}