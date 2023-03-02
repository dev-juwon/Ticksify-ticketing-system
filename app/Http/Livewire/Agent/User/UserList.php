<?php

namespace App\Http\Livewire\Agent\User;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;

class UserList extends Component
{
    use AuthorizesRequests;
    use WithPagination;

    public $search;

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function mount()
    {
        $this->authorize('viewAny', User::class);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function getUsersProperty()
    {
        return User::query()
            ->with('media')
            ->withCount('tickets')
            ->when($this->search, function ($query) {
                $query
                    ->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);
    }

    public function render()
    {
        return view('livewire.agent.user.user-list');
    }
}
