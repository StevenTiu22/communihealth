<div>
    <button wire:click="open" class="bg-red-500 hover:bg-red-600 text-white text-sm px-2 py-1 rounded-full font-medium">
        Cancel
    </button>

    <x-dialog-modal wire:model="showModal">
        <x-slot name="title">
            <h3 class="text-lg font-medium text-gray-100 dark:text-gray-100">Cancel Appointment</h3>
        </x-slot>

        <x-slot name="content">
            <div class="space-y-4">
                <p class="text-sm text-gray-300 dark:text-gray-300">
                    Are you sure you want to cancel this appointment for patient <span class="font-semibold">{{ $appointment->patient->full_name }}</span>?
                </p>

                <div>
                    <label for="reason" class="block text-sm font-medium text-gray-200 dark:text-gray-200">Reason for Cancellation</label>
                    <textarea
                        id="reason"
                        wire:model="reason"
                        rows="3"
                        class="mt-3 block w-full bg-gray-800 dark:bg-gray-900 border-gray-700 dark:border-gray-700 focus:border-red-500 dark:focus:border-red-500 focus:ring focus:ring-red-500 dark:focus:ring-red-500 focus:ring-opacity-50 rounded-md shadow-sm text-gray-200 dark:text-gray-200"
                        placeholder="Please provide a reason for cancelling this appointment"
                    ></textarea>
                    <x-input-error for="reason" class="mt-1" />
                </div>

                <div class="bg-gray-800 dark:bg-gray-800 p-4 rounded-md border border-amber-700 dark:border-amber-700">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-amber-500 dark:text-amber-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-amber-400 dark:text-amber-400">
                                This action cannot be undone. The appointment will be marked as cancelled.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <div class="flex justify-end space-x-3">
                <x-secondary-button wire:click="close" class="bg-gray-700 dark:bg-gray-700 hover:bg-gray-600 dark:hover:bg-gray-600 text-gray-200 dark:text-gray-200 border-gray-600 dark:border-gray-600">
                    Nevermind
                </x-secondary-button>
                <x-danger-button wire:click="cancel">
                    Cancel Appointment
                </x-danger-button>
            </div>
        </x-slot>
    </x-dialog-modal>
</div>
