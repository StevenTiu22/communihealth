<div class="flex flex-col h-full">
    <div class="overflow-x-auto">
        <div class="inline-block min-w-full align-middle">
            <div class="overflow-hidden border border-gray-200 dark:border-gray-700 rounded-lg">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                    <thead class="bg-gray-100 dark:bg-gray-700 sticky top-0">
                        <tr>
                            <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400 cursor-pointer">Full Name</th>
                            <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400 cursor-pointer">Age</th>
                            <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">Gender</th>
                            <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">Contact Number</th>
                            <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                        @forelse($patients as $patient)
                            <tr wire:key="{{ $patient->id }}" class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                <td class="flex items-center p-4 mr-12 space-x-6 whitespace-nowrap">
                                    <img class="w-10 h-10 rounded-full" src="{{ $patient->profile_photo_path }}" alt="{{ $patient->full_name }}">
                                    <div class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                        <div class="text-base font-semibold text-gray-900 dark:text-white">{{ $patient->full_name }}</div>
                                    </div>
                                </td>
                                <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $patient->age }}
                                </td>
                                <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $patient->gender == 0 ? 'Male' : 'Female' }}
                                </td>
                                <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $patient->contact_number }}
                                </td>
                                <td class="p-4 space-x-2 whitespace-nowrap">
                                    <div class="flex space-x-2">
                                        <livewire:edit-patient-modal :patient="$patient" :wire:key="'edit-patient-'.$patient->id" />
                                        <livewire:delete-patient-modal :patient="$patient" :wire:key="'delete-patient-'.$patient->id" />
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-4 text-center text-gray-500 dark:text-gray-400">
                                    No patient records found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Active Filters -->
    <div class="mt-2 px-2">
        @if($filterGender || $filterAge || $filter4ps || $filterNhts)
            <div class="flex items-center gap-2 text-xs text-gray-600 dark:text-gray-400">
                <span>Filters:</span>
                @if($filterGender !== '')
                    <span class="px-2 py-0.5 bg-blue-100 text-blue-800 rounded-full dark:bg-blue-900 dark:text-blue-300">
                        {{ $filterGender == '0' ? 'Male' : 'Female' }}
                    </span>
                @endif
                @if($filterAge !== '')
                    <span class="px-2 py-0.5 bg-blue-100 text-blue-800 rounded-full dark:bg-blue-900 dark:text-blue-300">
                        {{ ucfirst($filterAge) }}
                    </span>
                @endif
                @if($filter4ps !== '')
                    <span class="px-2 py-0.5 bg-blue-100 text-blue-800 rounded-full dark:bg-blue-900 dark:text-blue-300">
                        {{ $filter4ps == '1' ? '4Ps Member' : 'Non-4Ps' }}
                    </span>
                @endif
                @if($filterNhts !== '')
                    <span class="px-2 py-0.5 bg-blue-100 text-blue-800 rounded-full dark:bg-blue-900 dark:text-blue-300">
                        {{ $filterNhts == '1' ? 'NHTS Member' : 'Non-NHTS' }}
                    </span>
                @endif
            </div>
        @endif
    </div>

    <!-- Pagination -->
    <div class="mt-2 px-2">
        {{ $patients->links() }}
    </div>
</div>
