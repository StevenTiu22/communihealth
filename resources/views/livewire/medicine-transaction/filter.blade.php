<div class="flex-shrink-0 w-full md:w-auto">
    <div class="flex items-end justify-between">
        <div>
            <label for="date-range" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Filter by Date</label>
            <select id="date-range" wire:model.live="dateRange" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm rounded-md">
                <option value="">All Time</option>
                <option value="today">Today</option>
                <option value="this-week">This Week</option>
                <option value="this-month">This Month</option>
                <option value="last-month">Last Month</option>
                <option value="this-year">This Year</option>
            </select>
        </div>
    </div>
</div>
