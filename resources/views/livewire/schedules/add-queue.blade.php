<div>
    <!-- Add to Queue Button -->
    <x-button
        wire:click="open"
        color="indigo"
        class="flex items-center gap-2"
    >
        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
        </svg>
        Add to Queue
    </x-button>

    <!-- Modal -->
    <x-dialog-modal wire:model.live="showModal">
        <x-slot name="title">
            Add to Queue
        </x-slot>

        <x-slot name="content">
            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-md">
                    <div class="font-medium text-red-600">
                        {{ __('Whoops! Something went wrong.') }}
                    </div>

                    <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form wire:submit.prevent="save">
                <div class="grid gap-4">
                    <div>
                        <label for="patient_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Patient</label>
                        <select id="patient_id" wire:model.blur="form.patient_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-600 focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500">
                            <option value="">Select patient</option>
                            @forelse($patients as $patient)
                                <option value="{{ $patient->id }}">{{ $patient->full_name }}</option>
                            @empty
                                <option disabled>No patients available</option>
                            @endforelse
                        </select>
                        <x-input-error for="patient_id" class="mt-2 break-words" />
                    </div>

                    <div>
                        <label for="appointment_type_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Appointment Type</label>
                        <select id="appointment_type_id" wire:model.blur="form.appointment_type_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-600 focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500">
                            <option value="">Select appointment type</option>
                            @forelse($appointmentTypes as $type)
                                <option value="{{ $type->id }}">{{ $type->name }} ({{ $type->duration_minutes }} min)</option>
                            @empty
                                <option disabled>No appointment types available</option>
                            @endforelse
                        </select>
                        <x-input-error for="form.appointment_type_id" class="mt-2 break-words" />
                    </div>

                    <div>
                        <label for="doctor_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Assigned Doctor</label>
                        <select id="doctor_id" wire:model.blur="form.doctor_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-600 focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500">
                            <option value="">Assign later</option>
                            @forelse($doctors as $doctor)
                                <option value="{{ $doctor->id }}">{{ "Dr. " . $doctor->full_name }}</option>
                            @empty
                                <option disabled>No doctors available</option>
                            @endforelse
                        </select>

                        <x-input-error for="form.doctor_id" class="mt-2 break-words" />
                    </div>

                    <div>
                        <label for="queue_type" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Queue Type</label>
                        <select id="queue_type" wire:model.blur="form.queue_type" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-600 focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500">
                            <option value="walk-in">Walk-in</option>
                            <option value="scheduled">Scheduled</option>
                            <option value="referral">Referral</option>
                            <option value="emergency">Emergency</option>
                        </select>

                        <x-input-error for="queue_type" class="mt-2 break-words" />
                    </div>

                    <div>
                        <label for="chief_complaint" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Chief Complaint</label>
                        <textarea id="chief_complaint" wire:model.blur="form.chief_complaint" rows="3" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500" placeholder="Describe patient's complaint..."></textarea>
                        <x-input-error for="form.chief_complaint" class="mt-2 break-words" />
                    </div>

                    <div>
                        <label for="remarks" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Remarks (Optional)</label>
                        <textarea id="remarks" wire:model.blur="form.remarks" rows="2" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500" placeholder="Additional notes..."></textarea>
                        <x-input-error for="form.remarks" class="mt-2 break-words" />
                    </div>
                </div>
            </form>
        </x-slot>

        <x-slot name="footer">
            <div class="flex justify-end gap-3">
                <x-secondary-button wire:click="close">
                    Cancel
                </x-secondary-button>

                <x-button
                    class="ml-3"
                    color="blue"
                    :darkMode="false"
                    wire:click="save"
                    wire:loading.attr="disabled"
                    :disabled="$errors->any()"
                >
                    <span wire:loading.remove wire:target="save">Save</span>
                    <span wire:loading wire:target="save">Saving...</span>
                </x-button>
            </div>
        </x-slot>
    </x-dialog-modal>
</div>
