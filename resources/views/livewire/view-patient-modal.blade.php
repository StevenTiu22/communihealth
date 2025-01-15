<div>
    <x-button wire:click="openModal" class="bg-green-500 hover:bg-green-700 active:bg-green-800">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-1" viewBox="0 0 20 20" fill="currentColor">
            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
        </svg>
        View
    </x-button>

    <x-dialog-modal wire:model.blur="showModal" maxWidth="screen-2xl" class="flex items-center justify-center min-h-screen">
        <x-slot name="title">
            <div class="mt-4 border-b pb-4">
                <h1 class="text-2xl font-bold">Patient Details</h1>
            </div>
        </x-slot>

        <x-slot name="content">
            <div class="flex h-[32rem]">
                <!-- Left Side - Patient Information (30%) -->
                <div class="w-[30%] p-4 border-r border-gray-200 dark:border-gray-700 overflow-y-auto">
                    <!-- Basic Information -->
                    <div class="mb-6">
                        <h2 class="text-lg font-medium mb-4">Patient Information</h2>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="col-span-2 mb-4 flex justify-center">
                                <img src="{{ $profile_photo }}" alt="Profile Photo" class="rounded-full h-32 w-32 object-cover">
                            </div>
                            <div>
                                <x-label value="First Name" />
                                <p class="mt-1">{{ ucwords($first_name) }}</p>
                            </div>
                            <div>
                                <x-label value="Middle Name" />
                                <p class="mt-1">{{ $middle_name ? ucwords($middle_name) : 'N/A' }}</p>
                            </div>
                            <div>
                                <x-label value="Last Name" />
                                <p class="mt-1">{{ ucwords($last_name) }}</p>
                            </div>
                            <div>
                                <x-label value="Gender" />
                                <p class="mt-1">{{ $gender == 0 ? 'Male' : 'Female' }}</p>
                            </div>
                            <div>
                                <x-label value="Birthdate" />
                                <p class="mt-1">{{ date('F j, Y', strtotime($birth_date)) }}</p>
                            </div>
                            <div>
                                <x-label value="Contact Number" />
                                <p class="mt-1">{{ '+63 ' . substr($contact_number, 1) }}</p>
                            </div>
                            <div>
                                <x-label value="4Ps Member" />
                                <p class="mt-1">{{ $is_4ps == 1 ? 'Yes' : 'No' }}</p>
                            </div>
                            <div>
                                <x-label value="NHTS Member" />
                                <p class="mt-1">{{ $is_NHTS == 1 ? 'Yes' : 'No' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Address Information -->
                    <div class="mb-10">
                        <h2 class="text-lg font-medium mb-4">Address Information</h2>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-label value="House Number" />
                                <p class="mt-1">{{ $house_number ?: 'N/A' }}</p>
                            </div>
                            <div>
                                <x-label value="Street" />
                                <p class="mt-1">{{ $street ?: 'N/A' }}</p>
                            </div>
                            <div>
                                <x-label value="Barangay" />
                                <p class="mt-1">{{ $barangay ?: 'N/A' }}</p>
                            </div>
                            <div>
                                <x-label value="City/Municipality" />
                                <p class="mt-1">{{ $city ?: 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Parent Information -->
                    <div class="mb-6">
                        <h2 class="text-lg font-medium mb-8">Parent Information</h2>
                        
                        <!-- Mother's Information -->
                        <div class="mb-4">
                            <h3 class="font-medium text-gray-700 mb-4">Mother's Information</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <x-label value="First Name" />
                                    <p class="mt-1">{{ $mother_first_name ? ucwords($mother_first_name) : 'N/A' }}</p>
                                </div>
                                <div>
                                    <x-label value="Middle Name" />
                                    <p class="mt-1">{{ $mother_middle_name ? ucfirst($mother_middle_name) : 'N/A' }}</p>
                                </div>
                                <div>
                                    <x-label value="Last Name" />
                                    <p class="mt-1">{{ $mother_last_name ? ucwords($mother_last_name) : 'N/A' }}</p>
                                </div>
                                <div>
                                    <x-label value="PhilHealth Number" />
                                    <p class="mt-1">{{ $mother_philhealth ?: 'N/A' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Father's Information -->
                        <div>
                            <h3 class="font-medium text-gray-700 mb-4">Father's Information</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <x-label value="First Name" />
                                    <p class="mt-1">{{ $father_first_name ? ucwords($father_first_name) : 'N/A' }}</p>
                                </div>
                                <div>
                                    <x-label value="Middle Name" />
                                    <p class="mt-1">{{ $father_middle_name ? ucfirst($father_middle_name) : 'N/A' }}</p>
                                </div>
                                <div>
                                    <x-label value="Last Name" />
                                    <p class="mt-1">{{ $father_last_name ? ucfirst($father_last_name) : 'N/A' }}</p>
                                </div>
                                <div>
                                    <x-label value="PhilHealth Number" />
                                    <p class="mt-1">{{ $father_philhealth ?: 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Side - Treatment Records (70%) -->
                <div class="w-[70%] p-4 overflow-y-auto">
                    <h2 class="text-lg text-gray-700 mb-2">Filter by Appointments</h2>
                    <livewire:schedule-dropdown />
                    <div class="mt-8">
                        <h2 class="text-lg text-gray-700 mb-4">Treatment Records</h2>
                        
                    </div>

                    <div class="mt-6">
                        <h3 class="text-lg text-gray-700 mb-4">Vital Signs</h3>
                        <div class="space-y-4">
                           
                        </div>
                    </div>

                    <div class="mt-6">
                        <h3 class="text-lg text-gray-700 mb-4">Medicine Transactions</h3>
                        <div class="space-y-4">
                            
                        </div>
                    </div>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="closeModal" wire:loading.attr="disabled">
                Close
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>
