<div>
    <!-- Delete Button -->
    <button
        wire:click="open"
        class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300"
    >
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
        </svg>
    </button>

    <!-- Confirmation Modal -->
    <x-confirmation-modal maxWidth="lg" wire:model="showModal" class="relative">
        <x-slot name="title">
            {{ __('Are you sure you want to delete this user?') }}
        </x-slot>

        <x-slot name="content" class="mb-2">
            <p>
                {{ __("This will delete all of the user's information.") }}
            </p>

            <div class="mt-4">
                <p>
                    {{ __('Please type the user\'s name to confirm.') }}
                </p>

                <x-input
                    id="confirm_username"
                    type="text"
                    class="mt-4 block w-[400px]"
                    wire:model.blur="confirm_username"
                    placeholder="{{ $user->username }}"
                />

                <x-input-error for="confirm_username" class="mt-2" />
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button
                wire:click="close"
                wire:loading.attr="disabled"
            >
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-danger-button
                class="ml-3"
                wire:click="delete"
                wire:loading.attr="disabled"
                :disabled="$errors->any() || empty($this->confirm_username)"
            >
                <span wire:loading.remove wire:target="delete">
                    {{ __('Delete') }}
                </span>
                <span wire:loading wire:target="delete">
                    {{ __('Deleting...') }}
                </span>
            </x-danger-button>
        </x-slot>
    </x-confirmation-modal>
</div>
