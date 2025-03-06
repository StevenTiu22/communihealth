<div>
    <!-- Add to Queue Button -->
    <x-button
        wire:click="openModal"
        color="indigo"
        class="flex items-center gap-2"
    >
        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
        </svg>
        Add to Queue
    </x-button>

    <!-- Add to Queue Modal -->
    @if($showModal)
        <div class="fixed inset-0 z-50 overflow-y-auto bg-gray-500 bg-opacity-75 transition-opacity flex items-center justify-center p-4">
            <div class="relative w-full max-w-md bg-white dark:bg-gray-700 rounded-lg shadow-xl">
                <!-- Modal Header -->
                <div class="flex items-center justify-between p-4 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Add to Queue
                    </h3>
                    <button type="button" wire:click="closeModal" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>

                <!-- Modal Body -->
                <form wire:submit.prevent="addToQueue" class="p-6 space-y-6">
                    <div class="grid gap-4">
                        <div>
                            <label for="patient_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Patient</label>
                            <select id="patient_id" wire:model.blur="patient_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-600 focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500">
                                <option value="">Select patient</option>
                            </select>
                            <x-input-error for="patient_id" class="mt-2 break-words" />
                        </div>

                        <div>
                            <label for="doctor_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Assign Doctor (Optional)</label>
                            <select id="doctor_id" wire:model.blur="doctor_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-600 focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500">
                                <option value="">Assign later</option>
                            </select>
                        </div>

                        <div>
                            <label for="appointment_type_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Appointment Type</label>
                            <select id="appointment_type_id" wire:model.blur="appointment_type_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-600 focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500">
                                <option value="">Select appointment type</option>
                            </select>
                            <x-input-error for="appointment_type_id" class="mt-2 break-words" />
                        </div>

                        <div>
                            <label for="queue_type" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Queue Type</label>
                            <select id="queue_type" wire:model.blur="queue_type" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-600 focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500">
                                <option value="walk-in">Walk-in</option>
                            </select>
                        </div>

                        <div>
                            <label for="chief_complaint" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Chief Complaint</label>
                            <textarea id="chief_complaint" wire:model.blur="chief_complaint" rows="3" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500" placeholder="Describe patient's complaint..."></textarea>
                            <x-input-error for="chief_complaint" class="mt-2 break-words" />
                        </div>

                        <div>
                            <label for="remarks" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Remarks (Optional)</label>
                            <textarea id="remarks" wire:model.blur="remarks" rows="2" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500" placeholder="Additional notes..."></textarea>
                            <x-input-error for="remarks" class="mt-2 break-words" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end space-x-4 border-t pt-4 mt-4 dark:border-gray-600">
                        <button type="button" wire:click="closeModal" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Cancel</button>
                        <button type="submit" class="text-white bg-indigo-700 hover:bg-indigo-800 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:ring-indigo-800">
                            <span wire:loading.remove wire:target="addToQueue">Add to Queue</span>
                            <span wire:loading wire:target="addToQueue" class="inline-flex items-center">
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Processing...
                        </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
