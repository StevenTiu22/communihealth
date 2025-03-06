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

    <x-dialog-modal wire:model="showModal">
        <x-slot name="title">
            Add to Queue
        </x-slot>

        <x-slot name="content">
            <div class="grid gap-4">
                <div>
                    <label for="patient_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Patient</label>
                    <select id="patient_id" wire:model.blur="patient_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-600 focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500">
                        <option value="">Select patient</option>
                        @forelse($patients as $patient)
                            <option value="{{ $patient->id }}">{{ $patient->name }}</option>
                        @empty
                            <option disabled>No patients available</option>
                        @endforelse
                    </select>
                    <x-input-error for="patient_id" class="mt-2 break-words" />
                </div>

                <div>
                    <label for="appointment_type_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Appointment Type</label>
                    <select id="appointment_type_id" wire:model.blur="appointment_type_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-600 focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500">
                        <option value="">Select appointment type</option>
                        @forelse($appointmentTypes as $type)
                            <option value="{{ $type->id }}">{{ $type->name }} ({{ $type->duration_minutes }} min)</option>
                        @empty
                            <option disabled>No appointment types available</option>
                        @endforelse
                    </select>
                    <x-input-error for="appointment_type_id" class="mt-2 break-words" />
                </div>

                <div>
                    <label for="doctor_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Assign Doctor (Optional)</label>
                    <select id="doctor_id" wire:model.blur="doctor_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-600 focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500">
                        <option value="">Assign later</option>
                        @forelse($doctors as $doctor)
                            <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                        @empty
                            <option disabled>No doctors available</option>
                        @endforelse
                    </select>
                </div>

                <div>
                    <label for="queue_type" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Queue Type</label>
                    <select id="queue_type" wire:model.blur="queue_type" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-600 focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500">
                        <option value="walk-in">Walk-in</option>
                        <option value="scheduled">Scheduled</option>
                        <option value="referral">Referral</option>
                        <option value="emergency">Emergency</option>
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
        </x-slot>

        <x-slot name="footer">
            <div class="flex justify-end gap-3">
                <x-secondary-button wire:click="close">
                    Cancel
                </x-secondary-button>

                <x-button wire:click="save">
                    <span wire:loading.remove wire:target="addToQueue">Add to Queue</span>
                    <span wire:loading wire:target="addToQueue" class="inline-flex items-center">
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Processing...
                </span>
                </x-button>
            </div>
        </x-slot>
    </x-dialog-modal>
</div>
