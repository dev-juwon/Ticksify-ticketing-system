<div>
    <x-slot:title>
        {{ __('Ticket #:id', ['id' => $ticket->id]) }}
    </x-slot:title>

    <x-slot:header>
        <div class="relative py-6 max-w-3xl mx-auto px-4 sm:px-6 lg:max-w-5xl lg:px-8">
            <h1 class="font-display font-medium tracking-tight text-white text-4xl">
                {{ __('Ticket #:id', ['id' => $ticket->id]) }}
            </h1>
        </div>
    </x-slot:header>

    <div class="-mt-32 relative max-w-3xl mx-auto sm:px-6 lg:max-w-5xl lg:px-8">
        <div class="overflow-hidden rounded-lg bg-white shadow">
            <div class="divide-y divide-slate-200 lg:grid lg:grid-cols-12 lg:divide-y-0 lg:divide-x">
                @include('layouts.navigation-user')

                <div class="lg:col-span-9 min-h-[500px]">
                    <div class="border-b border-slate-200 pl-4 pr-6 pt-4 pb-4 sm:pl-6 lg:pl-8 xl:pl-6 xl:pt-6">
                        <div class="flex items-baseline justify-between">
                            <h1 class="flex-1 font-display text-lg">
                                {{ $ticket->subject }}
                            </h1>
                            <span class="ml-5 hidden sm:inline-flex items-center rounded bg-blue-100 px-2.5 py-0.5 text-sm font-medium text-blue-800">
                                {{ $ticket->status->label() }}
                            </span>
                        </div>
                        <div>
                            <span class="text-sm text-slate-500">
                                {{ __('Submitted :timeago on :date', ['timeago' => $ticket->created_at->diffForHumans(), 'date' => $ticket->created_at->toFormattedDateString()]) }}
                            </span>
                        </div>
                    </div>
                    <div class="px-4 py-6 sm:p-6">
                        <!-- Ticket content-->
                        <div class="prose prose-slate prose-a:text-blue-600 hover:prose-a:text-blue-500 max-w-none">
                            {!! $ticket->content !!}
                        </div>
                        <!-- Ticket attachment-->
                        @if($ticket->hasMedia('attachments'))
                            <div class="py-3 xl:pt-6 xl:pb-0">
                                <livewire:attachment-list :model="$ticket" />
                            </div>
                        @endif
                        <!-- Conversation -->
                        <section
                            aria-labelledby="activity-title"
                            class="mt-8 xl:mt-10"
                        >
                            <div>
                                <div class="divide-y divide-slate-200">
                                    <div class="pb-4">
                                        <h2
                                            id="activity-title"
                                            class="text-lg font-medium text-slate-900"
                                        >
                                            {{ __('Conversation') }}
                                        </h2>
                                    </div>
                                    <div class="pt-6">
                                        <!-- Conversation feed-->
                                        <div class="flow-root">
                                            <livewire:ticket-comment-list :ticket="$ticket" />
                                        </div>
                                        <!-- Comment form-->
                                        <div class="mt-6">
                                            <div class="flex space-x-3">
                                                <div class="flex-shrink-0">
                                                    <div class="relative">
                                                        <img
                                                            src="{{ auth()->user()->getFirstMediaUrl('avatar') }}"
                                                            alt="{{ __('Avatar') }}"
                                                            class="w-10 h-10 rounded-full ring-8 ring-white bg-slate-200"
                                                        >
                                                    </div>
                                                </div>
                                                <div class="min-w-0 flex-1">
                                                    @if($ticket->status->value === \App\Enums\TicketStatus::CLOSED->value)
                                                        <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4">
                                                            <div class="flex">
                                                                <div class="flex-shrink-0">
                                                                    <x-heroicon-m-exclamation-triangle class="h-5 w-5 text-yellow-400" />
                                                                </div>
                                                                <div class="ml-3">
                                                                    <h3 class="text-sm font-medium text-yellow-800">
                                                                        {{ __('This ticket is closed') }}
                                                                    </h3>
                                                                    <div class="mt-2 text-sm text-yellow-700">
                                                                        <p>
                                                                            {{ __('You can not comment on a closed ticket.') }}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @elseif($ticket->has_valid_license && !$ticket->has_active_support)
                                                        <div class="bg-red-50 border border-red-200 rounded-md p-4">
                                                            <div class="flex">
                                                                <div class="flex-shrink-0">
                                                                    <x-heroicon-m-x-circle class="h-5 w-5 text-red-400" />
                                                                </div>
                                                                <div class="ml-3">
                                                                    <h3 class="text-sm font-medium text-red-800">
                                                                        {{ __('Support expired') }}
                                                                    </h3>
                                                                    <div class="mt-2 text-sm text-red-700">
                                                                        <p>
                                                                            {{ __('Your license support period has ended, please renew your license to continue.') }}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <livewire:ticket-comment-form :ticket="$ticket" />
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
