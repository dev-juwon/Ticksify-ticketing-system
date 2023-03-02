<?php

namespace App\Listeners;

use App\Events\TicketCreated;
use App\Mail\TicketReceived;
use App\Mail\TicketSubmitted;
use App\Models\Agent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use Notification;

class SendTicketConfirmation
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\TicketCreated  $event
     * @return void
     */
    public function handle(TicketCreated $event)
    {
        Mail::to($event->ticket->user->email)->send(new TicketReceived($event->ticket));

        $admins = Agent::query()->where('is_admin', true)->get();

        Notification::send($admins, new \App\Notifications\TicketSubmitted($event->ticket));

        foreach ($admins as $recipient) {
            Mail::to($recipient->email)->send(new TicketSubmitted($event->ticket));
        }
    }
}
