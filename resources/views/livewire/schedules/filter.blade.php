<div class="flex flex-wrap gap-3">
    <div class="relative">
        <div class="flex items-center relative">
            <!-- Doctor Icon -->
            <div class="absolute left-2 z-10 pointer-events-none">
                <svg class="w-4 h-4 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>

            <select
                wire:model.live="doctor_id"
                class="pl-8 pr-10 text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm py-1.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700 appearance-none"
            >
                <option value="">All Doctors</option>
                @foreach($doctors as $doctor)
                    <option value="{{ $doctor->id }}">Dr. {{ $doctor->last_name }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
