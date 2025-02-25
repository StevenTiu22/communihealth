<div>
    <button wire:click="openModal" class="text-blue-600 hover:text-blue-900" aria-label="Edit medicine">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
        </svg>
    </button>

    <x-dialog-modal wire:model="showModal" maxWidth="2xl">
        <x-slot name="title">
            <div class="border-b pb-3">
                <h1 class="text-2xl font-bold">Edit Medicine</h1>
            </div>
        </x-slot>

        <x-slot name="content">
            <div class="max-h-[calc(100vh-16rem)] overflow-y-auto pr-2">
                <form wire:submit="save" class="space-y-6">
                    @csrf
                    <!-- Basic Information -->
                    <div class="bg-gray-50 p-4 rounded-lg space-y-4">
                        <h3 class="font-semibold text-gray-900">Basic Information</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-label for="name" value="Medicine Name" />
                                <x-input wire:model.live="name" id="name" type="text" class="mt-1 block w-full" placeholder="Enter medicine name" />
                                @error('name')
                                    <x-input-error for="name" class="mt-2" />
                                @enderror
                            </div>

                            <div>
                                <x-label for="generic_name" value="Generic Name" />
                                <x-input wire:model.live="generic_name" id="generic_name" type="text" class="mt-1 block w-full" placeholder="Enter generic name" />
                                @error('generic_name')
                                    <x-input-error for="generic_name" class="mt-2" />
                                @enderror
                            </div>

                            <div>
                                <x-label for="manufacturer" value="Manufacturer" />
                                <x-input wire:model.live="manufacturer" id="manufacturer" type="text" class="mt-1 block w-full" placeholder="Enter manufacturer" />
                                @error('manufacturer')
                                    <x-input-error for="manufacturer" class="mt-2" />
                                @enderror
                            </div>

                            <div>
                                <x-label for="category_id" value="Category" />
                                <select wire:model.live="category_id" id="category_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <x-input-error for="category_id" class="mt-2" />
                                @enderror
                            </div>
                        </div>

                        <div>
                            <x-label for="description" value="Description" />
                            <textarea wire:model.live="description" id="description" rows="3" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Enter medicine description"></textarea>
                            @error('description')
                                <x-input-error for="description" class="mt-2" />
                            @enderror
                        </div>
                    </div>

                    <!-- Tracking Information -->
                    <div class="bg-gray-50 p-4 rounded-lg space-y-4">
                        <h3 class="font-semibold text-gray-900">Tracking Information</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-label for="tracking_number" value="Tracking Number" />
                                <x-input wire:model.live="tracking_number" id="tracking_number" type="text" class="mt-1 block w-full" placeholder="Enter tracking number" />
                                @error('tracking_number')
                                    <x-input-error for="tracking_number" class="mt-2" />
                                @enderror
                            </div>

                            <div>
                                <x-label for="source" value="Source" />
                                <x-input wire:model.live="source" id="source" type="text" class="mt-1 block w-full" placeholder="Enter source" />
                                @error('source')
                                    <x-input-error for="source" class="mt-2" />
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Dates -->
                    <div class="bg-gray-50 p-4 rounded-lg space-y-4">
                        <h3 class="font-semibold text-gray-900">Important Dates</h3>
                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <x-label for="manufactured_date" value="Manufactured Date" />
                                <x-input wire:model.live="manufactured_date" id="manufactured_date" type="date" class="mt-1 block w-full" />
                                @error('manufactured_date')
                                    <x-input-error for="manufactured_date" class="mt-2" />
                                @enderror
                            </div>

                            <div>
                                <x-label for="delivery_date" value="Delivery Date" />
                                <x-input wire:model.live="delivery_date" id="delivery_date" type="date" class="mt-1 block w-full" />
                                @error('delivery_date')
                                    <x-input-error for="delivery_date" class="mt-2" />
                                @enderror
                            </div>

                            <div>
                                <x-label for="expiry_date" value="Expiry Date" />
                                <x-input wire:model.live="expiry_date" id="expiry_date" type="date" class="mt-1 block w-full" />
                                @error('expiry_date')
                                    <x-input-error for="expiry_date" class="mt-2" />
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Quantity Information -->
                    <div class="bg-gray-50 p-4 rounded-lg space-y-4">
                        <h3 class="font-semibold text-gray-900">Quantity Information</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-label for="number_of_boxes" value="Number of Boxes" />
                                <x-input wire:model.live="number_of_boxes" id="number_of_boxes" type="number" min="1" class="mt-1 block w-full" placeholder="Enter number of boxes" />
                                @error('number_of_boxes')
                                    <x-input-error for="number_of_boxes" class="mt-2" />
                                @enderror
                            </div>

                            <div>
                                <x-label for="quantity_per_boxes" value="Quantity per Box" />
                                <x-input wire:model.live="quantity_per_boxes" id="quantity_per_boxes" type="number" min="1" class="mt-1 block w-full" placeholder="Enter quantity per box" />
                                @error('quantity_per_boxes')
                                    <x-input-error for="quantity_per_boxes" class="mt-2" />
                                @enderror
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </x-slot>

        <x-slot name="footer">
            <div class="flex justify-end gap-4">
                <x-secondary-button wire:click="closeModal" wire:loading.attr="disabled">
                    Cancel
                </x-secondary-button>

                <x-button 
                    class="ml-3" 
                    wire:click="save" 
                    wire:loading.attr="disabled"
                    wire:target="save"
                >
                    <span wire:loading.remove wire:target="save">Update Medicine</span>
                    <span wire:loading wire:target="save">Updating...</span>
                </x-button>
            </div>
        </x-slot>
    </x-dialog-modal>
</div> 