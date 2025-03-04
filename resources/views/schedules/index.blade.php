<x-app-layout title={{__($title)}}>
    <div class="p-4 block sm:flex items-center justify-between">
        <div class="w-full">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg h-[calc(97vh-1rem)] w-full">
                <div class="p-6 text-gray-900 dark:text-gray-100 h-full">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold">Schedules</h2>
                    </div>
                    <!-- Search and Action Buttons -->
                    <div class="flex flex-col gap-4 mb-6">
                        <div class="flex justify-between items-center gap-3">
                            <div class="flex-1">

                            </div>

                            <div class="flex gap-3">

                            </div>
                        </div>


                    </div>

                    <!-- Scheduling Table -->


                    <!-- Success Message -->
                    @if (session('success'))
                        <div class="fixed bottom-4 right-4 px-4 py-2 bg-green-100 border border-green-400 text-green-700 rounded-lg flex items-center gap-2" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)">
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
