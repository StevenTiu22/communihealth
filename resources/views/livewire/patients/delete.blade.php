<div>
    <button
        wire:click="open"
        class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300"
    >
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
        </svg>
    </button>

    <x-dialog-modal wire:model.live="showModal" maxWidth="2xl">
        <x-slot name="title">
            <h1 class="text-xl font-semibold">Are you sure you want to delete this patient?</h1>
        </x-slot>

        <x-slot name="content">
            <div class="flex flex-col py-3 w-full">
                <p class="mt-1 text-sm text-white w-full">
                    Once this patient record is deleted, all of its resources and data will be permanently deleted.

                </p>
                <p class="mt-1 text-sm text-white w-full">
                    This includes:
                </p>
                <ul class="list-disc list-inside mt-2 text-sm text-white ml-4">
                    <li>Patient's personal information</li>
                    <li>Parent/Guardian information</li>
                    <li>Address details</li>
                    <li>Profile photo</li>
                    <li>Medical records and history</li>
                </ul>
                <p class="mt-2 text-sm text-white font-semibold">
                    This action cannot be undone.
                </p>

                <div class="mt-2">
                    <p class="text-sm text-white font-semibold">{{__("Enter the patient's last name to confirm:")}}</p>

                    <x-input id="confirm_name" type="text" class="mt-3 block w-full"
                        wire:model.defer="confirm_name"
                        placeholder="{{ ucwords($patient->last_name) }}"
                    />

                    <x-input-error for="confirm_name" class="mt-2" />
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <div class="flex justify-end gap-3">
                <x-secondary-button wire:click="close" wire:loading.attr="disabled">
                    Cancel
                </x-secondary-button>

                <x-danger-button wire:click="delete" wire:loading.attr="disabled">
                    Delete Patient
                </x-danger-button>
            </div>
        </x-slot>
    </x-dialog-modal>
</div>
