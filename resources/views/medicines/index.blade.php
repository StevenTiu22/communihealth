<x-app-layout title={{__($title)}}>
    <div class="p-4 block sm:flex items-center justify-between">
        <div class="w-full">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg h-[calc(97vh-1rem)] w-full">
                <div class="p-6 text-gray-900 dark:text-gray-100 h-full">
                    <!-- Header Section -->
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold">Medicine Inventory</h2>

                        <!-- Action Buttons -->
                        <div class="flex items-center gap-3">
                            <livewire:medicines.add-category />
                            <livewire:medicines.add />
                        </div>
                    </div>

                    <!-- Search and Filter Section -->
                    <div class="space-y-4">
                        <!-- Search Bar -->
                        <div class="w-full max-w-md">
                            <livewire:medicines.search />
                        </div>

                        <!-- Filters -->
                        <livewire:medicines.filter />
                    </div>

                    <!-- Medicine Table with top margin -->
                    <div class="mt-6">
                        <livewire:medicines.table />
                    </div>

                    <!-- Message -->
                    @if(session('success'))
                        <div role="alert" class="alert alert-success fixed bottom-5 left-5 z-50 max-w-sm"
                             x-data="{
                                show: true,
                                hide() {
                                    this.show = false;
                                }
                            }"
                             x-init="setTimeout(() => hide(), 3000)"
                             x-show="show"
                             x-transition:enter="transform transition ease-out duration-300"
                             x-transition:enter-start="translate-y-2 opacity-0"
                             x-transition:enter-end="translate-y-0 opacity-100"
                             x-transition:leave="transform transition ease-in duration-300"
                             x-transition:leave-start="translate-y-0 opacity-100"
                             x-transition:leave-end="translate-y-2 opacity-0"
                             style="display: none;"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-6 w-6 shrink-0 stroke-current"
                                fill="none"
                                viewBox="0 0 24 24">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-sm font-medium whitespace-normal break-words">{{ session('success') }}</span>
                        </div>
                    @elseif(session('error'))
                        <div role="alert" class="alert alert-error fixed bottom-5 left-5 z-50 max-w-sm"
                             x-data="{
                                show: true,
                                hide() {
                                    this.show = false;
                                }
                            }"
                             x-init="setTimeout(() => hide(), 3000)"
                             x-show="show"
                             x-transition:enter="transform transition ease-out duration-300"
                             x-transition:enter-start="translate-y-2 opacity-0"
                             x-transition:enter-end="translate-y-0 opacity-100"
                             x-transition:leave="transform transition ease-in duration-300"
                             x-transition:leave-start="translate-y-0 opacity-100"
                             x-transition:leave-end="translate-y-2 opacity-0"
                             style="display: none;"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-6 w-6 shrink-0 stroke-current"
                                fill="none"
                                viewBox="0 0 24 24">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-sm font-medium whitespace-normal break-words">{{ session('error') }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
