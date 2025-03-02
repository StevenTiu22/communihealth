<div>
    <!-- View Patient Button -->
    <button
        wire:click="open"
        class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300"
        title="View patient details"
    >
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <g>
                <path d="M23.91 11.58C21.94 7.31 17.5 3 12 3S2.06 7.31.09 11.58a1.025 1.025 0 0 0 0 .84C2.06 16.69 6.5 21 12 21s9.94-4.31 11.91-8.58a1.025 1.025 0 0 0 0-.84ZM12 17a5 5 0 1 1 5-5 5.006 5.006 0 0 1-5 5Z"></path>
                <circle cx="12" cy="12" r="3"></circle>
            </g>
        </svg>
    </button>

    <x-dialog-modal wire:model.blur="showModal" maxWidth="7xl" class="flex items-center justify-center min-h-screen">
        <x-slot name="title">
            <div class="mt-4 border-b pb-4">
                <h1 class="text-2xl font-bold">Patient Details</h1>
            </div>
        </x-slot>

        <x-slot name="content">
            <div class="grid grid-cols-2 gap-8 h-[32rem] overflow-y-auto p-4">
                <!-- Left Half - Basic Information -->
                <div class="col-span-1">
                    <h2 class="text-lg font-medium mb-4 text-white">Basic Information</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="col-span-2 mb-4">
                            <h3 class="font-medium text-gray-300 mb-2">Profile Photo</h3>
                            <div class="mt-1 flex items-center">
                                <div class="flex-shrink-0">
                                    @if($patient->profile_photo_path)
                                        <img src="{{ Storage::url($patient->profile_photo_path) }}" class="h-32 w-32 rounded-full object-cover" alt="{{$patient->username}}">
                                    @else
                                        <div class="h-16 w-16 rounded-full bg-gray-200 flex items-center justify-center">
                                            <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-span-1">
                            <h3 class="font-medium text-gray-300">First Name</h3>
                            <p class="mt-1 text-white capitalize">{{ $patient->first_name }}</p>
                        </div>

                        <div class="col-span-1">
                            <h3 class="font-medium text-gray-300">Middle Name</h3>
                            <p class="mt-1 text-white capitalize">{{ $patient->middle_name ?: 'N/A' }}</p>
                        </div>

                        <div class="col-span-2">
                            <h3 class="font-medium text-gray-300">Last Name</h3>
                            <p class="mt-1 text-white capitalize">{{ $patient->last_name }}</p>
                        </div>

                        <div class="col-span-1">
                            <h3 class="font-medium text-gray-300">Sex</h3>
                            <p class="mt-1 text-white">{{ $patient->sex ? 'Male' : 'Female' }}</p>
                        </div>

                        <div class="col-span-1">
                            <h3 class="font-medium text-gray-300">Birth date</h3>
                            <p class="mt-1 text-white">{{ $patient->birth_date->format('F j, Y') }}</p>
                        </div>

                        <div class="col-span-1">
                            <h3 class="font-medium text-gray-300">Contact Number</h3>
                            <p class="mt-1 text-white">{{ $patient->contact_number }}</p>
                        </div>

                        <div class="col-span-1">
                            <h3 class="font-medium text-gray-300">Age</h3>
                            <p class="mt-1 text-white">{{ $patient->age }}</p>
                        </div>

                        <div class="col-span-1">
                            <h3 class="font-medium text-gray-300">4Ps Member</h3>
                            <p class="mt-1 text-white">{{ $patient->is_4ps ? 'Yes' : 'No' }}</p>
                        </div>

                        <div class="col-span-1">
                            <h3 class="font-medium text-gray-300">NHTS Member</h3>
                            <p class="mt-1 text-white">{{ $patient->is_NHTS ? 'Yes' : 'No' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Right Half - Address Information -->
                <div class="col-span-1">
                    <h2 class="text-lg font-medium mb-4 text-white">Address Information</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="col-span-1">
                            <h3 class="font-medium text-gray-300">House Number</h3>
                            <p class="mt-1 text-white capitalize">{{ $address->house_number ?: 'N/A' }}</p>
                        </div>

                        <div class="col-span-1">
                            <h3 class="font-medium text-gray-300">Street</h3>
                            <p class="mt-1 text-white capitalize">{{ $address->street ?: 'N/A' }}</p>
                        </div>

                        <div class="col-span-1">
                            <h3 class="font-medium text-gray-300">Barangay</h3>
                            <p class="mt-1 text-white capitalize">{{ $address->barangay ?: 'N/A' }}</p>
                        </div>

                        <div class="col-span-1">
                            <h3 class="font-medium text-gray-300">City</h3>
                            <p class="mt-1 text-white capitalize">{{ $address->city ?: 'N/A' }}</p>
                        </div>

                        <div class="col-span-1">
                            <h3 class="font-medium text-gray-300">Province</h3>
                            <p class="mt-1 text-white capitalize">{{ $address->province ?: 'N/A' }}</p>
                        </div>

                        <div class="col-span-1">
                            <h3 class="font-medium text-gray-300">Region</h3>
                            <p class="mt-1 text-white capitalize">{{ $address->region ?: 'N/A' }}</p>
                        </div>

                        <div class="col-span-2">
                            <h3 class="font-medium text-gray-300">Country</h3>
                            <p class="mt-1 text-white capitalize">{{ $address->country ?: 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-span-2">
                    <div class="mt-8">
                        <h2 class="text-lg font-medium mb-4 text-white">Parent Information</h2>
                        <hr class="border-t border-gray-300 my-4">
                        <div class="grid grid-cols-2 gap-8">
                            <!-- Mother's Information -->
                            <div class="col-span-1">
                                <h3 class="text-base font-medium text-white mb-4">Mother's Information</h3>
                                <div class="grid grid-cols-1 gap-4">
                                    <div>
                                        <h4 class="font-medium text-gray-300">First Name</h4>
                                        <p class="mt-1 text-white capitalize">{{ $mother->first_name ?? 'N/A' }}</p>
                                    </div>

                                    <div>
                                        <h4 class="font-medium text-gray-300">Middle Name</h4>
                                        <p class="mt-1 text-white capitalize">{{ $mother->middle_name ?? 'N/A' }}</p>
                                    </div>

                                    <div>
                                        <h4 class="font-medium text-gray-300">Last Name</h4>
                                        <p class="mt-1 text-white capitalize">{{ $mother->last_name ?? 'N/A' }}</p>
                                    </div>

                                    <div>
                                        <h4 class="font-medium text-gray-300">PhilHealth Number</h4>
                                        <p class="mt-1 text-white">{{ $mother->philhealth_number ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Father's Information -->
                            <div class="col-span-1">
                                <h3 class="text-base font-medium text-white mb-4">Father's Information</h3>
                                <div class="grid grid-cols-1 gap-4">
                                    <div>
                                        <h4 class="font-medium text-gray-300">First Name</h4>
                                        <p class="mt-1 text-white capitalize">{{ $father->first_name ?? 'N/A' }}</p>
                                    </div>

                                    <div>
                                        <h4 class="font-medium text-gray-300">Middle Name</h4>
                                        <p class="mt-1 text-white capitalize">{{ $father->middle_name ?? 'N/A' }}</p>
                                    </div>

                                    <div>
                                        <h4 class="font-medium text-gray-300">Last Name</h4>
                                        <p class="mt-1 text-white capitalize">{{ $father->last_name ?? 'N/A' }}</p>
                                    </div>

                                    <div>
                                        <h4 class="font-medium text-gray-300">PhilHealth Number</h4>
                                        <p class="mt-1 text-white">{{ $father->philhealth_number ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="close" wire:loading.attr="disabled">
                Close
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>
