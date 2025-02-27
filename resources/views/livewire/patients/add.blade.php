<div>
    <!-- Add Patient Button -->
    <x-button
        wire:click="open"
        color="blue"
        :darkMode="true"
        class="px-3 py-3 text-lg"
    >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
        </svg>
        Add Patient
    </x-button>

    <x-dialog-modal wire:model.blur="showModal" maxWidth="7xl" class="flex items-center justify-center min-h-screen">
        <x-slot name="title">
            <div class="mt-4 border-b pb-4">
                <h1 class="text-2xl font-bold">Add New Patient</h1>
            </div>
        </x-slot>

        <x-slot name="content">
            <form wire:submit.prevent="save">
                <div class="grid grid-cols-2 gap-8 h-[32rem] overflow-y-auto p-4">
                    <!-- Left Half - Basic Information -->
                    <div class="col-span-1">
                        <h2 class="text-lg font-medium text-white mb-4">Basic Information</h2>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="col-span-2 mb-4">
                                <x-label for="profile_photo" value="Profile Photo" class="mb-2" />
                                <div class="mt-1 flex items-center gap-4">
                                    <div class="flex-shrink-0">
                                        @if ($profile_photo)
                                            <div class="relative">
                                                <img src="{{ $profile_photo->temporaryUrl() }}" class="w-20 h-20 rounded-full object-cover">
                                                <button wire:click="$set('profile_photo', null)" class="absolute top-0 right-0 -mt-2 -mr-2 p-1 bg-red-500 text-white rounded-full hover:bg-red-600">
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        @else
                                            <div class="w-20 h-20 rounded-full bg-gray-200 flex items-center justify-center">
                                                <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="flex items-center gap-3">
                                        <label for="profile_photo_input" class="cursor-pointer bg-white px-3 py-2 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50">
                                            Choose photo
                                        </label>
                                        @if($profile_photo)
                                            <span class="text-sm text-gray-500">{{ Str::limit($profile_photo->getClientOriginalName(), 20) }}</span>
                                        @endif
                                        <input id="profile_photo_input" type="file" wire:model.live="profile_photo" class="hidden" accept="image/*" wire:loading.attr="disabled">
                                    </div>
                                </div>

                                <div class="mt-2 text-sm text-gray-500">
                                    Recommended: Square image, at least 400x400 pixels
                                </div>
                                <x-input-error for="profile_photo" class="mt-2" />
                            </div>
                            <div class="col-span-1">
                                <x-label for="first_name" value="First Name" />
                                <x-input id="first_name" type="text" class="mt-1 block w-full" wire:model.live="form.first_name" />
                                <x-input-error for="form.first_name" class="mt-2" />
                            </div>

                            <div class="col-span-1">
                                <x-label for="middle_name" value="Middle Name" />
                                <x-input id="middle_name" type="text" class="mt-1 block w-full" wire:model.live="form.middle_name" />
                                <x-input-error for="form.middle_name" class="mt-2" />
                            </div>

                            <div class="col-span-2">
                                <x-label for="last_name" value="Last Name" />
                                <x-input id="last_name" type="text" class="mt-1 block w-full" wire:model.live="form.last_name" />
                                <x-input-error for="form.last_name" class="mt-2" />
                            </div>

                            <div class="col-span-1">
                                <x-label for="gender" value="Gender" />
                                <select id="gender" wire:model.live="form.sex"
                                        class="mt-1 block w-full bg-gray-900 focus:border-indigo-500 focus:ring-indigo-500 rounded-md">
                                    <option value="">Select Sex</option>
                                    <option value="0">Male</option>
                                    <option value="1">Female</option>
                                </select>
                                <x-input-error for="form.gender" class="mt-2" />
                            </div>

                            <div class="col-span-1">
                                <x-label for="birth_date" value="Birthdate" />
                                <x-input id="birth_date" type="date" class="mt-1 block w-full" wire:model.live="form.birth_date" />
                                <x-input-error for="form.birth_date" class="mt-2" />
                            </div>

                            <div class="col-span-2">
                                <x-label for="contact_number" value="Contact Number" />
                                <x-input id="contact_number" type="tel" class="mt-1 block w-full" wire:model.live="form.contact_number" />
                                <x-input-error for="form.contact_number" class="mt-2" />
                            </div>

                            <div class="col-span-1">
                                <label class="inline-flex items-center space-x-2">
                                    <input type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" wire:model.live="form.is_4ps">
                                    <span>4Ps Member</span>
                                </label>
                                <x-input-error for="form.is_4ps" class="mt-2" />
                            </div>

                            <div class="col-span-1">
                                <label class="inline-flex items-center space-x-2">
                                    <input type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" wire:model.live="form.is_NHTS">
                                    <span>NHTS Member</span>
                                </label>
                                <x-input-error for="form.is_NHTS" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <!-- Right Half - Address Information -->
                    <div class="col-span-1">
                        <h2 class="text-lg font-medium text-white mb-4">Address Information</h2>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="col-span-2">
                                <x-label for="house_number" value="House Number" />
                                <x-input id="house_number" type="text" class="mt-1 block w-full" wire:model.live="form.house_number" />
                                <x-input-error for="form.house_number" class="mt-2" />
                            </div>

                            <div class="col-span-1">
                                <x-label for="street" value="Street" />
                                <x-input id="street" type="text" class="mt-1 block w-full" wire:model.live="form.street" />
                                <x-input-error for="form.street" class="mt-2" />
                            </div>

                            <div class="col-span-1">
                                <x-label for="barangay" value="Barangay" />
                                <x-input id="barangay" type="text" class="mt-1 block w-full" wire:model.live="barangay" />
                                <x-input-error for="form.barangay" class="mt-2" />
                            </div>

                            <div class="col-span-2">
                                <x-label for="city" value="City" />
                                <x-input id="city" type="text" class="mt-1 block w-full" wire:model.live="form.city" />
                                <x-input-error for="form.city" class="mt-2" />
                            </div>

                            <div class="col-span-2">
                                <x-label for="province" value="Province" />
                                <x-input id="province" type="text" class="mt-1 block w-full" wire:model.live="form.province" />
                                <x-input-error for="form.province" class="mt-2" />
                            </div>

                            <div class="col-span-2">
                                <x-label for="region" value="Region" />
                                <x-input id="region" type="text" class="mt-1 block w-full" wire:model.live="form.region" />
                                <x-input-error for="form.region" class="mt-2" />
                            </div>

                            <div class="col-span-2">
                                <x-label for="country" value="Country" />
                                <x-input id="country" type="text" class="mt-1 block w-full" wire:model.live="form.country" />
                                <x-input-error for="form.country" class="mt-2" />
                            </div>
                        </div>
                    </div>
                    <div class="col-span-2">
                        <div class="mt-8">
                            <h2 class="text-lg font-medium text-white mb-4">Parent Information</h2>
                            <hr class="border-t border-gray-300 my-4">
                            <div class="grid grid-cols-2 gap-8">
                                <!-- Mother's Information -->
                                <div class="col-span-1">
                                    <h3 class="text-base font-medium text-white mb-4">Mother's Information</h3>
                                    <div class="grid grid-cols-1 gap-4">
                                        <div>
                                            <x-label for="mother_first_name" value="First Name" />
                                            <x-input id="mother_first_name" type="text" class="mt-1 block w-full" wire:model.live="form.mother_first_name" />
                                            <x-input-error for="form.mother_first_name" class="mt-2" />
                                        </div>

                                        <div>
                                            <x-label for="mother_middle_name" value="Middle Name" />
                                            <x-input id="mother_middle_name" type="text" class="mt-1 block w-full" wire:model.live="form.mother_middle_name" />
                                            <x-input-error for="form.mother_middle_name" class="mt-2" />
                                        </div>

                                        <div>
                                            <x-label for="mother_last_name" value="Last Name" />
                                            <x-input id="mother_last_name" type="text" class="mt-1 block w-full" wire:model.live="form.mother_last_name" />
                                            <x-input-error for="form.mother_last_name" class="mt-2" />
                                        </div>

                                        <div>
                                            <x-label for="mother_philhealth" value="PhilHealth Number" />
                                            <x-input id="mother_philhealth" type="text" class="mt-1 block w-full" wire:model.live="form.mother_philhealth" />
                                            <x-input-error for="form.mother_philhealth" class="mt-2" />
                                        </div>
                                    </div>
                                </div>

                                <!-- Father's Information -->
                                <div class="col-span-1">
                                    <h3 class="text-base font-medium text-white mb-4">Father's Information</h3>
                                    <div class="grid grid-cols-1 gap-4">
                                        <div>
                                            <x-label for="father_first_name" value="First Name" />
                                            <x-input id="father_first_name" type="text" class="mt-1 block w-full" wire:model.live="form.father_first_name" />
                                            <x-input-error for="form.father_first_name" class="mt-2" />
                                        </div>

                                        <div>
                                            <x-label for="father_middle_name" value="Middle Name" />
                                            <x-input id="father_middle_name" type="text" class="mt-1 block w-full" wire:model.live="father_middle_name" />
                                            <x-input-error for="form.father_middle_name" class="mt-2" />
                                        </div>

                                        <div>
                                            <x-label for="father_last_name" value="Last Name" />
                                            <x-input id="father_last_name" type="text" class="mt-1 block w-full" wire:model.live="form.father_last_name" />
                                            <x-input-error for="form.father_last_name" class="mt-2" />
                                        </div>

                                        <div>
                                            <x-label for="father_philhealth" value="PhilHealth Number" />
                                            <x-input id="father_philhealth" type="text" class="mt-1 block w-full" wire:model.live="form.father_philhealth" />
                                            <x-input-error for="form.father_philhealth" class="mt-2" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="close" wire:loading.attr="disabled">
                Cancel
            </x-secondary-button>

            <x-button class="ml-3" wire:click="save" color="blue" wire:loading.attr="disabled" :disabled="$errors->any()">
                Save
            </x-button>
        </x-slot>
    </x-dialog-modal>
</div>
