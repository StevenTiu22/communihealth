<div>
    <!-- Delete Button -->
    <x-danger-button wire:click="$toggle('showModal')" class="px-2 py-1">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
        </svg>
    </x-danger-button>

    <!-- Confirmation Modal -->
    <x-confirmation-modal wire:model.blur="showModal">
        <x-slot name="title">
            Delete User
        </x-slot>

        <x-slot name="content">
            Are you sure you want to delete this user? This action cannot be undone.
            @if($user)
                <div class="mt-2">
                    <span class="font-medium">User:</span> {{ $user->first_name }} {{ $user->last_name }}
                </div>
            @endif
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="closeModal" wire:loading.attr="disabled">
                Cancel
            </x-secondary-button>

            <x-danger-button class="ml-3" wire:click="deleteUser" wire:loading.attr="disabled">
                Delete User
            </x-danger-button>
        </x-slot>
    </x-confirmation-modal>
</div>
