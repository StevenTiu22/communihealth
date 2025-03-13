<div>
    <button wire:click="open" class="bg-blue-500 hover:bg-blue-600 text-white text-sm px-3 py-1 rounded-full font-medium">
        Show
    </button>

    <x-dialog-modal wire:model="showModal">
        <x-slot name="title">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100">
                        Queue #{{ $appointment_queue->queue_number }}
                    </h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-400">
                        Created on {{ $appointment_queue->created_at->addHours(8)->format('M d, Y g:i A') }}
                    </p>
                </div>
                <div class="flex items-center space-x-2">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                    {{ $appointment_queue->queue_status === 'waiting' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300' : '' }}
                    {{ $appointment_queue->queue_status === 'in progress' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300' : '' }}
                    {{ $appointment_queue->queue_status === 'completed' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : '' }}
                    {{ $appointment_queue->queue_status === 'cancelled' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' : '' }}">
                    {{ ucfirst(str_replace('_', ' ', $appointment_queue->queue_status)) }}
                </span>
                </div>
            </div>
        </x-slot>

        <x-slot name="content">
            <!-- Patient Information -->
            <div class="border-b border-gray-200 dark:border-gray-700 pb-5 mb-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="text-base font-semibold text-gray-700 dark:text-gray-300 mb-4">Patient Information</h4>
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-3 sm:grid-cols-2">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Name</dt>
                                <dd class="mt-1 text-sm font-semibold text-gray-900 dark:text-gray-100">
                                    {{ $appointment_queue->appointment->patient->full_name }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Contact Number</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $appointment_queue->appointment->patient->contact_number ?? 'N/A' }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Age</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $appointment_queue->appointment->patient->age }} years old
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Sex</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $appointment_queue->appointment->patient->sex == 0 ? 'Male' : 'Female' }}
                                </dd>
                            </div>
                            <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Address</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $appointment_queue->appointment->patient->address->full_address ?? 'N/A' }}
                                </dd>
                            </div>
                        </dl>
                    </div>

                    <div>
                        <h4 class="text-base font-semibold text-gray-700 dark:text-gray-300 mb-4">Appointment Details</h4>
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-3 sm:grid-cols-2">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Appointment Type</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    {{ ucwords($appointment_queue->appointment->appointmentType->name) }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Date</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $appointment_queue->appointment->appointment_date->format('M d, Y') }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Doctor</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $appointment_queue->appointment->doctor->full_name ?? 'Not assigned' }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Added By</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    BHW {{ $appointment_queue->appointment->bhw->last_name }}
                                </dd>
                            </div>
                            <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Chief Complaint</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $appointment_queue->appointment->chief_complaint ?? 'No chief complaint provided' }}
                                </dd>
                            </div>
                            <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Queue Type</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    {{ ucfirst($appointment_queue->queue_type) }}
                                </dd>
                            </div>
                            <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Remarks</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $appointment_queue->appointment->remarks == "" ? 'N/A' : $appointment_queue->appointment->remarks }}
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>

            <!-- Vital Signs (if available) -->
            @if($appointment_queue->appointment->vitalSign)
                <div class="border-b border-gray-200 dark:border-gray-700 pb-5 mb-5">
                    <h4 class="text-base font-semibold text-gray-700 dark:text-gray-300 mb-4">Vital Signs</h4>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                        <div class="bg-gray-50 dark:bg-gray-700 p-3 rounded-lg">
                            <dt class="text-xs font-medium text-gray-500 dark:text-gray-400">Blood Pressure</dt>
                            <dd class="mt-1 text-sm font-semibold text-gray-900 dark:text-gray-100">
                                {{ $appointment_queue->appointment->vitalSign->blood_pressure ?? 'N/A' }}
                            </dd>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700 p-3 rounded-lg">
                            <dt class="text-xs font-medium text-gray-500 dark:text-gray-400">Heart Rate</dt>
                            <dd class="mt-1 text-sm font-semibold text-gray-900 dark:text-gray-100">
                                {{ $appointment_queue->appointment->vitalSign->heart_rate ?? 'N/A' }} bpm
                            </dd>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700 p-3 rounded-lg">
                            <dt class="text-xs font-medium text-gray-500 dark:text-gray-400">Temperature</dt>
                            <dd class="mt-1 text-sm font-semibold text-gray-900 dark:text-gray-100">
                                {{ $appointment_queue->appointment->vitalSign->temperature ?? 'N/A' }} °C
                            </dd>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700 p-3 rounded-lg">
                            <dt class="text-xs font-medium text-gray-500 dark:text-gray-400">Weight</dt>
                            <dd class="mt-1 text-sm font-semibold text-gray-900 dark:text-gray-100">
                                {{ $appointment_queue->appointment->vitalSign->weight ?? 'N/A' }} kg
                            </dd>
                        </div>
                    </div>
                </div>
            @endif
        </x-slot>

        <x-slot name="footer">
            <div class="flex justify-between items-center w-full">
                <div>
                    @if($appointment_queue->queue_status === 'waiting')
                        <x-button
                            type="button"
                            wire:click="start({{ $appointment_queue->id }})"
                            class="bg-blue-600 hover:bg-blue-700"
                        >
                            Start Consultation
                        </x-button>
                    @elseif($appointment_queue->queue_status === 'in progress')
                        <x-button
                            type="button"
                            wire:click="complete({{ $appointment_queue->id }})"
                            class="bg-green-600 hover:bg-green-700"
                        >
                            Complete Consultation
                        </x-button>
                    @endif
                </div>
            </div>
        </x-slot>
    </x-dialog-modal>
</div>
