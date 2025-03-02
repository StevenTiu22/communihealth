<div>
    <button 
        wire:click="openModal" 
        class="text-red-600 hover:text-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 rounded-md p-1"
        title="Delete Medicine"
    >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
        </svg>
    </button>

    <x-dialog-modal wire:model="showModal">
        <x-slot name="title">
            <div class="flex items-center justify-between border-b pb-4">
                <h2 class="text-xl font-semibold text-red-600">Delete Medicine</h2>
            </div>
        </x-slot>

        <x-slot name="content">
            <div class="space-y-4">
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                                This action cannot be undone. The medicine will be removed from the inventory.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 p-4 rounded-md">
                    <dl class="space-y-2">
                        <div class="flex justify-between">
                            <dt class="text-sm font-medium text-gray-500">Medicine Name:</dt>
                            <dd class="text-sm text-gray-900">{{ $medicine->name }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm font-medium text-gray-500">Category:</dt>
                            <dd class="text-sm text-gray-900">{{ $medicine->category->name }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm font-medium text-gray-500">Current Stock:</dt>
                            <dd class="text-sm text-gray-900">{{ $medicine->current_stock }}</dd>
                        </div>
                    </dl>
                </div>

                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700">
                        Please type <span class="font-semibold">{{ $medicine->name }}</span> to confirm deletion
                    </label>
                    <input 
                        type="text" 
                        wire:model="confirmationName"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm"
                        placeholder="Enter medicine name"
                    >
                    @error('confirmationName') 
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <div class="flex justify-end space-x-3">
                <x-secondary-button wire:click="closeModal" wire:loading.attr="disabled">
                    Cancel
                </x-secondary-button>

                <x-danger-button 
                    wire:click="delete" 
                    wire:loading.attr="disabled"
                    class="px-4 py-2"
                >
                    <span wire:loading.remove wire:target="delete">Delete Medicine</span>
                    <span wire:loading wire:target="delete">Deleting...</span>
                </x-danger-button>
            </div>
        </x-slot>
    </x-dialog-modal>
</div> 