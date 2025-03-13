<div class="mr-6">
    <!-- Dispense Medicine Button -->
    <x-button
        wire:click="open"
        class="bg-primary-600 hover:bg-primary-700 focus:border-primary-700 active:bg-primary-700"
    >
        <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
        {{ __('Dispense Medicine') }}
    </x-button>

    <!-- Dispense Medicine Modal -->
    <x-dialog-modal wire:model.live="showModal" maxWidth="md">
        <x-slot name="title">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __('Dispense Medicine') }}
                </h3>
            </div>
        </x-slot>

        <x-slot name="content">
            <div class="space-y-4">
                <!-- Reference Number -->
                <div>
                    <x-label for="reference_number" value="{{ __('Reference Number') }}" />
                    <x-input id="reference_number" wire:model="reference_number" type="text" class="mt-1 block w-full" placeholder="Enter reference number" />
                </div>

                <!-- Patient Selection -->
                <div>
                    <x-label for="patient" value="{{ __('Patient') }}" />
                    <div class="relative">
                        <select id="patient" wire:model.live="patient_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm rounded-md">
                            <option value="">Select Patient</option>
                            @forelse($patients as $patient)
                                <option value="{{ $patient->id }}">{{ $patient->full_name }}</option>
                            @empty
                                <option disabled>No patients available</option>
                            @endforelse
                        </select>
                    </div>
                </div>

                <!-- Medicine Selection -->
                <div>
                    <x-label for="medicine" value="{{ __('Medicine') }}" />
                    <div class="relative">
                        <select id="medicine" wire:model="medicine_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm rounded-md">
                            <option value="">Select Medicine</option>
                            @forelse($medicines as $medicine)
                                <option value="{{ $medicine->id }}">{{ $medicine->name }}</option>
                            @empty
                                <option disabled>No medicines available</option>
                            @endforelse
                        </select>
                    </div>
                </div>

                <!-- Quantity -->
                <div>
                    <x-label for="quantity" value="{{ __('Quantity') }}" />
                    <div class="flex">
                        <x-input id="quantity" wire:model.live="quantity" type="number" min="1" class="mt-1 block w-full" placeholder="Enter quantity" />
                    </div>
                    <x-input-error for="quantity" class="mt-2" />
                </div>

                <!-- Remarks -->
                <div>
                    <x-label for="remarks" value="{{ __('Remarks') }}" />
                    <x-textarea id="remarks" wire:model="remarks" class="mt-1 block w-full dark:bg-gray-900" rows="3" placeholder="E.g., Take 1 tablet 3 times a day after meals" />
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <div class="flex justify-end space-x-2">
                <x-secondary-button wire:click="close">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-button wire:click="dispense" class="bg-primary-600 hover:bg-primary-700">
                    {{ __('Dispense') }}
                </x-button>
            </div>
        </x-slot>
    </x-dialog-modal>
</div>
