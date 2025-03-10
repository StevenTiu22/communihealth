<div>
    <x-button wire:click="open" class="bg-green-500 hover:bg-green-600">
        Complete Appointment
    </x-button>

    <x-dialog-modal wire:model="showModal">
        <x-slot name="title">
            <h3 class="text-lg font-medium text-gray-900">Complete Appointment</h3>
        </x-slot>

        <x-slot name="content">
            <div class="space-y-4">
                <p class="text-sm text-gray-600">
                    Are you sure you want to mark this appointment as complete?
                </p>

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
        </x-slot>

        <x-slot name="footer">
            <div class="flex justify-end space-x-3">
                <x-secondary-button wire:click="close">
                    Cancel
                </x-secondary-button>
                <x-button
                    type="button"
                    class="bg-green-500 hover:bg-green-600"
                    wire:click="complete"
                    @if(empty($vital_sign_id) || empty($treatment_record_id)) disabled @endif
                >
                    Complete Appointment
                </x-button>
            </div>
        </x-slot>
    </x-dialog-modal>
</div>
