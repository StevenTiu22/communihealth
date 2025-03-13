<div class="h-full flex flex-col bg-white dark:bg-gray-800 rounded-lg shadow border border-gray-200 dark:border-gray-700 overflow-hidden">
    <div class="p-3 bg-yellow-100 dark:bg-yellow-900 border-b border-yellow-200 dark:border-yellow-800 rounded-t-lg">
        <h3 class="font-semibold text-yellow-800 dark:text-yellow-200 flex items-center gap-2">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
            </svg>
            {{ "Waiting (" . $appointment_queues->count() . ")" }}
        </h3>
    </div>
    <div class="p-3 flex-1 overflow-y-auto space-y-2">
        @forelse($appointment_queues as $appointment_queue)
            <div wire:key="{{ $appointment_queue->id }}" class="p-4 bg-white dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600 shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                <div class="flex justify-between items-start">
                    <!-- Left side with patient info -->
                    <div class="flex-grow">
                        <div class="flex items-center gap-2">
                            <span class="bg-amber-100 text-amber-800 text-xs font-medium px-2 py-0.5 rounded dark:bg-amber-900 dark:text-amber-300">In Progress</span>
                        </div>
                        <h4 class="font-medium mt-1.5">{{ $appointment_queue->appointment->patient->full_name }}</h4>
                        <div class="text-sm text-gray-600 dark:text-gray-300">{{ $appointment_queue->appointment->appointmentType->name }}</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">
                            {{ "Doctor: Dr. " . $appointment_queue->appointment->doctor->last_name }}
                        </div>
                        <!-- Separator line -->
                        <div class="border-t border-gray-200 dark:border-gray-600 my-2"></div>

                        <div class="flex flex-col gap-1">

                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                {{ "Time-in: " . \Carbon\Carbon::createFromTimestamp($appointment_queue->appointment->time_in)->addHours(8)->format('g:i A') }}
                            </div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                {{ "Duration: " . $appointment_queue->appointment->appointmentType->duration_minutes . " minutes" }}
                            </div>
                        </div>
                    </div>

                    <!-- Right side with action buttons -->
                    <div class="flex items-start">
                        <div class="flex flex-col gap-2 ml-4">
                            <button
                                type="button"
                                wire:click="start({{ $appointment_queue->id }})"
                                class="bg-blue-600 hover:bg-blue-700 focus:ring focus:ring-blue-300 rounded-full focus:outline-none dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-700 text-white text-sm px-3 py-1.5 font-medium w-full"
                            >
                                Start
                            </button>
                            <livewire:schedules.show :appointment_queue_id="$appointment_queue->id" :wire:key="'show-'.$appointment_queue->id" />
                            <livewire:schedules.cancel-appointment :appointment_id="$appointment_queue->appointment->id" :wire:key="'cancel-'.$appointment_queue->id" />
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="p-3 bg-white dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600 shadow-sm">
                <div class="flex items-center justify-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1v-3a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <span>No more waiting appointments today</span>
                </div>
            </div>
        @endforelse
    </div>
</div>
