<x-app-layout title="Patient Records">
    <x-staff-sidebar />
    <div class="p-4 sm:flex items-center justify-between">
        <div class="w-full">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg h-[calc(100vh-2rem)] w-full">
                <div class="p-6 text-gray-900 dark:text-gray-100 h-full flex flex-col">
                    <!-- Header -->
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold">Patient Records</h2>
                    </div>

                    <!-- Search and Filter Section -->
                    <div class="mb-4">
                        <div class="flex items-center justify-between gap-4">
                            <div class="flex items-center gap-4">
                                <livewire:patient-search />
                                <livewire:patient-filter />
                            </div>
                            <livewire:add-patient-modal />
                        </div>
                    </div>

                    <!-- Patient Records Table -->
                    <div class="flex-1 overflow-auto">
                        <livewire:patient-table />
                    </div>

                    <!-- Success Message -->
                    @if (session('success'))
                        <div class="fixed bottom-4 right-4 px-4 py-2 bg-green-100 border border-green-400 text-green-700 rounded-lg flex items-center gap-2" 
                             x-data="{ show: true }" 
                             x-show="show" 
                             x-init="setTimeout(() => show = false, 3000)">
                            {{ session('success') }}
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