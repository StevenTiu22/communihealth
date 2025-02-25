<div class="relative" x-data="{ open: false }">
    <button @click="open = !open" class="bg-gray-100 px-4 py-2 rounded-md">
        Filters
    </button>

    <div x-show="open"
         @click.away="open = false"
         class="absolute z-50 mt-2 bg-white rounded-md shadow-lg p-4 w-64">
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Gender</label>
                <select wire:model.live="gender" class="w-full rounded-md">
                    <option value="">All</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Age Range</label>
                <div class="flex space-x-2">
                    <input type="number" wire:model.live="age_from" placeholder="From" class="w-1/2 rounded-md">
                    <input type="number" wire:model.live="age_to" placeholder="To" class="w-1/2 rounded-md">
                </div>
            </div>

            <div class="flex justify-between">
                <button wire:click="resetFilters" class="text-gray-600 text-sm">Reset</button>
                <button wire:click="applyFilters" class="bg-blue-500 text-white px-4 py-2 rounded-md">Apply</button>
            </div>
        </div>
    </div>
</div>
