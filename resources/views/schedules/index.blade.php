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
                                <!-- Search Box -->
                                <livewire:schedules.search />
                            </div>

                            <div class="flex gap-3">
                                <div class="text-sm font-medium text-gray-700 dark:text-gray-300 flex flex-col items-end"
                                     x-data="{
                                        currentDate: '',
                                        currentTime: '',
                                        updateDateTime() {
                                            const now = new Date();
                                            // Convert to Manila time (UTC+8)
                                            const manilaTime = new Date(now.getTime() + (now.getTimezoneOffset() * 60000) + (8 * 3600000));

                                            // Format date: March 10, 2025
                                            const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                                            this.currentDate = `${months[manilaTime.getMonth()]} ${manilaTime.getDate()}, ${manilaTime.getFullYear()}`;

                                            // Format time: 4:12 PM (UTC+8)
                                            let hours = manilaTime.getHours();
                                            const minutes = manilaTime.getMinutes().toString().padStart(2, '0');
                                            const ampm = hours >= 12 ? 'PM' : 'AM';
                                            hours = hours % 12;
                                            hours = hours ? hours : 12; // Convert 0 to 12
                                            this.currentTime = `${hours}:${minutes} ${ampm} (UTC+8)`;
                                        }
                                     }"
                                     x-init="updateDateTime(); setInterval(() => updateDateTime(), 1000)">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <span x-text="currentDate">{{ now()->setTimezone('Asia/Manila')->format('F d, Y') }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span x-text="currentTime">{{ now()->setTimezone('Asia/Manila')->format('h:i A') }} (UTC+8)</span>
                                    </div>
                                </div>
                                @role('bhw')
                                <!-- Add to Queue Button -->
                                    <livewire:schedules.add-queue />
                                @endrole
                            </div>
                        </div>

                        <!-- Filter Options -->
                        <livewire:schedules.filter />
                    </div>

                    <!-- Queue Display -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 h-[calc(75vh-9rem)]">
                        <!-- Waiting Queue -->
                        <livewire:schedules.waiting-table />

                        <!-- In Progress Queue -->
                        <livewire:schedules.in-progress-table />

                        <!-- Completed Queue -->
                        <livewire:schedules.completed-table />
                    </div>

                    <!-- Success Message -->
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
