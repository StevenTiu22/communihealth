<div>
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
        <!-- Header -->
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100">
                        Queue #{{ $appointment_queue->queue_number }}
                    </h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-400">
                        Created on {{ $appointment_queue->created_at->format('M d, Y g:i A') }}
                    </p>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                        {{ $appointment_queue->status === 'waiting' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300' : '' }}
                        {{ $appointment_queue->status === 'in_progress' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300' : '' }}
                        {{ $appointment_queue->status === 'completed' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : '' }}
                        {{ $appointment_queue->status === 'cancelled' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' : '' }}">
                        {{ ucfirst(str_replace('_', ' ', $appointment_queue->status)) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Patient Information -->
        <div class="px-4 py-5 sm:p-6 border-b border-gray-200 dark:border-gray-700">
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
                                {{ $appointment_queue->appointment->patient->age }} years
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Gender</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                {{ ucfirst($appointment_queue->appointment->patient->gender) }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Address</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                {{ $appointment_queue->appointment->patient->address ?? 'N/A' }}
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
                                {{ $appointment_queue->appointment->scheduled_date->format('M d, Y') }}
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
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Reason for Visit</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                {{ $appointment_queue->appointment->reason ?? 'No reason provided' }}
                            </dd>
                        </div>
                        <div class="sm:col-span-2">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Notes</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                {{ $appointment_queue->notes ?? 'No notes available' }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Vital Signs (if available) -->
        @if(!empty($appointment_queue->vital_signs))
            <div class="px-4 py-5 sm:p-6 border-b border-gray-200 dark:border-gray-700">
                <h4 class="text-base font-semibold text-gray-700 dark:text-gray-300 mb-4">Vital Signs</h4>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    <div class="bg-gray-50 dark:bg-gray-700 p-3 rounded-lg">
                        <dt class="text-xs font-medium text-gray-500 dark:text-gray-400">Blood Pressure</dt>
                        <dd class="mt-1 text-sm font-semibold text-gray-900 dark:text-gray-100">
                            {{ $appointment_queue->vital_signs->blood_pressure ?? 'N/A' }}
                        </dd>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 p-3 rounded-lg">
                        <dt class="text-xs font-medium text-gray-500 dark:text-gray-400">Heart Rate</dt>
                        <dd class="mt-1 text-sm font-semibold text-gray-900 dark:text-gray-100">
                            {{ $appointment_queue->vital_signs->heart_rate ?? 'N/A' }} bpm
                        </dd>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 p-3 rounded-lg">
                        <dt class="text-xs font-medium text-gray-500 dark:text-gray-400">Temperature</dt>
                        <dd class="mt-1 text-sm font-semibold text-gray-900 dark:text-gray-100">
                            {{ $appointment_queue->vital_signs->temperature ?? 'N/A' }} °C
                        </dd>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 p-3 rounded-lg">
                        <dt class="text-xs font-medium text-gray-500 dark:text-gray-400">Weight</dt>
                        <dd class="mt-1 text-sm font-semibold text-gray-900 dark:text-gray-100">
                            {{ $appointment_queue->vital_signs->weight ?? 'N/A' }} kg
                        </dd>
                    </div>
                </div>
            </div>
        @endif

        <!-- Actions -->
        <div class="px-4 py-5 sm:p-6 bg-gray-50 dark:bg-gray-900">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div class="flex items-center space-x-3">
                    @if($appointment_queue->status === 'waiting')
                        <button
                            type="button"
                            wire:click="start({{ $appointment_queue->id }})"
                            class="bg-blue-600 hover:bg-blue-700 focus:ring focus:ring-blue-300 text-white text-sm px-3 py-1 rounded focus:outline-none dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-700"
                        >
                            Start Consultation
                        </button>
                    @elseif($appointment_queue->status === 'in_progress')
                        <button
                            type="button"
                            wire:click="complete({{ $appointment_queue->id }})"
                            class="bg-green-600 hover:bg-green-700 focus:ring focus:ring-green-300 text-white text-sm px-3 py-1 rounded focus:outline-none dark:bg-green-500 dark:hover:bg-green-600 dark:focus:ring-green-700"
                        >
                            Complete
                        </button>
                    @endif
                </div>

                <div class="flex space-x-2">
                    <a
                        href="{{ route('patients.show', $appointment_queue->appointment->patient->id) }}"
                        class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300"
                    >
                        View Patient Record
                    </a>
                </div>
            </div>
        </div>

        <!-- Timeline -->
        <div class="px-4 py-5 sm:p-6">
            <h4 class="text-base font-semibold text-gray-700 dark:text-gray-300 mb-4">Queue Timeline</h4>
            <div class="flow-root">
                <ul class="-mb-8">
                    <li>
                        <div class="relative pb-8">
                            <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200 dark:bg-gray-700" aria-hidden="true"></span>
                            <div class="relative flex space-x-3">
                                <div>
                                    <span class="h-8 w-8 rounded-full bg-green-500 flex items-center justify-center ring-8 ring-white dark:ring-gray-800">
                                        <svg class="h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                </div>
                                <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Added to Queue</p>
                                    </div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $appointment_queue->created_at->format('M d, g:i A') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>

                    @if($appointment_queue->started_at)
                        <li>
                            <div class="relative pb-8">
                                @if($appointment_queue->completed_at || $appointment_queue->cancelled_at)
                                    <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200 dark:bg-gray-700" aria-hidden="true"></span>
                                @endif
                                <div class="relative flex space-x-3">
                                    <div>
                                    <span class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center ring-8 ring-white dark:ring-gray-800">
                                        <svg class="h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                    </div>
                                    <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Consultation Started</p>
                                        </div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ Carbon\Carbon::parse($appointment_queue->started_at)->format('M d, g:i A') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endif

                    @if($appointment_queue->completed_at)
                        <li>
                            <div class="relative">
                                <div class="relative flex space-x-3">
                                    <div>
                                    <span class="h-8 w-8 rounded-full bg-green-500 flex items-center justify-center ring-8 ring-white dark:ring-gray-800">
                                        <svg class="h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                    </div>
                                    <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Consultation Completed</p>
                                        </div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ Carbon\Carbon::parse($appointment_queue->completed_at)->format('M d, g:i A') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @elseif($appointment_queue->cancelled_at)
                        <li>
                            <div class="relative">
                                <div class="relative flex space-x-3">
                                    <div>
                                    <span class="h-8 w-8 rounded-full bg-red-500 flex items-center justify-center ring-8 ring-white dark:ring-gray-800">
                                        <svg class="h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                    </div>
                                    <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Appointment Cancelled</p>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Reason: {{ $appointment_queue->cancellation_reason ?? 'No reason provided' }}</p>
                                        </div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ Carbon\Carbon::parse($appointment_queue->cancelled_at)->format('M d, g:i A') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
