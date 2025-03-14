<div>
    <button
        type="button"
        wire:click="open"
        class="bg-purple-600 hover:bg-purple-700 focus:ring focus:ring-purple-300 rounded-full focus:outline-none dark:bg-purple-500 dark:hover:bg-purple-600 dark:focus:ring-purple-700 text-white text-sm px-3 py-1 font-medium"
    >
        Add Vital Signs
    </button>

    <x-dialog-modal wire:model="showModal">
        <x-slot name="title">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Record Vital Signs</h3>
        </x-slot>

        <x-slot name="content">
            <div class="space-y-6 dark:text-gray-200">
                <!-- Blood Pressure -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="systolic" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Systolic Pressure (mmHg)</label>
                        <x-input
                            id="systolic"
                            type="number"
                            class="mt-1 block w-full dark:bg-gray-800 dark:text-white dark:border-gray-600"
                            wire:model="systolic"
                            placeholder="120"
                        />
                        <x-input-error for="systolic" class="mt-1" />
                    </div>
                    <div>
                        <label for="diastolic" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Diastolic Pressure (mmHg)</label>
                        <x-input
                            id="diastolic"
                            type="number"
                            class="mt-1 block w-full dark:bg-gray-800 dark:text-white dark:border-gray-600"
                            wire:model="diastolic"
                            placeholder="80"
                        />
                        <x-input-error for="diastolic" class="mt-1" />
                    </div>
                </div>

                <!-- Temperature -->
                <div>
                    <label for="temperature" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Temperature (°C)</label>
                    <div class="mt-1 relative">
                        <x-input
                            id="temperature"
                            type="number"
                            step="0.1"
                            class="block w-full dark:bg-gray-800 dark:text-white dark:border-gray-600"
                            wire:model="temperature"
                            placeholder="37.0"
                        />
                    </div>
                    <x-input-error for="temperature" class="mt-1" />
                </div>

                <!-- Weight -->
                <div>
                    <label for="weight" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Weight (kg)</label>
                    <div class="mt-1 relative">
                        <x-input
                            id="weight"
                            type="number"
                            step="0.1"
                            class="block w-full dark:bg-gray-800 dark:text-white dark:border-gray-600"
                            wire:model="weight"
                            placeholder="70.5"
                        />
                    </div>
                    <x-input-error for="weight" class="mt-1" />
                </div>

                <!-- Height -->
                <div>
                    <label for="height" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Height (cm)</label>
                    <div class="mt-1 relative">
                        <x-input
                            id="height"
                            type="number"
                            step="0.1"
                            class="block w-full dark:bg-gray-800 dark:text-white dark:border-gray-600"
                            wire:model="height"
                            placeholder="170.0"
                        />
                    </div>
                    <x-input-error for="height" class="mt-1" />
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <div class="flex justify-end space-x-3">
                <x-secondary-button
                    wire:click="close"
                    class="dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600 dark:border-gray-600"
                >
                    Cancel
                </x-secondary-button>
                <button
                    type="button"
                    wire:click="save"
                    class="bg-green-600 hover:bg-green-700 focus:ring focus:ring-green-300 rounded-md focus:outline-none dark:bg-green-700 dark:hover:bg-green-800 dark:focus:ring-green-700 text-white text-sm px-4 py-2 font-medium transition-transform hover:scale-105 inline-flex items-center"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Save
                </button>
            </div>
        </x-slot>
    </x-dialog-modal>
</div>
