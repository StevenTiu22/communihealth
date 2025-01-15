<div class="p-4">
    <div class="mb-4 flex gap-4">
        <input 
            type="text" 
            wire:model.live.debounce.300ms="search" 
            placeholder="Search patients..."
            class="rounded-md border-gray-300 shadow-sm"
        >
        
        <select wire:model.live="filter" class="rounded-md border-gray-300 shadow-sm">
            <option value="all">All Appointments</option>
            <option value="walk-in">Walk-ins</option>
            <option value="scheduled">Scheduled</option>
        </select>

        <select wire:model.live="dateRange" class="rounded-md border-gray-300 shadow-sm">
            <option value="today">Today</option>
            <option value="week">This Week</option>
            <option value="month">This Month</option>
            <option value="all">All Time</option>
        </select>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Patient
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Doctor
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Type
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Date & Time
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Recorded By
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Check In/Out
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($appointments as $appointment)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            Dr. {{ $appointment->doctor->first_name }} {{ $appointment->doctor->last_name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $appointment->appointmentType->name }}
                            @if($appointment->is_walk_in)
                                <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded">Walk-in</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $appointment->appointment_date->format('M d, Y') }}
                            {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $appointment->bhw->first_name }} {{ $appointment->bhw->last_name }}
                            <div class="text-xs text-gray-500">
                                {{ $appointment->recorded_at->format('M d, Y g:i A') }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $appointment->status === 'scheduled' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $appointment->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $appointment->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}
                            ">
                                {{ ucfirst($appointment->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <livewire:appointment-check-in-out :appointment="$appointment" :key="$appointment->id" />
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $appointments->links() }}
    </div>
</div> 