<div>
    <select wire:model.live="selectedSchedule" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
        @forelse($appointments as $appointment)
            <option value="">Select Scheduled Appointments</option>
            <option value="{{ $appointment->schedule->id }}">
                {{ $appointment->schedule->date->format('M d, Y') }} - {{ $appointment->schedule->format('h:i A') }}
            </option>
        @empty
            <option value="" selected disabled>No available appointments.</option>
        @endforelse
    </select>
</div> 