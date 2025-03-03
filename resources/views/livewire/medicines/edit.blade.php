<div>
    <button wire:click="open" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
        </svg>
    </button>

    <x-dialog-modal wire:model="showModal" maxWidth="2xl">
        <x-slot name="title">
            <div class="border-b dark:border-gray-700 pb-3">
                <h1 class="text-2xl font-bold dark:text-gray-100">Edit Medicine</h1>
            </div>
        </x-slot>

        <x-slot name="content">
            <div class="max-h-[calc(100vh-16rem)] overflow-y-auto pr-2">
                <form wire:submit="save" class="space-y-6">
                    @csrf
                    <!-- Basic Information -->
                    <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded-lg space-y-4">
                        <h3 class="font-semibold text-gray-900 dark:text-gray-100">Basic Information</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-label for="name" value="Medicine Name" class="dark:text-gray-300" />
                                <x-input wire:model.live="form.name" id="name" type="text" class="mt-1 block w-full dark:bg-gray-900 dark:border-gray-600 dark:text-gray-300" placeholder="Enter medicine name" />
                                <x-input-error for="form.name" class="mt-2" />
                            </div>

                            <div>
                                <x-label for="generic_name" value="Generic Name" class="dark:text-gray-300" />
                                <x-input wire:model.live="form.generic_name" id="generic_name" type="text" class="mt-1 block w-full dark:bg-gray-900 dark:border-gray-600 dark:text-gray-300" placeholder="Enter generic name" />
                                <x-input-error for="form.generic_name" class="mt-2" />
                            </div>

                            <div>
                                <x-label for="manufacturer" value="Manufacturer" class="dark:text-gray-300" />
                                <x-input wire:model.live="form.manufacturer" id="manufacturer" type="text" class="mt-1 block w-full dark:bg-gray-900 dark:border-gray-600 dark:text-gray-300" placeholder="Enter manufacturer" />
                                <x-input-error for="form.manufacturer" class="mt-2" />
                            </div>

                            <div>
                                <x-label for="category_id" value="Category" class="dark:text-gray-300" />
                                <select wire:model.live="form.category_id" id="category_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm dark:bg-gray-900 dark:border-gray-600 dark:text-gray-300">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error for="form.category_id" class="mt-2" />
                            </div>
                        </div>

                        <div>
                            <x-label for="description" value="Description" class="dark:text-gray-300" />
                            <textarea wire:model.live="form.description" id="description" rows="3" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm dark:bg-gray-900 dark:border-gray-600 dark:text-gray-300" placeholder="Enter medicine description"></textarea>
                            <x-input-error for="form.description" class="mt-2" />
                        </div>
                    </div>

                    <!-- Tracking Information -->
                    <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded-lg space-y-4">
                        <h3 class="font-semibold text-gray-900 dark:text-gray-100">Tracking Information</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-label for="tracking_number" value="Tracking Number" class="dark:text-gray-300" />
                                <x-input wire:model.live="form.tracking_number" id="tracking_number" type="text" class="mt-1 block w-full dark:bg-gray-900 dark:border-gray-600 dark:text-gray-300" placeholder="Enter tracking number" />
                                <x-input-error for="form.tracking_number" class="mt-2" />
                            </div>

                            <div>
                                <x-label for="source" value="Source" class="dark:text-gray-300" />
                                <x-input wire:model.live="form.source" id="source" type="text" class="mt-1 block w-full dark:bg-gray-900 dark:border-gray-600 dark:text-gray-300" placeholder="Enter source" />
                                <x-input-error for="form.source" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <!-- Dates -->
                    <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded-lg space-y-4">
                        <h3 class="font-semibold text-gray-900 dark:text-gray-100">Important Dates</h3>
                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <x-label for="manufactured_date" value="Manufactured Date" class="dark:text-gray-300" />
                                <x-input wire:model.live="form.manufactured_date" id="manufactured_date" type="date" class="mt-1 block w-full dark:bg-gray-900 dark:border-gray-600 dark:text-gray-300" />
                                <x-input-error for="form.manufactured_date" class="mt-2" />
                            </div>

                            <div>
                                <x-label for="delivery_date" value="Delivery Date" class="dark:text-gray-300" />
                                <x-input wire:model.live="form.delivery_date" id="delivery_date" type="date" class="mt-1 block w-full dark:bg-gray-900 dark:border-gray-600 dark:text-gray-300" />
                                <x-input-error for="form.delivery_date" class="mt-2" />
                            </div>

                            <div>
                                <x-label for="expiry_date" value="Expiry Date" class="dark:text-gray-300" />
                                <x-input wire:model.live="form.expiry_date" id="expiry_date" type="date" class="mt-1 block w-full dark:bg-gray-900 dark:border-gray-600 dark:text-gray-300" />
                                <x-input-error for="form.expiry_date" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <!-- Quantity Information -->
                    <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded-lg space-y-4">
                        <h3 class="font-semibold text-gray-900 dark:text-gray-100">Quantity Information</h3>
                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <x-label for="number_of_boxes" value="Number of Boxes" class="dark:text-gray-300" />
                                <x-input wire:model.live="form.num_of_boxes" id="number_of_boxes" type="number" min="1" class="mt-1 block w-full dark:bg-gray-900 dark:border-gray-600 dark:text-gray-300" placeholder="Enter number of boxes" />
                                <x-input-error for="form.num_of_boxes" class="mt-2" />
                            </div>

                            <div>
                                <x-label for="quantity_per_boxes" value="Quantity per Box" class="dark:text-gray-300" />
                                <x-input wire:model.live="form.qty_per_boxes" id="quantity_per_boxes" type="number" min="1" class="mt-1 block w-full dark:bg-gray-900 dark:border-gray-600 dark:text-gray-300" placeholder="Enter quantity per box" />
                                <x-input-error for="form.qty_per_boxes" class="mt-2" />
                            </div>

                            <div>
                                <x-label for="unit_of_measure" value="Unit of Measure" class="dark:text-gray-300" />
                                <select wire:model.live="form.unit_of_measure" id="unit_of_measure" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm dark:bg-gray-900 dark:border-gray-600 dark:text-gray-300">
                                    <option value="">Select Unit</option>
                                    <option value="tablet">Tablet</option>
                                    <option value="capsule">Capsule</option>
                                    <option value="ml">ml (Milliliter)</option>
                                    <option value="mg">mg (Milligram)</option>
                                    <option value="g">g (Gram)</option>
                                    <option value="oz">oz (Ounce)</option>
                                    <option value="vial">Vial</option>
                                    <option value="ampule">Ampule</option>
                                    <option value="sachet">Sachet</option>
                                    <option value="patch">Patch</option>
                                    <option value="suppository">Suppository</option>
                                    <option value="inhaler">Inhaler</option>
                                </select>
                                <x-input-error for="form.unit_of_measure" class="mt-2" />
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </x-slot>

        <x-slot name="footer">
            <div class="flex justify-end">
                <x-secondary-button wire:click="close" wire:loading.attr="disabled" class="dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700">
                    Cancel
                </x-secondary-button>

                <x-button
                    class="ml-3"
                    color="blue"
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
