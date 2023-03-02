<div>
    <ul
        role="list"
        class="-mb-8"
    >
        @if($comments->hasMorePages())
            <div
                wire:loading.remove
                class="flex sm:justify-center pb-5"
            >
                <button
                    wire:click="loadPreviousComments"
                    class="inline-flex items-center text-sm text-blue-600 hover:text-blue-500"
                >
                    {{ __('Load previous comments') }}
                </button>
            </div>
            <div
                wire:loading.delay
                class="w-full"
            >
                <div class="animate-pulse flex space-x-3 pt-4 pb-8">
                    <div class="rounded-full bg-slate-200 h-10 w-10"></div>
                    <div class="flex-1 space-y-3 py-1">
                        <div class="h-2 bg-slate-200 rounded"></div>
                        <div class="space-y-3">
                            <div class="grid grid-cols-3 gap-4">
                                <div class="h-2 bg-slate-200 rounded col-span-1"></div>
                                <div class="h-2 bg-slate-200 rounded col-span-2"></div>
                            </div>
                            <div class="h-2 bg-slate-200 rounded"></div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @forelse($comments->reverse() as $comment)
            <li>
                <div class="relative pb-8">
                    <span
                        class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-slate-200 dark:bg-slate-600"
                        aria-hidden="true"
                    ></span>
                    <div class="relative flex items-start space-x-3">
                        <div class="relative">
                            <img
                                src="{{ $comment->commentator->getFirstMediaUrl('avatar') }}"
                                alt="{{ __('Avatar') }}"
                                @class(['w-10 h-10 rounded-full ring-8 ring-white dark:ring-slate-800', 'bg-white dark:bg-slate-800' => $comment->commentator instanceof \App\Models\Agent, 'bg-slate-200' => $comment->commentator instanceof \App\Models\User])
                            >
                        </div>
                        <div class="min-w-0 flex-1">
                            <div>
                                <div class="text-sm">
                                    <a
                                        href="{{ $comment->commentator instanceof \App\Models\User ? route('agent.users.details', $comment->commentator) : route('agent.agents.details', $comment->commentator) }}"
                                        class="font-medium text-slate-900 dark:text-slate-200"
                                    >
                                        {{ $comment->commentator->name }}
                                    </a>
                                </div>
                                <p class="mt-0.5 text-sm text-slate-500 dark:text-slate-400">
                                    {{ $comment->created_at->diffForHumans() }}
                                    @if($comment->is_private)
                                        <span class="inline-flex items-center rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800">
                                            {{ __('Private') }}
                                        </span>
                                    @endif
                                </p>
                            </div>
                            <div class="mt-2 prose prose-slate prose-a:text-blue-600 hover:prose-a:text-blue-500 sm:prose-sm dark:prose-invert dark:prose-a:text-blue-400 dark:hover:prose-a:text-blue-300">
                                <p>{!! $comment->content !!}</p>
                            </div>
                            @if($comment->hasMedia('attachments'))
                                <div class="mt-2">
                                    <livewire:attachment-list :model="$comment" />
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </li>
        @empty
            <div class="text-center pb-8">
                <x-heroicon-o-chat-bubble-left-right class="mx-auto h-12 w-12 text-slate-400" />
                <h3 class="mt-2 text-sm font-medium text-slate-900 dark:text-slate-200">{{ __('No comments') }}</h3>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">{{ __('Get started by submitting a new comment.') }}</p>
            </div>
        @endforelse
    </ul>
</div>
