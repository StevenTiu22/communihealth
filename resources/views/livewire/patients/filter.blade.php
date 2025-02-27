<div class="relative" x-data="{ open: false }">
    <button @click="open = !open" class="bg-blue-800 hover:bg-blue-900 text-white px-4 py-2 rounded-md">
        Filters
    </button>

    <div x-show="open"
         @click.away="open = false"
         class="absolute z-50 mt-2 bg-gray-900 rounded-md shadow-lg p-4 w-64 border border-gray-700">
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-200">Gender</label>
                <select wire:model.live="gender" class="w-full rounded-md bg-gray-800 border-gray-700 text-gray-200 focus:border-blue-500 focus:ring-blue-500 mt-2">
                    <option value="">All</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-200">Age Range</label>
                <div class="flex space-x-2 mt-2">
                    <input type="number" wire:model.live="age_from" placeholder="From" class="w-1/2 rounded-md bg-gray-800 border-gray-700 text-gray-200 placeholder-gray-500 focus:border-blue-500 focus:ring-blue-500">
                    <input type="number" wire:model.live="age_to" placeholder="To" class="w-1/2 rounded-md bg-gray-800 border-gray-700 text-gray-200 placeholder-gray-500 focus:border-blue-500 focus:ring-blue-500">
                </div>
            </div>

            <div class="flex justify-between">
                <button wire:click="resetFilters" class="text-gray-400 hover:text-red-500 text-sm">Reset</button>
                <button wire:click="applyFilters" @click="open = false" class="bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded-md">Apply</button>
            </div>
        </div>
    </div>
</div>
