<div>
    <x-dialog-modal wire:model="showModal">
        <x-slot name="title">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    Health Record Details
                </h3>
            </div>
        </x-slot>

        <x-slot name="content">
            @if($appointment)
                <div class="space-y-5">
                    <!-- Patient Information -->
                    <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg border border-gray-200 dark:border-gray-700">
                        <h4 class="text-md font-semibold mb-2 text-gray-800 dark:text-gray-200">Patient Information</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                            <div>
                                <p class="text-gray-500 dark:text-gray-400">Name</p>
                                <p class="font-medium text-gray-900 dark:text-gray-100">{{ $appointment->patient->full_name }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500 dark:text-gray-400">Sex</p>
                                <p class="font-medium text-gray-900 dark:text-gray-100">{{ $appointment->patient->sex == 0 ? 'Male' : 'Female' }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500 dark:text-gray-400">Age</p>
                                <p class="font-medium text-gray-900 dark:text-gray-100">{{ $appointment->patient->age }} years</p>
                            </div>
                            <div>
                                <p class="text-gray-500 dark:text-gray-400">Doctor</p>
                                <p class="font-medium text-gray-900 dark:text-gray-100">Dr. {{ $appointment->doctor->first_name . ' ' . $appointment->doctor->last_name }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500 dark:text-gray-400">Appointment Date</p>
                                <p class="font-medium text-gray-900 dark:text-gray-100">{{ $appointment->appointment_date->format('M d, Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Vital Signs -->
                    <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg border border-gray-200 dark:border-gray-700">
                        <div class="flex justify-between mb-2">
                            <h4 class="text-md font-semibold text-gray-800 dark:text-gray-200">Vital Signs</h4>
                            <span class="text-xs text-gray-500 dark:text-gray-400">
                                Recorded: {{ $appointment->vitalSign->created_at->addHours(8)->format('M d, Y g:i A') }}
                            </span>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-white dark:bg-gray-700 p-3 rounded-md shadow-sm col-span-1">
                                <p class="text-xs text-gray-500 dark:text-gray-400">Blood Pressure</p>
                                <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $appointment->vitalSign->systolic . "/" . $appointment->vitalSign->diastolic }} mmHg</p>
                            </div>
                            <div class="bg-white dark:bg-gray-700 p-3 rounded-md shadow-sm col-span-1">
                                <p class="text-xs text-gray-500 dark:text-gray-400">Temperature</p>
                                <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $appointment->vitalSign->temperature }} °C</p>
                            </div>
                            <div class="bg-white dark:bg-gray-700 p-3 rounded-md shadow-sm col-span-1">
                                <p class="text-xs text-gray-500 dark:text-gray-400">Height</p>
                                <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $appointment->vitalSign->height }} cm</p>
                            </div>
                            <div class="bg-white dark:bg-gray-700 p-3 rounded-md shadow-sm col-span-1">
                                <p class="text-xs text-gray-500 dark:text-gray-400">Weight</p>
                                <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $appointment->vitalSign->weight }} kg</p>
                            </div>
                        </div>
                    </div>

                    <!-- Treatment Record -->
                    <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg border border-gray-200 dark:border-gray-700">
                        <div class="flex justify-between mb-2">
                            <h4 class="text-md font-semibold text-gray-800 dark:text-gray-200">Treatment Record</h4>
                            @if($appointment->treatmentRecord)
                                <span class="text-xs text-gray-500 dark:text-gray-400">
                                    Recorded: {{ $appointment->treatmentRecord->created_at->addHours(8)->format('M d, Y g:i A') }}
                                </span>
                            @endif
                        </div>

                        <div class="space-y-3">
                            <div class="bg-white dark:bg-gray-700 p-3 rounded-md shadow-sm">
                                <p class="text-xs text-gray-500 dark:text-gray-400">Disease</p>
                                <p class="font-medium text-gray-900 dark:text-gray-100">{{ $appointment->treatmentRecord->disease->name }}</p>
                            </div>
                            <div class="bg-white dark:bg-gray-700 p-3 rounded-md shadow-sm">
                                <p class="text-xs text-gray-500 dark:text-gray-400">Diagnosis</p>
                                <p class="font-medium text-gray-900 dark:text-gray-100">{{ $appointment->treatmentRecord->diagnosis }}</p>
                            </div>
                            <div class="bg-white dark:bg-gray-700 p-3 rounded-md shadow-sm">
                                <p class="text-xs text-gray-500 dark:text-gray-400">Treatment</p>
                                <p class="font-medium text-gray-900 dark:text-gray-100">{{ $appointment->treatmentRecord->treatment }}</p>
                            </div>
                            <div class="bg-white dark:bg-gray-700 p-3 rounded-md shadow-sm">
                                <p class="text-xs text-gray-500 dark:text-gray-400">Medication</p>
                                <p class="font-medium text-gray-900 dark:text-gray-100">{{ $appointment->treatmentRecord->medication ?: 'None prescribed' }}</p>
                            </div>
                            <div class="bg-white dark:bg-gray-700 p-3 rounded-md shadow-sm">
                                <p class="text-xs text-gray-500 dark:text-gray-400">Notes</p>
                                <p class="font-medium text-gray-900 dark:text-gray-100">{{ $appointment->treatmentRecord->notes ?: 'No additional notes' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                    Loading appointment details...
                </div>
            @endif
        </x-slot>

        <x-slot name="footer">
            <div class="flex justify-end">
                <x-secondary-button wire:click="close" wire:loading.attr="disabled">
                    Close
                </x-secondary-button>
            </div>
        </x-slot>
    </x-dialog-modal>
</div>
