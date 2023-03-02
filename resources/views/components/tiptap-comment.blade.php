<div
    wire:ignore
    x-data="setupEditor(@entangle($attributes->wire('model')).defer)"
    x-init="() => init($refs.element)"
    x-on:click="focus()"
    x-on:comment-submitted.window="clearContent()"
    {{ $attributes->whereDoesntStartWith('wire:model') }}
    class="group border border-slate-300 p-2 rounded-md dark:border-slate-600"
>
    {{-- Toolbar --}}
    <div>
        {{--Bold--}}
        <button
            type="button"
            @click="toggleBold()"
            class="inline-flex items-center justify-center p-2 rounded-md border border-slate-200"
            :class="{ 'bg-blue-600 text-white border-blue-600 hover:bg-blue-700 hover:border-blue-700 dark:hover:bg-blue-500 dark:hover:border-blue-500': isActive('bold', updatedAt), 'hover:bg-slate-100 hover:bg-slate-100 dark:border-slate-600 dark:text-slate-400 dark:hover:bg-slate-600 dark:hover:text-slate-200': !isActive('bold', updatedAt) }"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                width="24"
                height="24"
                class="h-3.5 w-3.5 fill-current"
            >
                <path
                    fill="none"
                    d="M0 0h24v24H0z"
                />
                <path d="M8 11h4.5a2.5 2.5 0 1 0 0-5H8v5zm10 4.5a4.5 4.5 0 0 1-4.5 4.5H6V4h6.5a4.5 4.5 0 0 1 3.256 7.606A4.498 4.498 0 0 1 18 15.5zM8 13v5h5.5a2.5 2.5 0 1 0 0-5H8z" />
            </svg>
            <span class="sr-only">{{ __('bold') }}</span>
        </button>
        {{--Italic--}}
        <button
            type="button"
            @click="toggleItalic()"
            class="inline-flex items-center justify-center p-2 rounded-md border border-slate-200"
            :class="{ 'bg-blue-600 text-white border-blue-600 hover:bg-blue-700 hover:border-blue-700 dark:hover:bg-blue-500 dark:hover:border-blue-500': isActive('italic', updatedAt), 'hover:bg-slate-100 hover:bg-slate-100 dark:border-slate-600 dark:text-slate-400 dark:hover:bg-slate-600 dark:hover:text-slate-200': !isActive('italic', updatedAt) }"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                width="24"
                height="24"
                class="h-3.5 w-3.5 fill-current"
            >
                <path
                    fill="none"
                    d="M0 0h24v24H0z"
                />
                <path d="M15 20H7v-2h2.927l2.116-12H9V4h8v2h-2.927l-2.116 12H15z" />
            </svg>
            <span class="sr-only">{{ __('italic') }}</span>
        </button>
        {{--Underline--}}
        <button
            type="button"
            @click="toggleUnderline()"
            class="inline-flex items-center justify-center p-2 rounded-md border border-slate-200"
            :class="{ 'bg-blue-600 text-white border-blue-600 hover:bg-blue-700 hover:border-blue-700 dark:hover:bg-blue-500 dark:hover:border-blue-500': isActive('underline', updatedAt), 'hover:bg-slate-100 hover:bg-slate-100 dark:border-slate-600 dark:text-slate-400 dark:hover:bg-slate-600 dark:hover:text-slate-200': !isActive('underline', updatedAt) }"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                width="24"
                height="24"
                class="h-3.5 w-3.5 fill-current"
            >
                <path
                    fill="none"
                    d="M0 0h24v24H0z"
                />
                <path d="M8 3v9a4 4 0 1 0 8 0V3h2v9a6 6 0 1 1-12 0V3h2zM4 20h16v2H4v-2z" />
            </svg>
            <span class="sr-only">{{ __('underline') }}</span>
        </button>
        {{--Bullet list--}}
        <button
            type="button"
            @click="toggleBulletList()"
            class="inline-flex items-center justify-center p-2 rounded-md border border-slate-200"
            :class="{ 'bg-blue-600 text-white border-blue-600 hover:bg-blue-700 hover:border-blue-700 dark:hover:bg-blue-500 dark:hover:border-blue-500': isActive('bulletList', updatedAt), 'hover:bg-slate-100 hover:bg-slate-100 dark:border-slate-600 dark:text-slate-400 dark:hover:bg-slate-600 dark:hover:text-slate-200': !isActive('bulletList', updatedAt) }"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                width="24"
                height="24"
                class="h-3.5 w-3.5 fill-current"
            >
                <path
                    fill="none"
                    d="M0 0h24v24H0z"
                />
                <path d="M8 4h13v2H8V4zM4.5 6.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm0 7a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm0 6.9a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zM8 11h13v2H8v-2zm0 7h13v2H8v-2z" />
            </svg>
            <span class="sr-only">{{ __('bullet list') }}</span>
        </button>
        {{--Ordered list--}}
        <button
            type="button"
            @click="toggleOrderedList()"
            class="inline-flex items-center justify-center p-2 rounded-md border border-slate-200"
            :class="{ 'bg-blue-600 text-white border-blue-600 hover:bg-blue-700 hover:border-blue-700 dark:hover:bg-blue-500 dark:hover:border-blue-500': isActive('orderedList', updatedAt), 'hover:bg-slate-100 hover:bg-slate-100 dark:border-slate-600 dark:text-slate-400 dark:hover:bg-slate-600 dark:hover:text-slate-200': !isActive('orderedList', updatedAt) }"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                width="24"
                height="24"
                class="h-3.5 w-3.5 fill-current"
            >
                <path
                    fill="none"
                    d="M0 0h24v24H0z"
                />
                <path d="M8 4h13v2H8V4zM5 3v3h1v1H3V6h1V4H3V3h2zM3 14v-2.5h2V11H3v-1h3v2.5H4v.5h2v1H3zm2 5.5H3v-1h2V18H3v-1h3v4H3v-1h2v-.5zM8 11h13v2H8v-2zm0 7h13v2H8v-2z" />
            </svg>
            <span class="sr-only">{{ __('ordered list') }}</span>
        </button>
        {{--Link--}}
        <button
            type="button"
            @click="toggleLink()"
            class="inline-flex items-center justify-center p-2 rounded-md border border-slate-200"
            :class="{ 'bg-blue-600 text-white border-blue-600 hover:bg-blue-700 hover:border-blue-700 dark:hover:bg-blue-500 dark:hover:border-blue-500': isActive('link', updatedAt), 'hover:bg-slate-100 hover:bg-slate-100 dark:border-slate-600 dark:text-slate-400 dark:hover:bg-slate-600 dark:hover:text-slate-200': !isActive('link', updatedAt) }"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                width="24"
                height="24"
                class="h-3.5 w-3.5 fill-current"
            >
                <path
                    fill="none"
                    d="M0 0h24v24H0z"
                />
                <path d="M18.364 15.536L16.95 14.12l1.414-1.414a5 5 0 1 0-7.071-7.071L9.879 7.05 8.464 5.636 9.88 4.222a7 7 0 0 1 9.9 9.9l-1.415 1.414zm-2.828 2.828l-1.415 1.414a7 7 0 0 1-9.9-9.9l1.415-1.414L7.05 9.88l-1.414 1.414a5 5 0 1 0 7.071 7.071l1.414-1.414 1.415 1.414zm-.708-10.607l1.415 1.415-7.071 7.07-1.415-1.414 7.071-7.07z" />
            </svg>
            <span class="sr-only">{{ __('link') }}</span>
        </button>
        {{--Quote--}}
        <button
            type="button"
            @click="toggleBlockquote()"
            class="inline-flex items-center justify-center p-2 rounded-md border border-slate-200"
            :class="{ 'bg-blue-600 text-white border-blue-600 hover:bg-blue-700 hover:border-blue-700 dark:hover:bg-blue-500 dark:hover:border-blue-500': isActive('blockquote', updatedAt), 'hover:bg-slate-100 hover:bg-slate-100 dark:border-slate-600 dark:text-slate-400 dark:hover:bg-slate-600 dark:hover:text-slate-200': !isActive('blockquote', updatedAt) }"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                width="24"
                height="24"
                class="h-3.5 w-3.5 fill-current"
            >
                <path
                    fill="none"
                    d="M0 0h24v24H0z"
                />
                <path d="M4.583 17.321C3.553 16.227 3 15 3 13.011c0-3.5 2.457-6.637 6.03-8.188l.893 1.378c-3.335 1.804-3.987 4.145-4.247 5.621.537-.278 1.24-.375 1.929-.311 1.804.167 3.226 1.648 3.226 3.489a3.5 3.5 0 0 1-3.5 3.5c-1.073 0-2.099-.49-2.748-1.179zm10 0C13.553 16.227 13 15 13 13.011c0-3.5 2.457-6.637 6.03-8.188l.893 1.378c-3.335 1.804-3.987 4.145-4.247 5.621.537-.278 1.24-.375 1.929-.311 1.804.167 3.226 1.648 3.226 3.489a3.5 3.5 0 0 1-3.5 3.5c-1.073 0-2.099-.49-2.748-1.179z" />
            </svg>
            <span class="sr-only">{{ __('blockquote') }}</span>
        </button>
        {{--Horizontal rule--}}
        <button
            type="button"
            @click="setHorizontalRule()"
            class="inline-flex items-center justify-center p-2 rounded-md border hover:bg-slate-100 hover:bg-slate-100 dark:border-slate-600 dark:text-slate-400 dark:hover:bg-slate-600 dark:hover:text-slate-200"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                width="24"
                height="24"
                class="h-3.5 w-3.5 fill-current"
            >
                <path
                    fill="none"
                    d="M0 0h24v24H0z"
                />
                <path d="M2 11h2v2H2v-2zm4 0h12v2H6v-2zm14 0h2v2h-2v-2z" />
            </svg>
            <span class="sr-only">{{ __('horizontal rule') }}</span>
        </button>
    </div>
    {{-- Content --}}
    <div
        x-ref="element"
        class="prose prose-slate prose-a:text-blue-600 hover:prose-a:text-blue-500 sm:prose-sm max-w-none dark:prose-invert dark:prose-a:text-blue-400 dark:hover:prose-a:text-blue-300"
    ></div>
    {{ $slot }}
</div>
