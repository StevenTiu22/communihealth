<div>
    <button
        type="button"
        wire:click="open"
        class="bg-green-600 hover:bg-green-700 focus:ring focus:ring-green-300 rounded-full focus:outline-none dark:bg-green-500 dark:hover:bg-green-600 dark:focus:ring-green-700 text-white text-sm px-3 py-1 font-medium transition-all duration-150"
    >
        Complete Appointment
    </button>

    <x-dialog-modal wire:model="showModal">
        <x-slot name="title">
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Complete Appointment</h3>
        </x-slot>

        <x-slot name="content">
            <form wire:submit.prevent="save">
                <div class="space-y-4">
                    <p class="text-sm text-gray-600 dark:text-gray-300">
                        Are you sure you want to mark this appointment as complete?
                    </p>

                    <!-- Info banner - unchanged as requested -->
                    <div class="bg-blue-50 p-4 rounded-md border border-blue-200">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-blue-700">
                                    The appointment will be marked as completed and removed from the active queue.
                                    <br>
                                    This action will record the current time as the checkout time.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Warning banner - unchanged as requested -->
                    @if(empty($vital_sign_id) || empty($treatment_record_id))
                        <div class="bg-yellow-50 p-4 rounded-md border border-yellow-200">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-yellow-700">
                                        <strong>Warning:</strong> You must complete both the vital signs and treatment record before completing this appointment.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </form>
        </x-slot>

        <x-slot name="footer">
            <div class="flex justify-end space-x-3">
                <button
                    type="button"
                    wire:click="close"
                    class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-all duration-200"
                >
                    Cancel
                </button>

                <button
                    type="button"
                    wire:click="save"
                    {{ empty($vital_sign_id) && empty($treatment_record_id) ? 'disabled' : '' }}
                    class="inline-flex items-center px-4 py-2 bg-green-500 dark:bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest shadow-sm hover:bg-green-600 dark:hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200"
                >
                    Complete Appointment
                </button>
            </div>
        </x-slot>
    </x-dialog-modal>
</div>
