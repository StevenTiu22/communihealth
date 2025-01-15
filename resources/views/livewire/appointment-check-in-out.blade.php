<div class="flex items-center space-x-2">
    @if(!$schedule)
        <button 
            wire:click="checkIn"
            class="px-3 py-1 text-sm bg-green-500 text-white rounded hover:bg-green-600"
        >
            Check In
        </button>
    @elseif(!$schedule->time_out)
        <button 
            wire:click="checkOut"
            class="px-3 py-1 text-sm bg-red-500 text-white rounded hover:bg-red-600"
        >
            Check Out
        </button>
    @else
        <div class="text-sm text-gray-600">
            <div>In: {{ $schedule->time_in->format('g:i A') }}</div>
            <div>Out: {{ $schedule->time_out->format('g:i A') }}</div>
        </div>
    @endif
</div> 