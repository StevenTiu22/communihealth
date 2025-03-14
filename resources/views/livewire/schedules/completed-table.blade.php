<!-- Completed Today -->
<div class="h-full flex flex-col bg-white dark:bg-gray-800 rounded-lg shadow border border-gray-200 dark:border-gray-700 overflow-hidden">
    <div class="p-3 bg-green-100 dark:bg-green-900 border-b border-green-200 dark:border-green-800 rounded-t-lg">
        <h3 class="font-semibold text-green-800 dark:text-green-200 flex items-center gap-2">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            {{ "Completed Today (" . $appointment_queues->count() . ")" }}
        </h3>
    </div>
    <div class="p-3 flex-1 overflow-y-auto space-y-2">
        <!-- Completed Items -->
        @forelse($appointment_queues as $appointment_queue)
            <div class="p-3 bg-white dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600 shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                <div class="flex justify-between items-start">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Completed</span>
                        </div>
                        <h4 class="font-medium mt-1">{{ $appointment_queue->appointment->patient->full_name }}</h4>
                        <div class="text-sm text-gray-600 dark:text-gray-300">{{ $appointment_queue->appointment->appointmentType->name }}</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ "Doctor: Dr. " . $appointment_queue->appointment->doctor->last_name }}</div>
                    </div>
                </div>
                <div class="mt-2 pt-2 border-t border-gray-200 dark:border-gray-600 text-xs text-gray-500 dark:text-gray-400">
                    <div class="grid grid-cols-2 gap-1">
                        <div>{{ "Time-in: " . \Carbon\Carbon::createFromTimestamp($appointment_queue->appointment->time_in)->format('g:i A') }}</div>
                        <div>{{ "Time-out: " . \Carbon\Carbon::createFromTimestamp($appointment_queue->appointment->time_out)->format('g:i A') ?? 'N/A' }}</div>
                        <div>{{ "Duration: " . $appointment_queue->appointment->appointmentType->duration_minutes . " minutes" }}</div>
                    </div>
                </div>
            </div>
        @empty
            <div class="p-3 bg-white dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600 shadow-sm">
                <div class="flex items-center justify-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1v-3a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <span>No more completed appointments today</span>
                </div>
            </div>
        @endforelse
    </div>
</div>
