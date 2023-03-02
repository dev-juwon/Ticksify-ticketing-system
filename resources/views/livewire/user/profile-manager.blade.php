<div>
    <x-slot:title>
        {{ __('Profile') }}
    </x-slot:title>

    <x-slot:header>
        <div class="relative py-6 max-w-3xl mx-auto px-4 sm:px-6 lg:max-w-5xl lg:px-8">
            <h1 class="font-display font-medium tracking-tight text-white text-4xl">
                {{ __('Profile') }}
            </h1>
        </div>
    </x-slot:header>

    <div class="-mt-32 relative max-w-3xl mx-auto sm:px-6 lg:max-w-5xl lg:px-8">
        <div class="overflow-hidden rounded-lg bg-white shadow">
            <div class="divide-y divide-slate-200 lg:grid lg:grid-cols-12 lg:divide-y-0 lg:divide-x">
                @include('layouts.navigation-user')

                <div class="lg:col-span-9">
                    <form wire:submit.prevent="save">
                        <div class="pl-4 pr-6 pt-4 pb-4 sm:pl-6 lg:pl-8 xl:pl-6 xl:pt-6">
                            <div>
                                <h1 class="flex-1 font-display text-lg">
                                    {{ __('Profile') }}
                                </h1>
                                <p class="mt-1 text-sm text-slate-500">
                                    {{ __('Manage account information or update your login password.') }}
                                </p>
                            </div>

                            <fieldset
                                wire:loading.attr="disabled"
                                class="mt-6 grid grid-cols-12 gap-6"
                            >
                                <div class="col-span-12 sm:col-span-6">
                                    <x-label
                                        for="name"
                                        :value="__('Your name')"
                                    />
                                    <x-input
                                        wire:model.defer="name"
                                        id="nameInput"
                                        type="text"
                                        class="mt-1"
                                        placeholder="{{ __('Your name') }}"
                                    />
                                    <x-input-error
                                        for="name"
                                        class="mt-2"
                                    />
                                </div>
                                <div class="col-span-12 sm:col-span-6">
                                    <x-label
                                        for="emailInput"
                                        :value="__('Email address')"
                                    />
                                    <x-input
                                        wire:model.defer="email"
                                        id="emailInput"
                                        type="email"
                                        class="mt-1"
                                        placeholder="{{ __('Email address') }}"
                                    />
                                    <x-input-error
                                        for="email"
                                        class="mt-2"
                                    />
                                </div>
                                <div class="col-span-12 sm:col-span-6">
                                    <x-label
                                        for="passwordInput"
                                        :value="__('New password (optional)')"
                                    />
                                    <x-input
                                        wire:model.defer="password"
                                        id="passwordInput"
                                        type="password"
                                        class="mt-1"
                                    />
                                    <x-input-error
                                        for="password"
                                        class="mt-2"
                                    />
                                </div>
                                <div class="col-span-12 sm:col-span-6">
                                    <x-label
                                        for="confirmPasswordInput"
                                        :value="__('Confirm new password')"
                                    />
                                    <x-input
                                        wire:model.defer="password_confirmation"
                                        id="confirmPasswordInput"
                                        type="password"
                                        class="mt-1"
                                    />
                                    <x-input-error
                                        for="password_confirmation"
                                        class="mt-2"
                                    />
                                </div>
                            </fieldset>
                            <div class="mt-6 flex items-center justify-end">
                                <x-action-message
                                    class="mr-3"
                                    on="saved"
                                >
                                    {{ __('Saved.') }}
                                </x-action-message>
                                <x-button.primary>
                                    {{ __('Save changes') }}
                                </x-button.primary>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
