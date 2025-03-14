<x-app-layout :title="$title">
    <x-sidebar />
    <div class="flex">
        <div class="flex-grow p-4">
            <!-- White Header -->
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 mb-6">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-white">Audit Trail</h2>
            </div>

            <!-- Livewire Component -->
            <livewire:audit-trail.table />
        </div>
        <x-sidebar />
    </div>
</x-app-layout>
