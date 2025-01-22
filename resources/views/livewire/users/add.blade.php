<div>    
    <!-- Add User Button -->
    <x-button wire:click="openModal" class="px-3 py-3 text-lg">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
        </svg>
        Add User
    </x-button>

    <x-dialog-modal wire:model.live="showModal" maxWidth="7xl" class="flex items-center justify-center min-h-screen">
        <x-slot name="title">
            <div class="mt-4 border-b pb-4">
                <h1 class="text-2xl font-bold">Add New User</h1>
            </div>
        </x-slot>

        <x-slot name="content">
            <form wire:submit.prevent="save">
                <div class="grid grid-cols-2 gap-8 h-[32rem] overflow-y-auto p-4">
                    <!-- Left Half - Basic Information -->
                    <div class="col-span-1">
                        <h2 class="text-lg font-medium mb-4">Account Information</h2>

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
                                    <label for="profile_photo_input" class="cursor-pointer bg-white px-3 py-2 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Choose photo
                                    </label>
                                    @if($profile_photo)
                                        <span class="text-sm text-gray-500">{{ Str::limit($profile_photo->getClientOriginalName(), 20) }}</span>
                                    @endif
                                    <input id="profile_photo_input" type="file" wire:model.live="profile_photo" class="hidden" accept="image/*">
                                </div>
                            </div>
                            
                            <div class="mt-2 text-sm text-gray-500">
                                Recommended: Square image, at least 400x400 pixels
                            </div>
                            @error('profile_photo') <x-input-error for="profile_photo" class="mt-2" /> @enderror
                        </div>

                        <div class="col-span-2 mb-4">
                            <x-label for="role" value="Role" />
                            <select id="role" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" wire:model.live="role">
                                <option value="-1">Select Role</option>
                                <option value="0">Barangay Official</option>
                                <option value="1">BHW</option>
                                <option value="2">Doctor</option>
                            </select>
                            @error('role') <x-input-error for="role" class="mt-2" /> @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="col-span-1">
                                <x-label for="first_name" value="First Name" />
                                <x-input id="first_name" type="text" class="mt-1 block w-full" wire:model.live="first_name" />
                                @error('first_name') <x-input-error for="first_name" class="mt-2" /> @enderror
                            </div>

                            <div class="col-span-1">
                                <x-label for="middle_name" value="Middle Name" />
                                <x-input id="middle_name" type="text" class="mt-1 block w-full" wire:model.live="middle_name" />
                                @error('middle_name') <x-input-error for="middle_name" class="mt-2" /> @enderror
                            </div>

                            <div class="col-span-2">
                                <x-label for="last_name" value="Last Name" />
                                <x-input id="last_name" type="text" class="mt-1 block w-full" wire:model.live="last_name" />
                                @error('last_name') <x-input-error for="last_name" class="mt-2" /> @enderror
                            </div>

                            <div class="col-span-1">
                                <x-label for="gender" value="Gender" />
                                <select id="gender" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" wire:model.live="gender">
                                    <option value="-1">Select Gender</option>
                                    <option value="0">Male</option>
                                    <option value="1">Female</option>
                                </select>
                                @error('gender') <x-input-error for="gender" class="mt-2" /> @enderror
                            </div>

                            <div class="col-span-1">
                                <x-label for="birth_date" value="Birth Date" />
                                <x-input id="birth_date" type="date" class="mt-1 block w-full" wire:model.live="birth_date" />
                                @error('birth_date') <x-input-error for="birth_date" class="mt-2" /> @enderror
                            </div>

                            <div class="col-span-2">
                                <x-label for="contact_number" value="Contact Number" />
                                <x-input id="contact_number" type="tel" class="mt-1 block w-full" wire:model.live="contact_number" />
                                @error('contact_number') <x-input-error for="contact_number" class="mt-2" /> @enderror
                            </div>

                            <div class="col-span-1">
                                <div x-data="{ showPassword: false }">
                                    <x-label for="password" value="Password" />
                                    <div class="relative">
                                        <input 
                                            x-bind:type="showPassword ? 'text' : 'password'"
                                            wire:model.live="password"
                                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full"
                                        >
                                        <button 
                                            x-on:click="showPassword = !showPassword"
                                            type="button"
                                            class="absolute inset-y-0 right-0 pr-3 flex items-center"
                                        >
                                            <template x-if="!showPassword">
                                                <svg class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </template>
                                            <template x-if="showPassword">
                                                <svg class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                                </svg>
                                            </template>
                                        </button>
                                    </div>
                                    @error('password') <x-input-error for="password" class="mt-2" /> @enderror
                                </div>
                            </div>

                            <div class="col-span-1">
                                <div x-data="{ showPasswordConfirmation: false }">
                                    <x-label for="password_confirmation" value="Confirm Password" />
                                    <div class="relative">
                                        <input 
                                            x-bind:type="showPasswordConfirmation ? 'text' : 'password'"
                                            wire:model.live="password_confirmation"
                                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full"
                                        >
                                        <button 
                                            x-on:click="showPasswordConfirmation = !showPasswordConfirmation"
                                            type="button"
                                            class="absolute inset-y-0 right-0 pr-3 flex items-center"
                                        >
                                            <template x-if="!showPasswordConfirmation">
                                                <svg class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </template>
                                            <template x-if="showPasswordConfirmation">
                                                <svg class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                                </svg>
                                            </template>
                                        </button>
                                    </div>
                                    @error('password_confirmation') <x-input-error for="password_confirmation" class="mt-2" /> @enderror
                                </div>
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

                            <div class="col-span-2" x-show="$wire.role==2">
                                <div class="mt-8">
                                    <h2 class="text-lg font-medium mb-4">Doctor Information</h2>
                                    <hr class="border-t border-gray-300 my-4">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div class="col-span-2">
                                            <x-label for="license_number" value="License Number" />
                                            <x-input id="license_number" type="text" class="mt-1 block w-full" wire:model.live="license_number" />
                                            @error('license_number') <x-input-error for="license_number" class="mt-2" /> @enderror
                                        </div>

                                        <div class="col-span-2">
                                            <x-label for="specialization" value="Specialization" />
                                            <x-input id="specialization" type="text" class="mt-1 block w-full" wire:model.live="specialization" />
                                            @error('specialization') <x-input-error for="specialization" class="mt-2" /> @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-2" x-show="$wire.role==1">
                            <div class="mt-8">
                                <h2 class="text-lg font-medium mb-4">BHW Information</h2>
                                <hr class="border-t border-gray-300 my-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="col-span-2">
                                        <x-label for="local_government_unit" value="Local Government Unit" />
                                        <x-input id="local_government_unit" type="text" class="mt-1 block w-full" wire:model.live="local_government_unit" />
                                        @error('local_government_unit') <x-input-error for="local_government_unit" class="mt-2" /> @enderror
                                    </div>

                                    <div class="col-span-2">
                                        <x-label for="issuance_date" value="Issuance Date" />
                                        <x-input id="issuance_date" type="date" class="mt-1 block w-full" wire:model.live="issuance_date" />
                                        @error('issuance_date') <x-input-error for="issuance_date" class="mt-2" /> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-2" x-show="$wire.role==0">
                            <div class="mt-8">
                                <h2 class="text-lg font-medium mb-4">Barangay Official Information</h2>
                                <hr class="border-t border-gray-300 my-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="col-span-2">
                                        <x-label for="position" value="Position" />
                                        <select id="position" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" wire:model.live="position">
                                            <option value="">Select Position</option>
                                            <option value="Barangay Captain">Barangay Captain</option>
                                            <option value="Barangay Secretary">Barangay Secretary</option>
                                            <option value="Barangay Treasurer">Barangay Treasurer</option>
                                            <option value="Barangay Kagawad">Barangay Kagawad</option>
                                            <option value="SK Chairman">SK Chairman</option>
                                        </select>
                                        @error('position') <x-input-error for="position" class="mt-2" /> @enderror
                                    </div>

                                    <div class="col-span-1">
                                        <x-label for="term_start" value="Term Start" />
                                        <x-input id="term_start" type="date" class="mt-1 block w-full" wire:model.live="term_start" />
                                        @error('term_start') <x-input-error for="term_start" class="mt-2" /> @enderror
                                    </div>

                                    <div class="col-span-1">
                                        <x-label for="term_end" value="Term End" />
                                        <x-input id="term_end" type="date" class="mt-1 block w-full" wire:model.live="term_end" />
                                        @error('term_end') <x-input-error for="term_end" class="mt-2" /> @enderror
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