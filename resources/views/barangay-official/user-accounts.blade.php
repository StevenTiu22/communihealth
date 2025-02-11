<x-app-layout title="User Accounts">
    <x-sidebar />
    <div class="p-4 block sm:flex items-center justify-between">
        <div class="w-full">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg min-h-[calc(100vh-2rem)] w-full">
                <div class="p-6 text-gray-900 dark:text-gray-100 h-full">
                    <div class="flex justify-between items-center mb-2">
                        <h2 class="text-3xl font-semibold">User Accounts</h2>
                        <livewire:users.add />
                    </div>
                    <div class="mb-6">
                        <p class="text-gray-400">
                            Find and manage all accounts here.
                        </p>
                    </div>
                    <div class="mb-6">
                        <!-- Category Count Component -->
                        <livewire:users.category-count />
                    </div>
                    <hr class="border-gray-700 mb-6">
                    <div class="mt-6">
                        <!-- Header -->
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-xl font-semibold text-white">{{__('All Accounts (' . $user_count . ')')}}</h2>
                        </div>
                        <div class="mb-4 flex items-center space-x-4">
                            <div class="flex-grow">
                                <livewire:users.category-filter />
                            </div>
                            <div class="flex items-center space-x-2 flex-shrink-0">
                                <livewire:users.search />
                                <livewire:users.sort />
                            </div>
                        </div>
                        <!-- Table -->
                        <livewire:users.table />
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
