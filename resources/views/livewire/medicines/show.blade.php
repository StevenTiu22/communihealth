<div>
    <button wire:click="open" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300" aria-label="View medicine details">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
        </svg>
    </button>

    <x-dialog-modal wire:model="showModal" maxWidth="2xl">
        <x-slot name="title">
            <div class="flex items-center justify-between border-b dark:border-gray-700 pb-3">
                <h1 class="text-2xl font-bold dark:text-gray-100">Medicine Details</h1>
                <div class="flex items-center gap-2">
                    <!-- Stock Status -->
                    <span class="px-3 py-1 text-sm rounded-full {{-- $this->stockStatus['classes'] --}}">
                        {{-- $this->stockStatus['label'] --}}
                    </span>
                    <!-- Expiry Status -->
                    <span class="px-3 py-1 text-sm rounded-full {{-- $this->expiryStatus['classes'] --}}">
                        {{-- $this->expiryStatus['label'] --}}
                    </span>
                </div>
            </div>
        </x-slot>

        <x-slot name="content">
            <div class="max-h-[calc(100vh-16rem)] overflow-y-auto pr-2 space-y-6">
                <!-- Basic Information -->
                <div class="space-y-4">
                    <h2 class="text-lg font-semibold border-b pb-2 text-gray-700 dark:text-gray-300 dark:border-gray-700">Basic Information</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-label value="Medicine Name" class="font-medium dark:text-gray-400" />
                            <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $medicine->name }}</p>
                        </div>
                        <div>
                            <x-label value="Generic Name" class="font-medium dark:text-gray-400" />
                            <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $medicine->generic_name }}</p>
                        </div>
                        <div>
                            <x-label value="Manufacturer" class="font-medium dark:text-gray-400" />
                            <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $medicine->manufacturer }}</p>
                        </div>
                        <div>
                            <x-label value="Category" class="font-medium dark:text-gray-400" />
                            <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $medicine->category->name }}</p>
                        </div>
                    </div>
                    <div>
                        <x-label value="Description" class="font-medium dark:text-gray-400" />
                        <p class="mt-1 text-gray-900 dark:text-gray-100 whitespace-pre-wrap break-words">{{ $medicine->description }}</p>
                    </div>
                </div>

                <!-- Tracking Information -->
                <div class="space-y-4">
                    <h2 class="text-lg font-semibold border-b pb-2 text-gray-700 dark:text-gray-300 dark:border-gray-700">Tracking Information</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-label value="Tracking Number" class="font-medium dark:text-gray-400" />
                            <p class="mt-1 text-gray-900 dark:text-gray-100 font-mono">{{ $medicine->tracking_number }}</p>
                        </div>
                        <div>
                            <x-label value="Source" class="font-medium dark:text-gray-400" />
                            <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $medicine->source }}</p>
                        </div>
                    </div>
                </div>

                <!-- Stock Information -->
                <div class="space-y-4">
                    <h2 class="text-lg font-semibold border-b pb-2 text-gray-700 dark:text-gray-300 dark:border-gray-700">Stock Information</h2>
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <x-label value="Number of Boxes" class="font-medium dark:text-gray-400" />
                            <p class="mt-1 text-gray-900 dark:text-gray-100">{{ number_format($medicine->num_of_boxes) }}</p>
                        </div>
                        <div>
                            <x-label value="Quantity per Box" class="font-medium dark:text-gray-400" />
                            <p class="mt-1 text-gray-900 dark:text-gray-100">{{ number_format($medicine->qty_per_boxes) }}</p>
                        </div>
                        <div>
                            <x-label value="Unit of Measure" class="font-medium dark:text-gray-400" />
                            <p class="mt-1 text-gray-900 dark:text-gray-100">{{ ucfirst($medicine->unit_of_measure ?? 'N/A') }}</p>
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <x-label value="Current Stock" class="font-medium dark:text-gray-400" />
                                @if($medicine->stock_level <= 100)
                                    <span class="text-xs px-2 py-1 bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300 rounded-full">Low Stock</span>
                                @endif
                            </div>
                            <div class="mt-1">
                                <p class="font-semibold {{ $medicine->stock_level > 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                    {{ number_format($medicine->stock_level) }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Important Dates -->
                <div class="space-y-4">
                    <h2 class="text-lg font-semibold border-b pb-2 text-gray-700 dark:text-gray-300 dark:border-gray-700">Important Dates</h2>
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <x-label value="Manufactured Date" class="font-medium dark:text-gray-400" />
                            <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $medicine->manufactured_date->format('F j, Y') }}</p>
                        </div>
                        <div>
                            <x-label value="Delivery Date" class="font-medium dark:text-gray-400" />
                            <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $medicine->delivery_date->format('F j, Y') }}</p>
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <x-label value="Expiry Date" class="font-medium dark:text-gray-400" />
                                {{--                                @if($this->isExpiringSoon)--}}
                                {{--                                    <span class="text-xs px-2 py-1 bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300 rounded-full">--}}
                                {{--                                        Expiring Soon--}}
                                {{--                                    </span>--}}
                                {{--                                @endif--}}
                            </div>
                            <div class="mt-1 flex items-center gap-2">
                                <p class="{{ $medicine->expired() ? 'text-red-600 dark:text-red-400 font-semibold' : 'text-gray-900 dark:text-gray-100' }}">
                                    {{ $medicine->expiry_date->format('F j, Y') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- System Information -->
                <div class="space-y-4">
                    <h2 class="text-lg font-semibold border-b pb-2 text-gray-700 dark:text-gray-300 dark:border-gray-700">System Information</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-label value="Created at" class="font-medium dark:text-gray-400" />
                            <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $created_at }}</p>
                        </div>
                        <div>
                            <x-label value="Last updated" class="font-medium dark:text-gray-400" />
                            <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $updated_at }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <div class="flex justify-end gap-4">
                <x-secondary-button wire:click="close" wire:loading.attr="disabled" class="dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700">
                    Close
                </x-secondary-button>
            </div>
        </x-slot>
    </x-dialog-modal>
</div>
