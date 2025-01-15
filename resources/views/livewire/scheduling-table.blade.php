<div class="flex flex-col h-full">
    <div class="overflow-x-auto">
        <div class="inline-block min-w-full align-middle">
            <div class="overflow-hidden border border-gray-200 dark:border-gray-700 rounded-lg">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                    <thead class="bg-gray-100 dark:bg-gray-700 sticky top-0">
                        <tr>
                            <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">Patient</th>
                            <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">Doctor</th>
                            <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">Type</th>
                            <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">Schedule</th>
                            <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">Status</th>
                            <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">Time</th>
                            <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                        @forelse($appointments as $appointment)
                            <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                <td class="flex items-center p-4 mr-12 space-x-6 whitespace-nowrap">
                                    <img class="w-10 h-10 rounded-full" src="{{ $appointment->patient->profile_photo_url }}" alt="{{ $appointment->patient->full_name }}">
                                    <div class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                        <div class="text-base font-semibold text-gray-900 dark:text-white">
                                            {{ $appointment->patient->full_name }}
                                            @if($appointment->is_walk_in)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    Walk-in
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    Dr. {{ $appointment->doctor->user->full_name }}
                                </td>
                                <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $appointment->appointmentType->name }}
                                </td>
                                <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $appointment->schedule->date->format('M d, Y') }}
                                    <div class="text-sm text-gray-500">
                                        {{ $appointment->schedule->time->format('g:i A') }}
                                    </div>
                                </td>
                                <td class="p-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs rounded-full
                                        {{ $appointment->status === 'scheduled' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $appointment->status === 'in_progress' ? 'bg-blue-100 text-blue-800' : '' }}
                                        {{ $appointment->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $appointment->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                        {{ ucfirst($appointment->status) }}
                                    </span>
                                </td>
                                <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <livewire:appointment-check-in-out :appointment="$appointment" :key="$appointment->id" />
                                </td>
                                <td class="p-4 space-x-2 whitespace-nowrap">
                                    <div class="flex space-x-2">
                                        <button class="text-indigo-600 hover:text-indigo-900">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </button>
                                        <button class="text-blue-600 hover:text-blue-900">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-4 text-center text-gray-500 dark:text-gray-400">
                                    No appointments found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Active Filters -->
    <div class="mt-2 px-2">
        @if($selectedDoctor || $filter !== 'all' || $dateRange !== 'today')
            <div class="flex items-center gap-2 text-xs text-gray-600 dark:text-gray-400">
                <span>Active Filters:</span>
                @if($selectedDoctor)
                    <span class="px-2 py-0.5 bg-blue-100 text-blue-800 rounded-full dark:bg-blue-900 dark:text-blue-300">
                        Doctor: {{ $doctors->firstWhere('id', $selectedDoctor)->user->full_name ?? '' }}
                    </span>
                @endif
                @if($filter !== 'all')
                    <span class="px-2 py-0.5 bg-blue-100 text-blue-800 rounded-full dark:bg-blue-900 dark:text-blue-300">
                        Type: {{ ucfirst($filter) }}
                    </span>
                @endif
                @if($dateRange !== 'today')
                    <span class="px-2 py-0.5 bg-blue-100 text-blue-800 rounded-full dark:bg-blue-900 dark:text-blue-300">
                        Period: {{ ucfirst($dateRange) }}
                    </span>
                @endif
            </div>
        @endif
    </div>

    <!-- Pagination -->
    <div class="mt-2 px-2">
        {{ $appointments->links() }}
    </div>
</div>