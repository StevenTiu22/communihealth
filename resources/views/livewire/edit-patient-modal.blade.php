<div>
    <x-button wire:click="openModal" class="bg-blue-600 hover:bg-blue-800">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-1" viewBox="0 0 20 20" fill="currentColor">
            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
        </svg>
        Edit
    </x-button>

    <x-dialog-modal wire:model.live="showModal" maxWidth="7xl" class="flex items-center justify-center min-h-screen">
        <x-slot name="title">
            <div class="mt-4 border-b pb-4">
                <h1 class="text-2xl font-bold">Edit Patient</h1>
            </div>
        </x-slot>

        <x-slot name="content">
            <form wire:submit.prevent="save">
                @csrf
                <div class="grid grid-cols-2 gap-8 h-[32rem] overflow-y-auto p-4">
                    <!-- Left Half - Basic Information -->
                    <div class="col-span-1">
                        <h2 class="text-lg font-medium mb-4">Basic Information</h2>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="col-span-2 mb-4">
                                <x-label for="profile_photo" value="Profile Photo" class="mb-2" />
                                <div class="mt-1 flex items-center gap-4">
                                    <div class="flex-shrink-0">
                                        @if ($profile_photo)
                                            <div class="relative">
                                                <img src="{{ $profile_photo->temporaryUrl() }}" class="w-20 h-20 rounded-full object-cover">    
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
                                        <label for="profile_photo_edit-{{ $patient->id }}"" class="cursor-pointer bg-white px-3 py-2 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Choose photo
                                        </label>
                                        @if($profile_photo)
                                            <span class="text-sm text-gray-500">{{ Str::limit($profile_photo->getClientOriginalName(), 20) }}</span>
                                        @endif
                                        <input id="profile_photo_edit-{{ $patient->id }}" type="file" wire:model.live="profile_photo" class="hidden" accept="image/*" wire:loading.attr="disabled">
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-1">
                                <x-label for="first_name" value="First Name" />
                                <x-input id="first_name" type="text" class="mt-1 block w-full capitalize" wire:model.live="first_name" />
                                @error('first_name') <x-input-error for="first_name" class="mt-2" /> @enderror
                            </div>

                            <div class="col-span-1">
                                <x-label for="middle_name" value="Middle Name" />
                                <x-input id="middle_name" type="text" class="mt-1 block w-full capitalize" wire:model.live="middle_name" />
                                @error('middle_name') <x-input-error for="middle_name" class="mt-2" /> @enderror
                            </div>

                            <div class="col-span-2">
                                <x-label for="last_name" value="Last Name" />
                                <x-input id="last_name" type="text" class="mt-1 block w-full capitalize" wire:model.live="last_name" />
                                @error('last_name') <x-input-error for="last_name" class="mt-2" /> @enderror
                            </div>

                            <div class="col-span-1">
                                <x-label for="gender" value="Gender" />
                                <select id="gender" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" wire:model.live="gender">
                                    <option value="">Select Gender</option>
                                    <option value="0">Male</option>
                                    <option value="1">Female</option>
                                </select>
                            </div>

                            <div class="col-span-1">
                                <x-label for="birth_date" value="Birthdate" />
                                <x-input id="birth_date" type="date" class="mt-1 block w-full" wire:model.live="birth_date" />
                                @error('birth_date') <x-input-error for="birth_date" class="mt-2" /> @enderror
                            </div>

                            <div class="col-span-2">
                                <x-label for="contact_number" value="Contact Number" />
                                <x-input id="contact_number" type="tel" class="mt-1 block w-full" wire:model.live="contact_number" />
                                @error('contact_number') <x-input-error for="contact_number" class="mt-2" /> @enderror
                            </div>

                            <div class="col-span-1">
                                <label class="inline-flex items-center space-x-2">
                                    <input type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" wire:model.live="is_4ps">
                                    <span>4Ps Member</span>
                                </label>
                            </div>

                            <div class="col-span-1">
                                <label class="inline-flex items-center space-x-2">
                                    <input type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" wire:model.live="is_NHTS">
                                    <span>NHTS Member</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Right Half - Address Information -->
                    <div class="col-span-1">
                        <h2 class="text-lg font-medium mb-4">Address Information</h2>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="col-span-2">
                                <x-label for="house_number" value="House Number" />
                                <x-input id="house_number" type="text" class="mt-1 block w-full" wire:model.live="house_number" />
                                @error('house_number') <x-input-error for="house_number" class="mt-2" /> @enderror
                            </div>

                            <div class="col-span-1">
                                <x-label for="street" value="Street" />
                                <x-input id="street" type="text" class="mt-1 block w-full" wire:model.live="street" />
                                @error('street') <x-input-error for="street" class="mt-2" /> @enderror
                            </div>

                            <div class="col-span-1">
                                <x-label for="barangay" value="Barangay" />
                                <x-input id="barangay" type="text" class="mt-1 block w-full" wire:model.live="barangay" />
                                @error('barangay') <x-input-error for="barangay" class="mt-2" /> @enderror
                            </div>

                            <div class="col-span-2">
                                <x-label for="city" value="City" />
                                <x-input id="city" type="text" class="mt-1 block w-full" wire:model.live="city" />
                                @error('city') <x-input-error for="city" class="mt-2" /> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Parent Information -->
                    <div class="col-span-2">
                        <div class="mt-8">
                            <h2 class="text-lg font-medium mb-4">Parent Information</h2>
                            <hr class="border-t border-gray-300 my-4">
                            <div class="grid grid-cols-2 gap-8">
                                <!-- Mother's Information -->
                                <div class="col-span-1">
                                    <h3 class="text-base font-medium text-gray-700 mb-4">Mother's Information</h3>
                                    <div class="grid grid-cols-1 gap-4">
                                        <!-- Mother's fields -->
                                        <div>
                                            <x-label for="mother_first_name" value="First Name" />
                                            <x-input id="mother_first_name" type="text" class="mt-1 block w-full capitalize" wire:model.live="mother_first_name" />
                                            @error('mother_first_name') <x-input-error for="mother_first_name" class="mt-2" /> @enderror
                                        </div>

                                        <div>
                                            <x-label for="mother_middle_name" value="Middle Name" />
                                            <x-input id="mother_middle_name" type="text" class="mt-1 block w-full capitalize" wire:model.live="mother_middle_name" />
                                            @error('mother_middle_name') <x-input-error for="mother_middle_name" class="mt-2" /> @enderror
                                        </div>

                                        <div>
                                            <x-label for="mother_last_name" value="Last Name" />
                                            <x-input id="mother_last_name" type="text" class="mt-1 block w-full capitalize" wire:model.live="mother_last_name" />
                                            @error('mother_last_name') <x-input-error for="mother_last_name" class="mt-2" /> @enderror
                                        </div>

                                        <div>
                                            <x-label for="mother_philhealth" value="PhilHealth Number" />
                                            <x-input id="mother_philhealth" type="text" class="mt-1 block w-full" wire:model.live="mother_philhealth" />
                                            @error('mother_philhealth') <x-input-error for="mother_philhealth" class="mt-2" /> @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Father's Information -->
                                <div class="col-span-1">
                                    <h3 class="text-base font-medium text-gray-700 mb-4">Father's Information</h3>
                                    <div class="grid grid-cols-1 gap-4">
                                        <!-- Father's fields -->
                                        <div>
                                            <x-label for="father_first_name" value="First Name" />
                                            <x-input id="father_first_name" type="text" class="mt-1 block w-full capitalize" wire:model.live="father_first_name" />
                                            @error('father_first_name') <x-input-error for="father_first_name" class="mt-2" /> @enderror
                                        </div>

                                        <div>
                                            <x-label for="father_middle_name" value="Middle Name" />
                                            <x-input id="father_middle_name" type="text" class="mt-1 block w-full capitalize" wire:model.live="father_middle_name" />
                                            @error('father_middle_name') <x-input-error for="father_middle_name" class="mt-2" /> @enderror
                                        </div>

                                        <div>
                                            <x-label for="father_last_name" value="Last Name" />
                                            <x-input id="father_last_name" type="text" class="mt-1 block w-full capitalize" wire:model.live="father_last_name" />
                                            @error('father_last_name') <x-input-error for="father_last_name" class="mt-2" /> @enderror
                                        </div>

                                        <div>
                                            <x-label for="father_philhealth" value="PhilHealth Number" />
                                            <x-input id="father_philhealth" type="text" class="mt-1 block w-full" wire:model.live="father_philhealth" />
                                            @error('father_philhealth') <x-input-error for="father_philhealth" class="mt-2" /> @enderror
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
            <x-secondary-button wire:click="closeModal" wire:loading.attr="disabled">
                Cancel
            </x-secondary-button>

            <x-button class="ml-3" wire:click="save" wire:loading.attr="disabled" :disabled="$errors->any()">
                Save
            </x-button>
        </x-slot>
    </x-dialog-modal>
</div>
