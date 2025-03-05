<x-app-layout title={{__($title)}}>
    <div class="p-4 block sm:flex items-center justify-between">
        <div class="w-full">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg h-[calc(97vh-1rem)] w-full">
                <div class="p-6 text-gray-900 dark:text-gray-100 h-full">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold">Schedules</h2>
                    </div>
                    <!-- Search and Action Buttons -->
                    <!-- Search and Action Buttons -->
                    <div class="flex flex-col gap-4 mb-6">
                        <div class="flex justify-between items-center gap-3">
                            <div class="flex-1">
                                <!-- Search Box -->
                                <livewire:scheduling.search />
                            </div>

                            <div class="flex gap-3">
                                <div class="text-sm font-medium text-gray-700 dark:text-gray-300 flex flex-col items-end">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <span>{{ now()->setTimezone('Asia/Manila')->format('F d, Y') }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span>{{ now()->setTimezone('Asia/Manila')->format('h:i A') }} (UTC+8)</span>
                                    </div>
                                </div>

                                <!-- Add to Queue Button -->
                                <x-button
                                    id="addToQueueBtn"
                                    color="indigo"
                                    class="flex items-center gap-2"
                                >
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    Add to Queue
                                </x-button>
                            </div>
                        </div>

                        <!-- Filter Options -->
                        <div class="flex flex-wrap gap-3">
                            <div x-data="{ open: false, selectedDoctor: 'All Doctors' }" class="relative">
                                <button @click="open = !open" @click.away="open = false" type="button" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700 flex items-center gap-2">
                                    <!-- Doctor icon added -->
                                    <svg class="w-4 h-4 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    <span x-text="selectedDoctor">All Doctors</span>
                                    <svg class="w-2.5 h-2.5 ms-1 transition-transform" :class="{ 'rotate-180': open }" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                    </svg>
                                </button>
                                <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute left-0 mt-2 z-10 bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700" style="display: none;">
                                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200">
                                        <li><a @click="selectedDoctor = 'All Doctors'; open = false" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white cursor-pointer">All Doctors</a></li>
                                        <li><a @click="selectedDoctor = 'Dr. Smith'; open = false" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white cursor-pointer">Dr. Smith</a></li>
                                        <li><a @click="selectedDoctor = 'Dr. Johnson'; open = false" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white cursor-pointer">Dr. Johnson</a></li>
                                        <li><a @click="selectedDoctor = 'Dr. Williams'; open = false" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white cursor-pointer">Dr. Williams</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Queue Display -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 h-[calc(75vh-9rem)]">
                        <!-- Waiting Queue -->
                        <div class="h-full flex flex-col bg-white dark:bg-gray-800 rounded-lg shadow border border-gray-200 dark:border-gray-700 overflow-hidden">
                            <div class="p-3 bg-yellow-100 dark:bg-yellow-900 border-b border-yellow-200 dark:border-yellow-800 rounded-t-lg">
                                <h3 class="font-semibold text-yellow-800 dark:text-yellow-200 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                    </svg>
                                    Waiting (5)
                                </h3>
                            </div>
                            <div class="p-3 flex-1 overflow-y-auto space-y-2">
                                <!-- Queue Items -->
                                <div class="p-3 bg-white dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600 shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">Queue #1</span>
                                                <span class="text-xs text-gray-500 dark:text-gray-400">9:30 AM</span>
                                            </div>
                                            <h4 class="font-medium mt-1">Juan Dela Cruz</h4>
                                            <div class="text-sm text-gray-600 dark:text-gray-300">Check-up</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">Added by: BHW Maria</div>
                                        </div>
                                        <div class="flex flex-col gap-2">
                                            <button type="button" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-2 focus:ring-blue-300 font-medium rounded-lg text-xs px-3 py-1 dark:bg-blue-500 dark:hover:bg-blue-600 focus:outline-none dark:focus:ring-blue-700">Start</button>
                                            <button type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-2 focus:ring-gray-300 font-medium rounded-lg text-xs px-3 py-1 border border-gray-300 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:bg-gray-600 focus:outline-none dark:focus:ring-gray-600">No Show</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="p-3 bg-white dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600 shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">Queue #2</span>
                                                <span class="text-xs text-gray-500 dark:text-gray-400">10:15 AM</span>
                                            </div>
                                            <h4 class="font-medium mt-1">Maria Santos</h4>
                                            <div class="text-sm text-gray-600 dark:text-gray-300">Consultation</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">Added by: BHW Jose</div>
                                        </div>
                                        <div class="flex flex-col gap-2">
                                            <button type="button" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-2 focus:ring-blue-300 font-medium rounded-lg text-xs px-3 py-1 dark:bg-blue-500 dark:hover:bg-blue-600 focus:outline-none dark:focus:ring-blue-700">Start</button>
                                            <button type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-2 focus:ring-gray-300 font-medium rounded-lg text-xs px-3 py-1 border border-gray-300 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:bg-gray-600 focus:outline-none dark:focus:ring-gray-600">No Show</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="p-3 bg-white dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600 shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">Queue #3</span>
                                                <span class="text-xs text-gray-500 dark:text-gray-400">11:20 AM</span>
                                            </div>
                                            <h4 class="font-medium mt-1">Pedro Reyes</h4>
                                            <div class="text-sm text-gray-600 dark:text-gray-300">Follow-up</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">Added by: BHW Maria</div>
                                        </div>
                                        <div class="flex flex-col gap-2">
                                            <button type="button" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-2 focus:ring-blue-300 font-medium rounded-lg text-xs px-3 py-1 dark:bg-blue-500 dark:hover:bg-blue-600 focus:outline-none dark:focus:ring-blue-700">Start</button>
                                            <button type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-2 focus:ring-gray-300 font-medium rounded-lg text-xs px-3 py-1 border border-gray-300 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:bg-gray-600 focus:outline-none dark:focus:ring-gray-600">No Show</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="p-3 bg-white dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600 shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">Queue #4</span>
                                                <span class="text-xs text-gray-500 dark:text-gray-400">1:45 PM</span>
                                            </div>
                                            <h4 class="font-medium mt-1">Ana Gonzales</h4>
                                            <div class="text-sm text-gray-600 dark:text-gray-300">Check-up</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">Added by: BHW Jose</div>
                                        </div>
                                        <div class="flex flex-col gap-2">
                                            <button type="button" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-2 focus:ring-blue-300 font-medium rounded-lg text-xs px-3 py-1 dark:bg-blue-500 dark:hover:bg-blue-600 focus:outline-none dark:focus:ring-blue-700">Start</button>
                                            <button type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-2 focus:ring-gray-300 font-medium rounded-lg text-xs px-3 py-1 border border-gray-300 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:bg-gray-600 focus:outline-none dark:focus:ring-gray-600">No Show</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- In Progress -->
                        <div class="h-full flex flex-col bg-white dark:bg-gray-800 rounded-lg shadow border border-gray-200 dark:border-gray-700 overflow-hidden">
                            <div class="p-3 bg-amber-100 dark:bg-amber-900 border-b border-amber-200 dark:border-amber-800 rounded-t-lg">
                                <h3 class="font-semibold text-amber-800 dark:text-amber-200 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M10 2a8 8 0 100 16 8 8 0 000-16zm1 10.414l2.293 2.293a1 1 0 001.414-1.414L12.414 11H15a1 1 0 100-2h-2.586l2.293-2.293a1 1 0 00-1.414-1.414L11 7.586V5a1 1 0 10-2 0v2.586L6.707 5.293a1 1 0 00-1.414 1.414L7.586 9H5a1 1 0 100 2h2.586l-2.293 2.293a1 1 0 001.414 1.414L9 12.414V15a1 1 0 102 0v-2.586z" clip-rule="evenodd"></path>
                                    </svg>
                                    In Progress (2)
                                </h3>
                            </div>
                            <div class="p-3 flex-1 overflow-y-auto space-y-2">
                                <!-- In Progress Items -->
                                <div class="p-3 bg-white dark:bg-gray-700 rounded-lg border-l-4 border-amber-500 border-t border-r border-b border-gray-200 dark:border-gray-600 shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <span class="bg-amber-100 text-amber-800 text-xs font-medium px-2 py-0.5 rounded dark:bg-amber-900 dark:text-amber-300">In Progress</span>
                                                <span class="text-xs text-gray-500 dark:text-gray-400">Since 2:30 PM</span>
                                            </div>
                                            <h4 class="font-medium mt-1">Carlo Mendoza</h4>
                                            <div class="text-sm text-gray-600 dark:text-gray-300">Consultation</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">Doctor: Dr. Smith</div>
                                        </div>
                                        <div class="flex flex-col gap-2">
                                            <button type="button" class="text-white bg-green-600 hover:bg-green-700 focus:ring-2 focus:ring-green-300 font-medium rounded-lg text-xs px-3 py-1 dark:bg-green-500 dark:hover:bg-green-600 focus:outline-none dark:focus:ring-green-700">Complete</button>
                                        </div>
                                    </div>
                                    <div class="mt-2 pt-2 border-t border-gray-200 dark:border-gray-600">
                                        <div class="text-xs text-gray-500 dark:text-gray-400">Time-in: 2:30 PM</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">Duration: 25 minutes</div>
                                    </div>
                                </div>

                                <div class="p-3 bg-white dark:bg-gray-700 rounded-lg border-l-4 border-amber-500 border-t border-r border-b border-gray-200 dark:border-gray-600 shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <span class="bg-amber-100 text-amber-800 text-xs font-medium px-2 py-0.5 rounded dark:bg-amber-900 dark:text-amber-300">In Progress</span>
                                                <span class="text-xs text-gray-500 dark:text-gray-400">Since 2:45 PM</span>
                                            </div>
                                            <h4 class="font-medium mt-1">Sofia Reyes</h4>
                                            <div class="text-sm text-gray-600 dark:text-gray-300">Follow-up</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">Doctor: Dr. Johnson</div>
                                        </div>
                                        <div class="flex flex-col gap-2">
                                            <button type="button" class="text-white bg-green-600 hover:bg-green-700 focus:ring-2 focus:ring-green-300 font-medium rounded-lg text-xs px-3 py-1 dark:bg-green-500 dark:hover:bg-green-600 focus:outline-none dark:focus:ring-green-700">Complete</button>
                                        </div>
                                    </div>
                                    <div class="mt-2 pt-2 border-t border-gray-200 dark:border-gray-600">
                                        <div class="text-xs text-gray-500 dark:text-gray-400">Time-in: 2:45 PM</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">Duration: 10 minutes</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Completed Today -->
                        <div class="h-full flex flex-col bg-white dark:bg-gray-800 rounded-lg shadow border border-gray-200 dark:border-gray-700 overflow-hidden">
                            <div class="p-3 bg-green-100 dark:bg-green-900 border-b border-green-200 dark:border-green-800 rounded-t-lg">
                                <h3 class="font-semibold text-green-800 dark:text-green-200 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Completed Today (3)
                                </h3>
                            </div>
                            <div class="p-3 flex-1 overflow-y-auto space-y-2">
                                <!-- Completed Items -->
                                <div class="p-3 bg-white dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600 shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <span class="bg-green-100 text-green-800 text-xs font-medium px-2 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Completed</span>
                                            </div>
                                            <h4 class="font-medium mt-1">Isabela Cruz</h4>
                                            <div class="text-sm text-gray-600 dark:text-gray-300">Check-up</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">Doctor: Dr. Williams</div>
                                        </div>
                                    </div>
                                    <div class="mt-2 pt-2 border-t border-gray-200 dark:border-gray-600 text-xs text-gray-500 dark:text-gray-400">
                                        <div class="grid grid-cols-2 gap-1">
                                            <div>Time-in: 10:15 AM</div>
                                            <div>Time-out: 10:45 AM</div>
                                            <div>Duration: 30 minutes</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="p-3 bg-white dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600 shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <span class="bg-green-100 text-green-800 text-xs font-medium px-2 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Completed</span>
                                            </div>
                                            <h4 class="font-medium mt-1">Miguel Santos</h4>
                                            <div class="text-sm text-gray-600 dark:text-gray-300">Consultation</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">Doctor: Dr. Smith</div>
                                        </div>
                                    </div>
                                    <div class="mt-2 pt-2 border-t border-gray-200 dark:border-gray-600 text-xs text-gray-500 dark:text-gray-400">
                                        <div class="grid grid-cols-2 gap-1">
                                            <div>Time-in: 11:30 AM</div>
                                            <div>Time-out: 12:15 PM</div>
                                            <div>Duration: 45 minutes</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="p-3 bg-white dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600 shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <span class="bg-green-100 text-green-800 text-xs font-medium px-2 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Completed</span>
                                            </div>
                                            <h4 class="font-medium mt-1">Luis Reyes</h4>
                                            <div class="text-sm text-gray-600 dark:text-gray-300">Follow-up</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">Doctor: Dr. Johnson</div>
                                        </div>
                                    </div>
                                    <div class="mt-2 pt-2 border-t border-gray-200 dark:border-gray-600 text-xs text-gray-500 dark:text-gray-400">
                                        <div class="grid grid-cols-2 gap-1">
                                            <div>Time-in: 1:20 PM</div>
                                            <div>Time-out: 2:00 PM</div>
                                            <div>Duration: 40 minutes</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="p-3 bg-white dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600 shadow-sm">
                                    <div class="flex items-center justify-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1v-3a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span>No more completed appointments today</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Add to Queue Modal -->
                        <div id="queueModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                            <div class="relative w-full max-w-md max-h-full">
                                <!-- Modal content -->
                                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                    <!-- Modal header -->
                                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                            Add to Queue
                                        </h3>
                                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="queueModal">
                                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                            </svg>
                                            <span class="sr-only">Close modal</span>
                                        </button>
                                    </div>
                                    <!-- Modal body -->
                                    <form action="#" method="POST" class="p-4 md:p-5">
                                        @csrf
                                        <div class="grid gap-4 mb-4">
                                            <div>
                                                <label for="patient_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Patient</label>
                                                <select id="patient_id" name="patient_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-600 focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500" required>
                                                    <option value="" selected disabled>Select patient</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label for="doctor_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Assign Doctor</label>
                                                <select id="doctor_id" name="doctor_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-600 focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500">
                                                    <option value="" selected>Assign later</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label for="appointment_type_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Appointment Type</label>
                                                <select id="appointment_type_id" name="appointment_type_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-600 focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500" required>
                                                    <option value="" selected disabled>Select type</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label for="chief_complaint" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Chief Complaint</label>
                                                <textarea id="chief_complaint" name="chief_complaint" rows="3" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500" placeholder="Describe patient's complaint..." required></textarea>
                                            </div>
                                            <div>
                                                <label for="remarks" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Remarks (Optional)</label>
                                                <textarea id="remarks" name="remarks" rows="2" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500" placeholder="Additional notes..."></textarea>
                                            </div>
                                            <input type="hidden" name="added_by" value="{{ auth()->id() }}">
                                            <input type="hidden" name="queue_date" value="{{ now()->toDateString() }}">
                                        </div>
                                        <div class="flex items-center justify-end space-x-4">
                                            <button type="button" data-modal-hide="queueModal" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Cancel</button>
                                            <button type="submit" class="text-white bg-indigo-700 hover:bg-indigo-800 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:ring-indigo-800">Add to Queue</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
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
