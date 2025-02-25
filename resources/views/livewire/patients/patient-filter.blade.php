<div class="flex items-center gap-4">
    <div>
        <select wire:model.live="gender" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <option value="">All Genders</option>
            <option value="0">Male</option>
            <option value="1">Female</option>
        </select>
    </div>

    <div>
        <select wire:model.live="age" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <option value="">All Ages</option>
            <option value="child">Children (0-17)</option>
            <option value="adult">Adults (18-59)</option>
            <option value="senior">Senior (60+)</option>
        </select>
    </div>

    <div>
        <select wire:model.live="is_4ps" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <option value="">All 4Ps Status</option>
            <option value="1">4Ps Member</option>
            <option value="0">Non-4Ps</option>
        </select>
    </div>

    <div>
        <select wire:model.live="is_nhts" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <option value="">All NHTS Status</option>
            <option value="1">NHTS Member</option>
            <option value="0">Non-NHTS</option>
        </select>
    </div>

    @if($gender || $age || $is_4ps || $is_nhts)
        <button 
            wire:click="resetFilters"
            class="px-3 py-2 text-sm font-medium text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 bg-red-100 hover:bg-red-200 dark:bg-red-900 dark:hover:bg-red-800 rounded-lg"
        >
            Reset Filters
        </button>
    @endif
</div>
