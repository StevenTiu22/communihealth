<!-- In Progress -->
<div class="h-full flex flex-col bg-white dark:bg-gray-800 rounded-lg shadow border border-gray-200 dark:border-gray-700 overflow-hidden">
    <div class="p-3 bg-amber-100 dark:bg-amber-900 border-b border-amber-200 dark:border-amber-800 rounded-t-lg">
        <h3 class="font-semibold text-amber-800 dark:text-amber-200 flex items-center gap-2">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M10 2a8 8 0 100 16 8 8 0 000-16zm1 10.414l2.293 2.293a1 1 0 001.414-1.414L12.414 11H15a1 1 0 100-2h-2.586l2.293-2.293a1 1 0 00-1.414-1.414L11 7.586V5a1 1 0 10-2 0v2.586L6.707 5.293a1 1 0 00-1.414 1.414L7.586 9H5a1 1 0 100 2h2.586l-2.293 2.293a1 1 0 001.414 1.414L9 12.414V15a1 1 0 102 0v-2.586z" clip-rule="evenodd"></path>
            </svg>
            {{ "In Progress (" . $appointment_queues->count() . ")" }}
        </h3>
    </div>
    <div class="p-3 flex-1 overflow-y-auto space-y-2">
        <!-- In Progress Items -->
        @forelse($appointment_queues as $appointment_queue)
            <div wire:key="{{ $appointment_queue->id }}" class="p-3 bg-white dark:bg-gray-700 rounded-lg border-l-4 border-amber-500 border-t border-r border-b dark:border-gray-600 shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                <div class="flex justify-between items-start">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="bg-amber-100 text-amber-800 text-xs font-medium px-2 py-0.5 rounded dark:bg-amber-900 dark:text-amber-300">In Progress</span>
                        </div>
                        <h4 class="font-medium mt-1">{{ $appointment_queue->appointment->patient->full_name }}</h4>
                        <div class="text-sm text-gray-600 dark:text-gray-300">{{ $appointment_queue->appointment->appointmentType->name }}</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ "Doctor: Dr. " . $appointment_queue->appointment->doctor->last_name }}</div>
                    </div>
                    <div class="flex flex-col gap-2">
                        @role('bhw')
                            @if(! $appointment_queue->appointment->vitalSign)
                                <livewire:schedules.add-vital-sign :appointment_id="$appointment_queue->appointment->id" :wire:key="'vital-sign-'.$appointment_queue->id" />
                            @endif
                        @endrole

                        @role('doctor')
                            @if(! $appointment_queue->appointment->treatmentRecord)
                                <livewire:schedules.add-treatment-record :appointment_id="$appointment_queue->appointment->id" :wire:key="'treatment-record-'.$appointment_queue->id" />
                            @endif
                        @endrole

                        <livewire:schedules.complete :appointment_queue_id="$appointment_queue->id" :wire:key="'complete-'.$appointment_queue->id" />
                    </div>
                </div>
                <div class="mt-2 pt-2 border-t border-gray-200 dark:border-gray-600">
                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ "Time-in: " . \Carbon\Carbon::createFromTimestamp($appointment_queue->appointment->time_in)->addHours(8)->format('g:i A') }}</div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ "Duration: " . $appointment_queue->appointment->appointmentType->duration_minutes . " minutes" }}</div>
                    @if ($appointment_queue->appointment->vitalSign)
                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ "Added vital sign: " . $appointment_queue->appointment->vitalSign->created_at->addHours(8)->format('g:i A') }}</div>
                    @endif
                    @if ($appointment_queue->appointment->treatmentRecord)
                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ "Added treatment record: " . $appointment_queue->appointment->treatmentRecord->created_at->addHours(8)->format('g:i A') }}</div>
                    @endif
                </div>
            </div>
        @empty
            <div class="p-3 bg-white dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600 shadow-sm">
                <div class="flex items-center justify-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1v-3a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <span>No more in progress appointments today</span>
                </div>
            </div>
        @endforelse
    </div>
</div>
