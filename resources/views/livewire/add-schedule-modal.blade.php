<div>
    <!-- Add Schedule Button -->
    <x-button wire:click="openModal" class="px-3 py-3 text-lg">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
        </svg>
        Schedule Appointment
    </x-button>

    <x-dialog-modal wire:model.live="showModal" maxWidth="xl">
        <x-slot name="title">
            <div class="mt-4 border-b pb-4">
                <h1 class="text-2xl font-bold">
                    Schedule Appointment
                </h1>
            </div>
        </x-slot>

        <x-slot name="content">
            <div class="p-4">
                <form wire:submit.prevent="createAppointment">
                    <div class="space-y-4">
                        <!-- Patient Selection -->
                        <div>
                            <x-label for="patientId" value="Patient" />
                            <select wire:model="patientId" id="patientId" 
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">Select Patient</option>
                                @forelse($patients as $patient)
                                    <option value="{{ $patient->id }}">
                                        {{ $patient->full_name }}
                                    </option>
                                @empty
                                    <option value="" selected disabled>No patients found</option>
                                @endforelse
                            </select>
                            @error('patientId') <x-input-error for="patientId" class="mt-2" /> @enderror
                        </div>

                        <!-- Appointment Type Selection -->
                        <div>
                            <x-label for="appointmentTypeId" value="Appointment Type" />
                            <select wire:model="appointmentTypeId" id="appointmentTypeId"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">Select Appointment Type</option>
                                @foreach($appointmentTypes as $type)
                                    <option value="{{ $type->id }}">
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('appointmentTypeId') <x-input-error for="appointmentTypeId" class="mt-2" /> @enderror
                        </div>

                        <!-- ... other form fields with x-label and x-input ... -->

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-label for="appointmentDate" value="Date" />
                                <x-input id="appointmentDate" type="date" 
                                    class="mt-1 block w-full"
                                    wire:model="appointmentDate"
                                    min="{{ now()->format('Y-m-d') }}" />
                                @error('appointmentDate') <x-input-error for="appointmentDate" class="mt-2" /> @enderror
                            </div>
                            <div>
                                <x-label for="appointmentTime" value="Time" />
                                <x-input id="appointmentTime" type="time" 
                                    class="mt-1 block w-full"
                                    wire:model="appointmentTime" />
                                @error('appointmentTime') <x-input-error for="appointmentTime" class="mt-2" /> @enderror
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="closeModal" wire:loading.attr="disabled">
                Cancel
            </x-secondary-button>

            <x-button class="ml-3" wire:click="createAppointment" wire:loading.attr="disabled" :disabled="$errors->any()">
                Schedule Appointment
            </x-button>
        </x-slot>
    </x-dialog-modal>
</div>