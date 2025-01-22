<x-app-layout title="User Accounts">
    <x-sidebar />
    <div class="p-4 block sm:flex items-center justify-between">
        <div class="w-full">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg h-[calc(97vh-1rem)] w-full">
                <div class="p-6 text-gray-900 dark:text-gray-100 h-full">
                    <div class="flex justify-between items-center mb-2">
                        <h2 class="text-3xl font-semibold">User Accounts</h2>
                    </div>
                    <div class="mb-6">
                        <p class="text-gray-400">
                            Find and manage all accounts here.
                        </p>
                    </div>
                    <div class="mb-6">
                        <!-- Large container rectangle -->
                        <div class="bg-gray-900 rounded-lg p-5">
                            <!-- Grid of 4 rectangles -->
                            <div class="grid grid-cols-4 gap-6">
                                <!-- Barangay Officials -->
                                <div class="bg-blue-600 rounded-lg p-4 h-28 flex items-center">
                                    <div class="flex flex-col">
                                        <span class="text-gray-100 text-lg mb-1">Barangay Officials</span>
                                        <span class="text-white text-4xl font-bold">15</span>
                                    </div>
                                </div>
                                <!-- BHW -->
                                <div class="bg-green-600 rounded-lg p-4 h-28 flex items-center">
                                    <div class="flex flex-col">
                                        <span class="text-gray-100 text-lg mb-1">BHW</span>
                                        <span class="text-white text-4xl font-bold">8</span>
                                    </div>
                                </div>
                                <!-- Doctor -->
                                <div class="bg-purple-600 rounded-lg p-4 h-28 flex items-center">
                                    <div class="flex flex-col">
                                        <span class="text-gray-100 text-lg mb-1">Doctor</span>
                                        <span class="text-white text-4xl font-bold">3</span>
                                    </div>
                                </div>
                                <!-- Deleted Accounts -->
                                <div class="bg-red-600 rounded-lg p-4 h-28 flex items-center">
                                    <div class="flex flex-col">
                                        <span class="text-gray-100 text-lg mb-1">Deleted Accounts</span>
                                        <span class="text-white text-4xl font-bold">2</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="border-gray-700 mb-6">
                    <div class="mt-6">
                        <!-- Table Header -->
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-xl font-semibold text-white">All Accounts (28)</h2>
                        </div>
                        <livewire:users.category-filter />
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
