<x-app-layout title="User Accounts">
    <div class="p-2 block sm:flex items-center justify-between w-full">
        <div class="w-full">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg min-h-[calc(100vh-2rem)]">
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
