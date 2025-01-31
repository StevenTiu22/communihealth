<x-app-layout title={{ __($title) }}>
    <x-staff-sidebar />
    <div class="p-4 block sm:flex items-center justify-between">
        <div class="w-full">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg h-[calc(97vh-1rem)] w-full">
                <div class="p-6 text-gray-900 dark:text-gray-100 h-full">
                    <!-- Header Section -->
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold">Medicine Inventory</h2>

                        <!-- Action Buttons -->
                        <div class="flex items-center gap-3">
                            <livewire:add-category-modal />
                            <livewire:add-medicine-modal />
                        </div>
                    </div>

                    <!-- Search and Filter Section -->
                    <div class="space-y-4">
                        <!-- Search Bar -->
                        <div class="w-full max-w-md">
                            <livewire:medicine-search />
                        </div>

                        <!-- Filters -->
                        <livewire:medicine-filter />
                    </div>

                    <!-- Medicine Table with top margin -->
                    <div class="mt-6">
                        <livewire:medicine-table />
                    </div>

                    <!-- Success Message -->
                    @if (session('success'))
                        <div class="fixed bottom-4 right-4 px-4 py-2 bg-green-100 border border-green-400 text-green-700 rounded-lg flex items-center gap-2"
                             x-data="{ show: true }"
                             x-show="show"
                             x-init="setTimeout(() => show = false, 3000)"
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 transform translate-x-2"
                             x-transition:enter-end="opacity-100 transform translate-x-0"
                             x-transition:leave="transition ease-in duration-200"
                             x-transition:leave-start="opacity-100 transform translate-x-0"
                             x-transition:leave-end="opacity-0 transform translate-x-2">
                            <span class="flex items-center gap-2">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                {{ session('success') }}
                            </span>
                            <button @click="show = false" class="text-green-700 hover:text-green-900">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
