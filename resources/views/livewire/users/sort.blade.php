<!-- sort.blade.php -->
<div class="relative" x-data="{ open: @entangle('isOpen') }">
    <button
        wire:click="toggleDropdown"
        class="p-2 h-[42px] w-[42px] bg-gray-700 text-gray-300 rounded-lg border border-gray-600 hover:bg-gray-600 hover:text-white transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-gray-500 inline-flex items-center justify-center"
    >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path d="M5 4a1 1 0 00-2 0v7.268a2 2 0 000 3.464V16a1 1 0 102 0v-1.268a2 2 0 000-3.464V4zM11 4a1 1 0 10-2 0v1.268a2 2 0 000 3.464V16a1 1 0 102 0V8.732a2 2 0 000-3.464V4zM16 3a1 1 0 011 1v7.268a2 2 0 010 3.464V16a1 1 0 11-2 0v-1.268a2 2 0 010-3.464V4a1 1 0 011-1z" />
        </svg>
    </button>

    <!-- Dropdown menu -->
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        @click.away="open = false"
        class="absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-gray-700 ring-1 ring-black ring-opacity-5 z-50"
    >
        <div class="py-1">
            <button
                wire:click="sort('latest_login')"
                class="w-full text-left px-4 py-2 text-sm {{ $sort_by === 'latest_login' ? 'bg-gray-600 text-white' : 'text-gray-300' }} hover:bg-gray-600 hover:text-white flex items-center space-x-2"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 11-2 0V4H4v12h11v-2a1 1 0 112 0v3a1 1 0 01-1 1H4a1 1 0 01-1-1V3z" />
                </svg>
                <span>Last Login (Latest)</span>
            </button>
            <button
                wire:click="sort('oldest_login')"
                class="w-full text-left px-4 py-2 text-sm {{ $sort_by === 'oldest_login' ? 'bg-gray-600 text-white' : 'text-gray-300' }} hover:bg-gray-600 hover:text-white flex items-center space-x-2"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 11-2 0V4H4v12h11v-2a1 1 0 112 0v3a1 1 0 01-1 1H4a1 1 0 01-1-1V3z" />
                </svg>
                <span>Last Login (Oldest)</span>
            </button>
            <button
                wire:click="sort('newest')"
                class="w-full text-left px-4 py-2 text-sm {{ $sort_by === 'newest' ? 'bg-gray-600 text-white' : 'text-gray-300' }} hover:bg-gray-600 hover:text-white flex items-center space-x-2"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                </svg>
                <span>Created (Newest)</span>
            </button>
            <button
                wire:click="sort('oldest')"
                class="w-full text-left px-4 py-2 text-sm {{ $sort_by === 'oldest' ? 'bg-gray-600 text-white' : 'text-gray-300' }} hover:bg-gray-600 hover:text-white flex items-center space-x-2"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                </svg>
                <span>Created (Oldest)</span>
            </button>
        </div>
    </div>
</div>
