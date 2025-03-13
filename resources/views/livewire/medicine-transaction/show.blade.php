<div>
    <button wire:click="open" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-200">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
        </svg>
    </button>

    <x-dialog-modal wire:model.live="showModal" maxWidth="2xl">
        <x-slot name="title">
            <div class="flex justify-between">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __('Transaction Details') }}
                </h3>
            </div>
        </x-slot>

        <x-slot name="content">
            <div class="space-y-6">
                <!-- Transaction Summary -->
                <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg border border-gray-200 dark:border-gray-700">
                    <div class="flex justify-between items-start">
                        <div>
                            <h4 class="text-md font-semibold mb-1 text-gray-800 dark:text-gray-200">Transaction Summary</h4>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4 text-left">
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Transaction Date</p>
                            <p class="font-medium text-gray-900 dark:text-gray-100">{{ $transaction->created_at->format('M d, Y g:i A') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Processed By</p>
                            <p class="font-medium text-gray-900 dark:text-gray-100">
                                {{ 'BHW ' . $transaction->bhw->last_name ?? 'N/A' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Reference Number</p>
                            <p class="font-medium text-gray-900 dark:text-gray-100">
                                {{ $transaction->reference_number ?? 'N/A' }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-left">
                <!-- Medicine Information -->
                <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg border border-gray-200 dark:border-gray-700">
                    <h4 class="text-md font-semibold mb-3 text-gray-800 dark:text-gray-200">Medicine Information</h4>

                    <div class="space-y-3">
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Name</p>
                            <p class="font-medium text-gray-900 dark:text-gray-100">{{ $transaction->medicine->name }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Generic Name</p>
                            <p class="font-medium text-gray-900 dark:text-gray-100">{{ $transaction->medicine->generic_name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Quantity</p>
                            <p class="font-medium text-gray-900 dark:text-gray-100">{{ $transaction->quantity }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Tracker Number</p>
                            <p class="font-medium text-gray-900 dark:text-gray-100">{{ $transaction->medicine->tracking_number ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Patient Information -->
                <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg border border-gray-200 dark:border-gray-700">
                    <h4 class="text-md font-semibold mb-3 text-gray-800 dark:text-gray-200">Patient Information</h4>

                    @if($transaction->patient)
                        <div class="space-y-3">
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Name</p>
                                <p class="font-medium text-gray-900 dark:text-gray-100">{{ $transaction->patient->full_name }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Contact</p>
                                <p class="font-medium text-gray-900 dark:text-gray-100">{{ $transaction->patient->contact_number ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Age</p>
                                <p class="font-medium text-gray-900 dark:text-gray-100">{{ $transaction->patient->age ?? 'N/A' }} years</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Sex</p>
                                <p class="font-medium text-gray-900 dark:text-gray-100">{{ $transaction->patient->sex ?? 'N/A' }}</p>
                            </div>
                        </div>
                    @else
                        <p class="text-gray-500 dark:text-gray-400">No patient information available</p>
                    @endif
                </div>
            </div>

            <!-- Additional Details -->
            <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg border border-gray-200 dark:border-gray-700 text-left gap-4">
                <h4 class="text-md font-semibold mb-3 text-gray-800 dark:text-gray-200">Additional Information</h4>
                    <div class="mb-4">
                        <p class="text-xs text-gray-500 dark:text-gray-400">Expiry Date</p>
                        <p class="font-medium text-gray-900 dark:text-gray-100">
                            {{ $transaction->medicine->expiry_date ? $transaction->medicine->expiry_date->format('M d, Y') : 'N/A' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Dispensed From</p>
                        <p class="font-medium text-gray-900 dark:text-gray-100">
                            {{ $transaction->medicine->source ?? 'Main Inventory' }}
                        </p>
                    </div>
                </div>

                <div class="mt-4">
                    <p class="text-xs text-gray-500 dark:text-gray-400">Instructions / Notes</p>
                    <div class="mt-2 p-3 bg-white dark:bg-gray-700 rounded-md">
                        <p class="text-sm text-gray-900 dark:text-gray-100">
                            {{ $transaction->remarks ?? 'No remarks provided' }}
                        </p>
                    </div>
                </div>
            </div>

        </x-slot>

        <x-slot name="footer">
            <div class="flex justify-between">

                <div class="flex space-x-2">
                    <x-secondary-button wire:click="close" wire:loading.attr="disabled">
                        {{ __('Close') }}
                    </x-secondary-button>
                </div>
            </div>
        </x-slot>
    </x-dialog-modal>
</div>
