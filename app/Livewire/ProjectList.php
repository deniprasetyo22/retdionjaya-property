<?php

namespace App\Livewire;

use App\Models\Project;
use Livewire\Component;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

#[Title('Proyek')]
class ProjectList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public $perPage = 9;

    #[Url]
    public $search = '';

    #[Url]
    public $sort = 'Latest';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function setSort(string $value)
    {
        $this->sort = $value;
        $this->resetPage();
    }

    public function updatedSort()
    {
        $this->resetPage();
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Project::query();

        // 1. Logic Search Text
        if ($this->search) {
            $search = $this->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%");
            });
        }

        // 2. Logic Sorting
        match ($this->sort) {
            'Latest'  => $query->latest(),
            'Oldest'  => $query->oldest(),
            default   => $query->latest(),
        };

        return view('livewire.project-list', [
            'projects' => $query->paginate($this->perPage)
        ]);
    }
}