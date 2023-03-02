<div>
    <div class="max-w-3xl mx-auto px-4 sm:px-6 md:flex md:items-center md:justify-between lg:px-8">
        <h1 class="font-display text-3xl text-slate-900 dark:text-slate-200">
            {{ __('Article details') }}
        </h1>
        <div class="justify-stretch mt-6 flex flex-shrink-0 flex-col-reverse space-y-4 space-y-reverse sm:flex-row-reverse sm:justify-end sm:space-y-0 sm:space-x-3 sm:space-x-reverse md:mt-0 md:flex-row md:space-x-3">
            <x-button.secondary
                wire:click="$set('showSettings', true)"
                type="button"
            >
                {{ __('Settings') }}
            </x-button.secondary>
            <x-button.primary
                wire:click="save"
                type="button"
            >
                {{ __('Save') }}
            </x-button.primary>
        </div>
    </div>

    <div class="mt-6 max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="pt-8 border-t border-slate-200 space-y-4 dark:border-slate-600">
            @if ($errors->any())
                <div class="rounded-md bg-red-50 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <x-heroicon-s-x-circle class="w-5 h-5 text-red-400" />
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">
                                {{ trans_choice('There were :count error with your submission|There were :count errors with your submission', $errors->count()) }}
                            </h3>
                            <div class="mt-2 text-sm text-red-700">
                                <ul
                                    role="list"
                                    class="list-disc pl-5 space-y-1"
                                >
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div x-data="{ content: @entangle('article.title')}">
                <div
                    x-on:blur="content = $event.target.innerHTML"
                    contenteditable="true"
                    class="block w-full border-0 border-b border-dotted border-transparent font-display font-medium text-5xl text-center p-0 focus:border-blue-600 focus:outline-none dark:bg-transparent dark:placeholder-slate-400 dark:text-slate-200 dark:focus:border-blue-400 dark:focus:placeholder-slate-500"
                >
                    {{ $article->title }}
                </div>
            </div>
            <div class="pt-4">
                <x-tiptap wire:model.defer="article.content" />
            </div>
        </div>
    </div>

    <x-slide-over-panel wire:model.defer="showSettings">
        <x-slot:title>
            {{ __('Article settings') }}
        </x-slot:title>
        <x-slot:content>
            <div class="divide-y divide-slate-200 dark:divide-slate-600">
                <div class="space-y-6">
                    <div>
                        <x-label
                            for="article.slug"
                            :value="__('Slug')"
                        />
                        <x-input
                            wire:model.defer="article.slug"
                            type="text"
                            class="mt-1"
                            :placeholder="__('article-permalink')"
                        />
                        <x-input-error
                            for="article.slug"
                            class="mt-2"
                        />
                    </div>
                    <div>
                        <x-label
                            for="article.excerpt"
                            :value="__('Excerpt')"
                        />
                        <x-textarea
                            wire:model.defer="article.excerpt"
                            class="mt-1"
                            :placeholder="__('Write something to describe your article')"
                        />
                        <x-input-error
                            for="article.excerpt"
                            class="mt-2"
                        />
                    </div>
                    <div>
                        <x-label
                            for="article.collection_id"
                            :value="__('Collection')"
                        />
                        <x-select
                            wire:model.defer="article.collection_id"
                            class="mt-1"
                        >
                            <option value="">{{ __('None') }}</option>
                            @foreach ($this->collections as $collection)
                                <option value="{{ $collection->id }}">
                                    {{ $collection->name }}
                                </option>
                            @endforeach
                        </x-select>
                        <x-input-error
                            for="article.collection_id"
                            class="mt-2"
                        />
                    </div>
                    <div>
                        <x-label
                            for="article.seo_title"
                            :value="__('SEO title')"
                        />
                        <x-input
                            wire:model.defer="article.seo_title"
                            type="text"
                            class="mt-1"
                            :placeholder="__('SEO title')"
                        />
                        <x-input-error
                            for="article.seo_title"
                            class="mt-2"
                        />
                    </div>
                    <div>
                        <x-label
                            for="article.seo_description"
                            :value="__('SEO description')"
                        />
                        <x-textarea
                            wire:model.defer="article.seo_description"
                            class="mt-1"
                            :placeholder="__('SEO description')"
                        />
                        <x-input-error
                            for="article.seo_description"
                            class="mt-2"
                        />
                    </div>
                </div>
                <div
                    x-data="{ confirmingArticleDeletion: false }"
                    class="mt-6 pt-6"
                >
                    <div
                        x-cloak
                        x-show="confirmingArticleDeletion"
                        class="flex items-center justify-between space-x-2"
                    >
                        <x-button.secondary
                            x-on:click="confirmingArticleDeletion = false"
                            class="w-full"
                        >
                            {{ __('Cancel') }}
                        </x-button.secondary>
                        <x-button.danger
                            wire:click="delete"
                            class="w-full"
                        >
                            {{ __('Delete') }}
                        </x-button.danger>
                    </div>
                    <div x-show="!confirmingArticleDeletion">
                        <x-button.soft-danger
                            x-on:click="confirmingArticleDeletion = true"
                            class="w-full"
                        >
                            {{ __('Delete article') }}
                        </x-button.soft-danger>
                    </div>
                </div>
            </div>
        </x-slot:content>
        <x-slot:footer>
            <x-button.text
                wire:click="$set('showSettings', false)"
                type="button"
            >
                {{ __('Cancel') }}
            </x-button.text>
            <x-button.primary
                wire:click="save"
                type="button"
                class="ml-4"
            >
                {{ __('Save') }}
            </x-button.primary>
        </x-slot:footer>
    </x-slide-over-panel>

    <div
        x-data="{ addFromURL: false, selectedImage: null }"
        x-on:upload-image-success.window="addFromURL = false; selectedImage = $event.detail.imageId; console.log($event.detail.imageId)"
    >
        <x-dialog-modal wire:model.defer="showImageModal">
            <x-slot:title>
                {{ __('Media') }}
            </x-slot:title>
            <x-slot:content>
                <div
                    x-show="!addFromURL"
                    x-transition:enter.duration.150ms
                    x-transition:leave.duration.50ms
                >
                    <div class="inline-flex rounded-md">
                        <button
                            x-on:click="$refs.imageInput.click()"
                            type="button"
                            class="relative inline-flex items-center rounded-l-md border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50 focus:z-10 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:bg-slate-700 dark:border-slate-500 dark:text-slate-200 dark:focus:ring-blue-400 dark:focus:border-blue-400 dark:hover:border-slate-400 dark:focus:ring-offset-slate-800"
                        >
                            <x-heroicon-m-photo class="-ml-1 mr-2 w-5 h-5" />
                            {{ __('Add new') }}
                        </button>
                        <div class="relative -ml-px block">
                            <x-dropdown align="left">
                                <x-slot:trigger>
                                    <button
                                        type="button"
                                        class="relative inline-flex items-center rounded-r-md border border-slate-300 bg-white px-2 py-2 text-sm font-medium text-slate-500 hover:bg-slate-50 focus:z-10 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:bg-slate-700 dark:border-slate-500 dark:text-slate-200 dark:focus:ring-blue-400 dark:focus:border-blue-400 dark:hover:border-slate-400 dark:focus:ring-offset-slate-800"
                                    >
                                        <span class="sr-only">
                                            {{ __('Open options') }}
                                        </span>
                                        <x-heroicon-m-chevron-down class="h-5 w-5" />
                                    </button>
                                </x-slot:trigger>
                                <x-slot:content>
                                    <x-dropdown-link
                                        x-on:click="addFromURL = !addFromURL"
                                        role="button"
                                    >
                                        {{ __('Add from URL') }}
                                    </x-dropdown-link>
                                </x-slot:content>
                            </x-dropdown>
                        </div>
                        <x-button.soft-danger
                            x-show="selectedImage"
                            x-on:click="confirm('{{ __('Are you sure you want to delete this image?') }}') || event.stopImmediatePropagation(); $wire.deleteImage(selectedImage); selectedImage = null"
                            type="button"
                            class="ml-4"
                        >
                            <x-heroicon-m-trash class="h-5 w-5" />
                        </x-button.soft-danger>
                    </div>
                    <x-input
                        wire:model.defer="image"
                        x-ref="imageInput"
                        type="file"
                        class="hidden"
                    />
                </div>
                <div
                    x-show="addFromURL"
                    x-transition:enter.duration.150ms
                    x-transition:leave.duration.50ms
                >
                    <form wire:submit.prevent="uploadImageFromURL">
                        <fieldset wire:loading.attr="disabled">
                            <label
                                for="imageUrl"
                                class="sr-only"
                            >
                                {{ __('Image URL') }}
                            </label>
                            <div class="flex items-center">
                                <div class="flex flex-1 rounded-md">
                                    <div class="relative flex flex-grow items-stretch focus-within:z-10">
                                        <input
                                            wire:model.defer="imageUrl"
                                            type="text"
                                            id="imageUrl"
                                            class="block w-full rounded-none rounded-l-md border-slate-300 focus:border-blue-500 focus:ring-blue-500 sm:text-sm disabled:opacity-25 disabled:cursor-not-allowed transition"
                                            placeholder="https://"
                                        >
                                    </div>
                                    <button
                                        type="submit"
                                        class="relative -ml-px inline-flex items-center space-x-2 rounded-r-md border border-slate-300 bg-slate-50 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 disabled:opacity-25 disabled:cursor-not-allowed transition"
                                    >
                                        <x-heroicon-m-arrow-up-tray class="h-5 w-5 text-slate-400" />
                                        <span>{{ __('Upload') }}</span>
                                    </button>
                                </div>
                                <button
                                    x-on:click="addFromURL = false"
                                    type="button"
                                    class="ml-3 inline-flex items-center py-2"
                                >
                                    <x-heroicon-m-x-mark class="w-5 h-5" />
                                </button>
                            </div>
                            <x-input-error
                                for="imageUrl"
                                class="mt-2"
                            />
                        </fieldset>
                    </form>
                </div>
                <ul class="mt-8 grid grid-cols-2 gap-x-4 gap-y-8 sm:grid-cols-3 sm:gap-x-6 md:grid-cols-4 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8">
                    <li
                        wire:target="image, imageUrl"
                        wire:loading
                        class="relative"
                    >
                        <div class="block w-full aspect-w-10 aspect-h-7 rounded-lg bg-slate-100 overflow-hidden">
                            <x-loading-spinner class="absolute inset-0 m-auto w-5 h-5" />
                        </div>
                    </li>
                    @foreach ($this->article->getMedia('images')->reverse() as $media)
                        <li class="relative">
                            <div
                                class="group block w-full aspect-w-10 aspect-h-7 rounded-lg bg-slate-100 overflow-hidden"
                                :class="{ 'ring-2 ring-offset-2 ring-blue-500 dark:ring-offset-slate-800': selectedImage === {{ $media->id }} }"
                            >
                                <img
                                    src="{{ $media->getUrl() }}"
                                    alt="{{ $media->name }}"
                                    class="object-cover pointer-events-none"
                                    :class="{ 'group-hover:opacity-75': selectedImage !== {{ $media->id }} }"
                                >
                                <button
                                    x-on:click="selectedImage = {{ $media->id }}"
                                    class="absolute inset-0 focus:outline-none"
                                >
                                    <span class="sr-only">
                                        {{ __('Select this image') }}
                                    </span>
                                </button>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </x-slot:content>
            <x-slot:footer>
                <div>
                    <x-button.secondary
                        x-on:click="$wire.set('showImageModal', false)"
                        type="button"
                    >
                        {{ __('Cancel') }}
                    </x-button.secondary>
                    <x-button.primary
                        x-bind:disabled="!selectedImage"
                        x-on:click="$wire.insertImage(selectedImage); selectedImage = null"
                        type="button"
                    >
                        {{ __('Insert') }}
                    </x-button.primary>
                </div>
            </x-slot:footer>
        </x-dialog-modal>
    </div>
</div>
