<div>
    <x-button wire:click="openModal" class="flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
        </svg>
        Add Category
    </x-button>

    <x-dialog-modal wire:model.live="showModal">
        <x-slot name="title">
            Add New Medicine Category
        </x-slot>

        <x-slot name="content">
            <div class="space-y-4">
                <div>
                    <x-label for="name" value="Category Name" />
                    <x-input
                        wire:model.live="name"
                        id="name"
                        type="text"
                        class="mt-1 block w-full"
                        placeholder="Enter category name"
                    />
                    <x-input-error for="name" class="mt-2" />
                </div>

                <!-- Helper text -->
                <div class="text-sm text-gray-500">
                    <p>Guidelines for category name:</p>
                    <ul class="list-disc list-inside ml-4 mt-1">
                        <li>Must be at least 3 characters long</li>
                        <li>Can only contain letters, spaces, and hyphens</li>
                        <li>Must be unique</li>
                    </ul>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <div class="flex justify-end gap-4">
                <x-secondary-button wire:click="closeModal" wire:loading.attr="disabled">
                    Cancel
                </x-secondary-button>

                <x-button class="ml-3" wire:click="save" wire:loading.attr="disabled">
                    <span wire:loading.remove>Save Category</span>
                    <span wire:loading>Saving...</span>
                </x-button>
            </div>
        </x-slot>
    </x-dialog-modal>
</div>
