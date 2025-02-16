<!-- Category Filters -->
<div class="inline-flex space-x-2 bg-gray-900 p-2 rounded-xl">
    <label class="relative">
        <input type="radio"
               id="all"
               wire:model.live="category"
               value=""
               class="absolute opacity-0 w-full h-full cursor-pointer peer">
        <span class="px-4 py-1 rounded-lg bg-gray-700 text-sm text-gray-300 block hover:bg-gray-600 hover:text-white transition-colors duration-200 peer-focus:ring-2 peer-focus:ring-white peer-checked:bg-white peer-checked:text-gray-900">
            All
        </span>
    </label>

    <label class="relative">
        <input type="radio"
               id="barangay-official"
               wire:model.live="category"
               value="barangay-official"
               class="absolute opacity-0 w-full h-full cursor-pointer peer">
        <span class="px-4 py-1 rounded-lg bg-gray-700 text-sm text-gray-300 block hover:bg-gray-600 hover:text-white transition-colors duration-200 peer-focus:ring-2 peer-focus:ring-blue-600 peer-checked:bg-blue-500 peer-checked:text-white">
            Barangay Officials
        </span>
    </label>

    <label class="relative">
        <input type="radio"
               id="bhw"
               wire:model.live="category"
               value="bhw"
               class="absolute opacity-0 w-full h-full cursor-pointer peer">
        <span class="px-4 py-1 rounded-lg bg-gray-700 text-sm text-gray-300 block hover:bg-gray-600 hover:text-white transition-colors duration-200 peer-focus:ring-2 peer-focus:ring-green-600 peer-checked:bg-green-500 peer-checked:text-white">
            BHW
        </span>
    </label>

    <label class="relative">
        <input type="radio"
               id="doctor"
               wire:model.live="category"
               value="doctor"
               class="absolute opacity-0 w-full h-full cursor-pointer peer">
        <span class="px-4 py-1 rounded-lg bg-gray-700 text-sm text-gray-300 block hover:bg-gray-600 hover:text-white transition-colors duration-200 peer-focus:ring-2 peer-focus:ring-purple-600 peer-checked:bg-purple-500 peer-checked:text-white">
            Doctor
        </span>
    </label>

    <label class="relative">
        <input type="radio"
               id="deleted"
               wire:model.live="category"
               value="deleted"
               class="absolute opacity-0 w-full h-full cursor-pointer peer">
        <span class="px-4 py-1 rounded-lg bg-gray-700 text-sm text-gray-300 block hover:bg-gray-600 hover:text-white transition-colors duration-200 peer-focus:ring-2 peer-focus:ring-red-600 peer-checked:bg-red-500 peer-checked:text-white">
            Deleted Accounts
        </span>
    </label>
</div>
