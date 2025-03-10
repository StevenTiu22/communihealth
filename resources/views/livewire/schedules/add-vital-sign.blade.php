<div>
    <x-button wire:click="open" class="bg-blue-500 hover:bg-blue-600">
        Add Vital Signs
    </x-button>

    <x-dialog-modal wire:model="showModal">
        <x-slot name="title">
            <h3 class="text-lg font-medium text-gray-900">Record Vital Signs</h3>
        </x-slot>

        <x-slot name="content">
            <div class="space-y-4">
                <!-- Blood Pressure -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="systolic" class="block text-sm font-medium text-gray-700">Systolic Pressure (mmHg)</label>
                        <x-input
                            id="systolic"
                            type="number"
                            class="mt-1 block w-full"
                            wire:model="systolic"
                            placeholder="120"
                        />
                        <x-input-error for="systolic" class="mt-1" />
                    </div>
                    <div>
                        <label for="diastolic" class="block text-sm font-medium text-gray-700">Diastolic Pressure (mmHg)</label>
                        <x-input
                            id="diastolic"
                            type="number"
                            class="mt-1 block w-full"
                            wire:model="diastolic"
                            placeholder="80"
                        />
                        <x-input-error for="diastolic" class="mt-1" />
                    </div>
                </div>

                <!-- Temperature -->
                <div>
                    <label for="temperature" class="block text-sm font-medium text-gray-700">Temperature (°C)</label>
                    <x-input
                        id="temperature"
                        type="number"
                        step="0.1"
                        class="mt-1 block w-full"
                        wire:model="temperature"
                        placeholder="37.0"
                    />
                    <x-input-error for="temperature" class="mt-1" />
                </div>

                <!-- Weight -->
                <div>
                    <label for="weight" class="block text-sm font-medium text-gray-700">Weight (kg)</label>
                    <x-input
                        id="weight"
                        type="number"
                        step="0.1"
                        class="mt-1 block w-full"
                        wire:model="weight"
                        placeholder="70.5"
                    />
                    <x-input-error for="weight" class="mt-1" />
                </div>

                <!-- Height -->
                <div>
                    <label for="height" class="block text-sm font-medium text-gray-700">Height (cm)</label>
                    <x-input
                        id="height"
                        type="number"
                        step="0.1"
                        class="mt-1 block w-full"
                        wire:model="height"
                        placeholder="170.0"
                    />
                    <x-input-error for="height" class="mt-1" />
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <div class="flex justify-end space-x-3">
                <x-secondary-button wire:click="close">
                    Cancel
                </x-secondary-button>
                <x-button type="button" class="bg-blue-500 hover:bg-blue-600" wire:click="save">
                    Save
                </x-button>
            </div>
        </x-slot>
    </x-dialog-modal>
</div>
