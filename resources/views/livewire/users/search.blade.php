<!-- Search Bar -->
<div class="relative flex-shrink-0">
    <div class="absolute inset-y-0 left-3 flex items-center pr-3">
        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
        </svg>
    </div>
    <input
        type="text"
        placeholder="Search for accounts..."
        wire:model.live="search"
        class="w-80 px-10 py-2 h-[40px] bg-gray-700 text-sm text-gray-200 rounded-lg border border-gray-600 focus:outline-none focus:border-gray-500 focus:ring-1 focus:ring-gray-500 placeholder-gray-400"
    >
</div>
