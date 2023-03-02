<?php

namespace App\Http\Livewire;

use App\Enums\TicketStatus;
use App\Events\CommentCreated;
use App\Models\Agent;
use App\Models\Comment;
use App\Models\Ticket;
use Livewire\Component;
use Livewire\WithFileUploads;

class TicketCommentForm extends Component
{
    use WithFileUploads;

    public Ticket $ticket;

    public Comment $comment;

    public $attachments = [];

    protected $rules = [
        'comment.content' => 'required|string',
        'comment.is_private' => 'boolean',
        'attachments.*' => 'file|mimes:jpg,jpeg,png,bmp,gif,svg,webp,pdf,zip|max:5120',
    ];

    protected function makeBlankComment(): Comment
    {
        return new Comment([
            'is_private' => false,
        ]);
    }

    public function mount()
    {
        $this->comment = $this->makeBlankComment();

        if ($this->user instanceof Agent) {
            $this->user->load('cannedResponses');
        }
    }

    public function updatedAttachments()
    {
        $this->validate([
            'attachments.*' => 'file|mimes:jpg,jpeg,png,bmp,gif,svg,webp,pdf,zip|max:5120',
        ], [
            'attachments.*.mimes' => '#:position',
        ]);
    }

    public function removeAttachment($index)
    {
        array_splice($this->attachments, $index, 1);
    }

    public function submit()
    {
        $this->validate();
        if ($this->ticket->status->value === TicketStatus::CLOSED->value) {
            return $this->addError('comment.content', trans('You can\'t comment on this ticket because it has been closed.'));
        }
        $this->comment->commentator()->associate($this->user);
        $this->comment->commentable()->associate($this->ticket);
        $this->comment->save();
        foreach ($this->attachments as $attachment) {
            $this->comment
                ->addMedia($attachment->getRealPath())
                ->usingName($attachment->getClientOriginalName())
                ->usingFileName($attachment->getClientOriginalName())
                ->toMediaCollection('attachments');
        }
        CommentCreated::dispatch($this->comment);
        $this->comment = $this->makeBlankComment();
        $this->reset('attachments');
        $this->emitTo('ticket-comment-list', 'refresh');
        $this->dispatchBrowserEvent('comment-submitted');
    }

    public function getUserProperty()
    {
        return \Auth::user();
    }

    public function render()
    {
        return view('livewire.ticket-comment-form');
    }
}
