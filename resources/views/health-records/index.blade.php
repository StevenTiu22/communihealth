<x-app-layout title="Health Records">
    <div class="py-6 bg-gray-100 dark:bg-gray-800 rounded-md">
        <div class="flex justify-between items-center mb-4">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 ml-8">
                {{__('Health Records')}}
            </h2>
        </div>

        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex flex-row items-end gap-4 overflow-x-auto">
                        <!-- Search field -->
                        <livewire:health-records.search />

                        <!-- Date Range Filter -->
                        <livewire:health-records.filter />
                    </div>
                </div>
            </div>

            <!-- Health records list or table with bg-gray-700 -->
            <div class="bg-gray-700 overflow-hidden shadow-sm rounded-lg rounded-b-lg">
                    <!-- Table or record list content -->
                    <livewire:health-records.table />
            </div>
        </div>
    </div>
</x-app-layout>
