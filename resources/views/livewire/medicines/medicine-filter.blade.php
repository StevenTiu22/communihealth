<div class="bg-white p-4 rounded-lg shadow mb-4 space-y-4" x-data="{ isOpen: true }">
    <div class="flex items-center justify-between">
        <button 
            @click="isOpen = !isOpen"
            class="flex items-center gap-2 text-lg font-semibold text-gray-900 focus:outline-none"
            :aria-expanded="isOpen"
            aria-controls="filter-panel"
        >
            <h3 class="flex items-center gap-2">
                <svg 
                    xmlns="http://www.w3.org/2000/svg" 
                    class="h-5 w-5 transition-transform duration-200"
                    :class="{ 'transform rotate-180': !isOpen }"
                    viewBox="0 0 20 20" 
                    fill="currentColor"
                >
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
                Filters
            </h3>
        </button>
        <div class="flex items-center gap-2">
            <button 
                wire:click="resetFilters" 
                class="text-sm text-gray-600 hover:text-gray-900 flex items-center gap-1"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
                </svg>
                Reset
            </button>
        </div>
    </div>

    <div 
        id="filter-panel"
        x-show="isOpen"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="transform opacity-0 -translate-y-2"
        x-transition:enter-end="transform opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="transform opacity-100 translate-y-0"
        x-transition:leave-end="transform opacity-0 -translate-y-2"
        class="grid grid-cols-1 md:grid-cols-4 gap-4 pt-2"
    >
        <!-- Status Filter -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Status</label>
            <select 
                wire:model.live="selectedStatus" 
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            >
                <option value="">All Status</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>

        <!-- Category Filter -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Category</label>
            <select 
                wire:model.live="selectedCategory" 
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            >
                <option value="">All Categories</option>
                @forelse($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @empty
                    <option value="" disabled>No categories found</option>
                @endforelse
            </select>
        </div>

        <!-- Stock Filter -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Stock Status</label>
            <select 
                wire:model.live="selectedStock" 
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            >
                <option value="">All Stock</option>
                <option value="in_stock">In Stock</option>
                <option value="out_of_stock">Out of Stock</option>
                <option value="low_stock">Low Stock</option>
            </select>
        </div>

        <!-- Expiry Filter -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Expiry Status</label>
            <select 
                wire:model.live="selectedExpiry" 
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            >
                <option value="">All Expiry</option>
                <option value="active">Not Expired</option>
                <option value="expired">Expired</option>
                <option value="expiring_soon">Expiring Soon</option>
            </select>
        </div>
    </div>
</div>
