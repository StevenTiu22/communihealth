<x-app-layout title="Health Records">
    <div class="py-6 bg-gray-100 dark:bg-gray-800 rounded-md h-screen">
        <div class="flex justify-between items-center mb-4">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 ml-8">
                {{__('Health Records')}}
            </h2>
            <livewire:health-records.generate-report />
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
            <div class="bg-gray-700 shadow-sm rounded-lg rounded-b-lg">
                    <!-- Table or record list content -->
                    <livewire:health-records.table />
            </div>
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
</x-app-layout>
