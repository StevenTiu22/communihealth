<div class="bg-white p-4 rounded-lg shadow mb-6">
    <!-- Toggle Button -->
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-medium text-gray-900">Filters</h3>
        <button 
            wire:click="toggleFilters"
            class="text-gray-500 hover:text-gray-700"
        >
            <svg class="w-5 h-5 transform transition-transform duration-200 {{ $isExpanded ? 'rotate-180' : '' }}" 
                fill="none" 
                stroke="currentColor" 
                viewBox="0 0 24 24"
            >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>
    </div>

    <!-- Filters Content -->
    <div x-show="$wire.isExpanded" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 transform -translate-y-2"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform -translate-y-2"
    >
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Doctor Filter -->
            <div>
                <label for="doctor" class="block text-sm font-medium text-gray-700 mb-1">Doctor</label>
                <select
                    id="doctor"
                    wire:model.live="selectedDoctor"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                >
                    @forelse($doctors as $doctor)
                        <option value="">All Doctors</option>
                        <option value="{{ $doctor->id }}">Dr. {{ $doctor->user->full_name }}</option>
                    @empty
                        <option value="" selected disabled>No doctors available</option>
                    @endforelse
                </select>
            </div>

            <!-- Date Range Filter -->
            <div>
                <label for="dateRange" class="block text-sm font-medium text-gray-700 mb-1">Time Period</label>
                <select
                    id="dateRange"
                    wire:model.live="dateRange"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                >
                    <option value="today">Today</option>
                    <option value="tomorrow">Tomorrow</option>
                    <option value="week">This Week</option>
                    <option value="month">This Month</option>
                    <option value="all">All Time</option>
                </select>
            </div>

            <!-- Appointment Type Filter -->
            <div>
                <label for="filter" class="block text-sm font-medium text-gray-700 mb-1">Appointment Type</label>
                <select
                    id="filter"
                    wire:model.live="filter"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                >
                    <option value="all">All Types</option>
                    <option value="scheduled">Scheduled</option>
                    <option value="walk-in">Walk-in</option>
                </select>
            </div>

            <!-- Reset Button -->
            <div class="flex items-end">
                <x-danger-button wire:click="resetFilters">
                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    Reset Filters
                </x-danger-button>
            </div>
        </div>
    </div>
</div> 