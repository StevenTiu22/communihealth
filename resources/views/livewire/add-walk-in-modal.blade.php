<div>
    <!-- Add Walk-in Button -->
    <x-button wire:click="openModal" class="px-3 py-3 text-lg bg-green-500 hover:bg-green-600">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
        </svg>
        New Walk-in
    </x-button>

    <x-dialog-modal wire:model.live="showModal" maxWidth="xl">
        <x-slot name="title">
            <div class="mt-4 border-b pb-4">
                <h1 class="text-2xl font-bold">
                    New Walk-in Patient
                </h1>
            </div>
        </x-slot>

        <x-slot name="content">
            <div class="p-4">
                <form wire:submit.prevent="createWalkIn">
                    <div class="space-y-4">
                        <!-- Patient Selection -->
                        <div>
                            <x-label for="patientId" value="Patient" />
                            <select wire:model="patientId" id="patientId" 
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">Select Patient</option>
                                @foreach($patients as $patient)
                                    <option value="{{ $patient->id }}">
                                        {{ $patient->full_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('patientId') <x-input-error for="patientId" class="mt-2" /> @enderror
                        </div>

                        <!-- Appointment Type -->
                        <div>
                            <x-label for="appointmentTypeId" value="Appointment Type" />
                            <select wire:model="appointmentTypeId" id="appointmentTypeId"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">Select Type</option>
                                @foreach($appointmentTypes as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                            @error('appointmentTypeId') <x-input-error for="appointmentTypeId" class="mt-2" /> @enderror
                        </div>

                        <!-- Doctor Selection -->
                        <div>
                            <x-label for="doctorId" value="Doctor" />
                            <select wire:model="doctorId" id="doctorId"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">Select Doctor</option>
                                @foreach($doctors as $doctor)
                                    <option value="{{ $doctor->id }}">
                                        Dr. {{ $doctor->first_name }} {{ $doctor->last_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('doctorId') <x-input-error for="doctorId" class="mt-2" /> @enderror
                        </div>

                        <!-- Chief Complaint -->
                        <div>
                            <x-label for="chiefComplaint" value="Chief Complaint" />
                            <textarea 
                                wire:model="chiefComplaint"
                                id="chiefComplaint"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                rows="3"
                                placeholder="Enter patient's chief complaint"
                            ></textarea>
                            @error('chiefComplaint') <x-input-error for="chiefComplaint" class="mt-2" /> @enderror
                        </div>
                    </div>
                </form>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="closeModal" wire:loading.attr="disabled">
                Cancel
            </x-secondary-button>

            <x-button class="ml-3" wire:click="createWalkIn" wire:loading.attr="disabled" :disabled="$errors->any()">
                Register Walk-in
            </x-button>
        </x-slot>
    </x-dialog-modal>
</div> 