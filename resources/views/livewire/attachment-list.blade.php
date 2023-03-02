<div>
    <h2 class="text-sm font-medium text-slate-500 dark:text-slate-400">
        {{ trans_choice(':count attachment|:count attachments', $model->getMedia('attachments')->count()) }}
    </h2>
    <ul class="mt-1 border border-slate-200 rounded-md divide-y divide-slate-200 dark:border-slate-600 dark:divide-slate-600">
        @foreach($model->getMedia('attachments') as $attachment)
            <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                <div class="w-0 flex-1 flex items-center">
                    <x-heroicon-s-paper-clip class="flex-shrink-0 h-5 w-5 text-slate-400" />
                    <span class="ml-2 flex-1 w-0 truncate dark:text-slate-200">
                        {{ $attachment->name }}
                    </span>
                </div>
                <div class="ml-4 flex-shrink-0">
                    <button
                        wire:click="download('{{ $attachment->id }}')"
                        type="button"
                        class="font-medium text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300"
                    >
                        {{ __('Download') }}
                    </button>
                </div>
            </li>
        @endforeach
    </ul>
</div>
