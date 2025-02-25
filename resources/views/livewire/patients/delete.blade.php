<div>
    <x-danger-button wire:click="openModal">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-1" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
        </svg>
        Delete
    </x-danger-button>

    <x-dialog-modal wire:model.live="showModal" maxWidth="2xl">
        <x-slot name="title">
            <h1 class="text-xl font-semibold">Are you sure you want to delete this patient?</h1>
        </x-slot>

        <x-slot name="content">
            <div class="flex flex-col py-3 w-full">
                <p class="mt-1 text-sm text-gray-600 w-full">
                    Once this patient record is deleted, all of its resources and data will be permanently deleted. 
                    
                </p>
                <p class="mt-1 text-sm text-gray-600 w-full">
                    This includes:
                </p>
                <ul class="list-disc list-inside mt-2 text-sm text-gray-600 ml-4">
                    <li>Patient's personal information</li>
                    <li>Parent/Guardian information</li>
                    <li>Address details</li>
                    <li>Profile photo</li>
                    <li>Medical records and history</li>
                </ul>
                <p class="mt-2 text-sm text-gray-600 font-semibold">
                    This action cannot be undone.
                </p>
            </div>
        </x-slot>

        <x-slot name="footer">
            <div class="flex justify-end gap-3">
                <x-secondary-button wire:click="closeModal" wire:loading.attr="disabled">
                    Cancel
                </x-secondary-button>

                <x-danger-button wire:click="delete" wire:loading.attr="disabled">
                    Delete Patient
                </x-danger-button>
            </div>
        </x-slot>
    </x-dialog-modal>
</div>
