<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class TicketCommentList extends Component
{
    public Ticket $ticket;

    public $perPage = 5;

    protected $listeners = ['refresh' => 'loadLatestComments'];

    public function loadPreviousComments()
    {
        $this->perPage += 5;
    }

    public function loadLatestComments()
    {
        return Comment::query()
            ->with(['media', 'commentator.media'])
            ->whereHasMorph('commentable', Ticket::class, function (Builder $query) {
                $query->where('id', $this->ticket->id);
            })
            ->when($this->user instanceof User, function (Builder $query) {
                return $query->where('is_private', false);
            })
            ->latest()
            ->paginate($this->perPage);
    }

    public function getUserProperty()
    {
        return \Auth::user();
    }

    public function render()
    {
        return view('livewire.ticket-comment-list', [
            'comments' => $this->loadLatestComments(),
        ]);
    }
}
