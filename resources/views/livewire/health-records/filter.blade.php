<div class="flex flex-row items-end gap-4">
    <!-- Date Range Filter -->
    <div class="w-36">
        <x-label for="dateFilter" :value="__('Date Range')" />
        <select
            wire:model.live="date"
            id="dateFilter"
            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm h-10"
        >
            <option value="">All Time</option>
            <option value="today">Today</option>
            <option value="week">This Week</option>
            <option value="month">This Month</option>
            <option value="year">This Year</option>
        </select>
    </div>

    <!-- Doctor Filter -->
    <div class="w-36">
        <x-label for="patients" :value="__('Patients')" />
        <select
            wire:model.live="patient"
            id="patients"
            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm h-10"
        >
            <option value="">All Patients</option>
            @forelse($patients as $patient)
                <option value="{{ $patient->id }}">{{ $patient->full_name }}</option>
            @empty
                <option disabled>No patients found</option>
            @endforelse
        </select>
    </div>
</div>
