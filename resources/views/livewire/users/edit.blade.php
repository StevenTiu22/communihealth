<div>
    <!-- Edit User Button -->
    <button
        wire:click="open"
        class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300"
    >
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
        </svg>
    </button>

    <!-- Modal -->
    <x-dialog-modal maxWidth="xl"  wire:model.blur="showModal" class="min-h-screen">
        <x-slot name="title">
            <div class="mt-4 border-b border-gray-300 dark:border-gray-600 pb-4">
                <h1 class="text-2xl font-bold">{{__('Edit User')}}</h1>
            </div>
        </x-slot>

        <x-slot name="content">
            <form wire:submit.prevent="update" class="relative">
                <div class="h-[calc(100vh-15rem)] overflow-y-auto">
                    <div class="space-y-6 w-full">
                        <!-- Basic Information Section -->
                        <div class="bg-white dark:bg-gray-800 p-2 rounded-lg shadow-sm space-y-4 w-full">
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{__('Profile Photo')}}</h2>

                            <div class="flex flex-col items-center justify-center mb-6 space-y-4">
                                <div class="flex-shrink-0">
                                    @if($new_profile_photo)
                                        <img src="{{ $new_profile_photo->temporaryUrl() }}" class="h-32 w-32 rounded-full object-cover" alt="{{$form->edit_user->username}}">
                                    @elseif($form->edit_profile_photo_path)
                                        <img src="{{ Storage::url($form->edit_profile_photo_path) }}" class="h-32 w-32 rounded-full object-cover" alt="{{$form->edit_user->username}}">
                                    @endif
                                </div>

                                <div>
                                    <input
                                        type="file"
                                        wire:model.blur="new_profile_photo"
                                        class="hidden"
                                        id="new_profile_photo"
                                        accept="image/*"
                                    >
                                    <label
                                        for="new_profile_photo"
                                        class="cursor-pointer bg-white py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                    >
                                        Change Photo
                                    </label>
                                </div>

                                <x-input-error for="new_profile_photo" class="mt-2" />
                            </div>

                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{__('Basic Information')}}</h2>

                            <div class="grid grid-cols-2 gap-4">
                                <div class="col-span-2">
                                    <x-label for="edit_first_name" value="First Name" class="mb-2" />

                                    <x-input
                                        type="text"
                                        id="edit_first_name"
                                        wire:model.blur="form.edit_first_name"
                                        class="block w-full"
                                    />

                                    <x-input-error for="form.edit_first_name" class="mt-2" />
                                </div>

                                <div class="col-span-1">
                                    <x-label for="edit_middle_name" value="Middle Name" class="mb-2" />

                                    <x-input
                                        type="text"
                                        id="edit_middle_name"
                                        wire:model.blur="form.edit_middle_name"
                                        class="block w-full"
                                    />

                                    <x-input-error for="form.edit_middle_name" class="mt-2" />
                                </div>

                                <div class="col-span-1">
                                    <x-label for="edit_last_name" value="Last Name" class="mb-2" />

                                    <x-input
                                        type="text"
                                        id="edit_last_name"
                                        wire:model.blur="form.edit_last_name"
                                        class="block w-full"
                                    />

                                    <x-input-error for="form.edit_last_name" class="mt-2" />
                                </div>

                                <div class="col-span-1">
                                    <x-label for="edit_birth_date" value="Birthdate" class="mb-2" />

                                    <x-input
                                        type="date"
                                        id="edit_birth_date"
                                        wire:model.blur="form.edit_birth_date"
                                        class="block w-full [&::-webkit-calendar-picker-indicator]:[filter:brightness(0)_invert(1)]"
                                    />

                                    <x-input-error for="form.edit_birth_date" class="mt-2" />
                                </div>

                                <div class="col-span-1">
                                    <x-label for="edit_sex" value="Sex" class="mb-2" />

                                    <select
                                        id="edit_sex"
                                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-200 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                        wire:model.blur="form.edit_sex"
                                    >
                                        <option value="">Select Sex</option>
                                        <option value="0">Male</option>
                                        <option value="1">Female</option>
                                    </select>

                                    <x-input-error for="form.edit_sex" class="mt-2" />
                                </div>

                                <div class="col-span-2">
                                    <x-label for="edit_contact_no" value="Contact Number" class="mb-2" />

                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 16 16" id="book-number">
                                                <path fill="#FFFFFF" d="M5.5 5.49536C5.5 5.7715 5.72386 5.99536 6 5.99536H6.60148L6.37904 7H5.5C5.22386 7 5 7.22386 5 7.5C5 7.77614 5.22386 8 5.5 8H6.15763L6.01634 8.63812C5.95665 8.90773 6.12682 9.17469 6.39643 9.23438C6.66604 9.29408 6.933 9.12391 6.9927 8.85429L7.18185 8H8.15061L8.00835 8.63733C7.94819 8.90684 8.1179 9.17408 8.38741 9.23424C8.65692 9.2944 8.92417 9.12469 8.98433 8.85518L9.17522 8H10C10.2761 8 10.5 7.77614 10.5 7.5C10.5 7.22386 10.2761 7 10 7H9.39844L9.62269 5.99536H10.5C10.7761 5.99536 11 5.7715 11 5.49536C11 5.21922 10.7761 4.99536 10.5 4.99536H9.84591L9.98738 4.36155C10.0475 4.09204 9.87783 3.8248 9.60832 3.76464C9.33881 3.70448 9.07156 3.87419 9.0114 4.1437L8.8213 4.99536H7.84711L7.98764 4.36066C8.04733 4.09105 7.87716 3.82409 7.60755 3.7644C7.33794 3.7047 7.07098 3.87487 7.01128 4.14449L6.82289 4.99536H6C5.72386 4.99536 5.5 5.21922 5.5 5.49536ZM8.37383 7H7.40326L7.6257 5.99536H8.59808L8.37383 7Z"></path>
                                                <path fill="#FFFFFF" d="M5 1H11C12.1046 1 13 1.89543 13 3V12.4969C13 12.7731 12.7761 12.9969 12.5 12.9969H4V13C4 13.5523 4.44772 14 5 14H12.5C12.7761 14 13 14.2239 13 14.5C13 14.7761 12.7761 15 12.5 15H5C3.89543 15 3 14.1046 3 13V3C3 1.89543 3.89543 1 5 1ZM4 3V11.9969H12V3C12 2.44772 11.5523 2 11 2H5C4.44771 2 4 2.44771 4 3Z"></path>
                                            </svg>
                                        </div>

                                        <x-input id="edit_contact_no" wire:model.blur="form.edit_contact_no" type="text" placeholder="Enter contact number" class="block w-full pl-10" />
                                    </div>

                                    <x-input-error for="form.edit_contact_no" class="mt-2" />
                                </div>

                                <div class="col-span-2">
                                    <x-label for="edit_email" value="Email" class="mb-2" />
                                    <div class="relative mt-1">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" id="email" class="h-5 w-5 text-white dark:text-white">
                                                <path fill="none" d="M0 0h24v24H0V0z"></path>
                                                <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm-.4 4.25l-7.07 4.42c-.32.2-.74.2-1.06 0L4.4 8.25c-.25-.16-.4-.43-.4-.72 0-.67.73-1.07 1.3-.72L12 11l6.7-4.19c.57-.35 1.3.05 1.3.72 0 .29-.15.56-.4.72z" fill="currentColor"></path>
                                            </svg>
                                        </div>
                                        <x-input
                                            id="edit_email"
                                            type="email"
                                            class="block w-full pl-10 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                                            wire:model.blur="form.edit_email"
                                        />
                                    </div>

                                    <x-input-error for="form.edit_email" class="mt-2" />
                                </div>

                                <div class="col-span-2">
                                    <x-label for="edit_username" value="Username" />

                                    <div class="relative mt-1">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" id="AtTheRate" class="h-5 w-5 text-white">
                                                <path fill="currentColor" d="M8,2 C11.3137085,2 14,4.6862915 14,8 C14,9.67717161 12.8661471,11 11.5,11 C10.7480447,11 10.2154919,10.6446121 9.88999307,10.0145587 C9.45625388,10.6143042 8.80559233,11 8,11 C6.47091113,11 5.5,9.61043223 5.5,8 C5.5,6.38956777 6.47091113,5 8,5 C8.59193714,5 9.10022577,5.20824062 9.50092179,5.55692138 L9.5,5.5 C9.5,5.22385763 9.72385763,5 10,5 C10.2454599,5 10.4496084,5.17687516 10.4919443,5.41012437 L10.5,5.5 L10.5,8 C10.5,9.36283631 10.8533902,10 11.5,10 C12.2767101,10 13,9.15616173 13,8 C13,5.23857625 10.7614237,3 8,3 C5.23857625,3 3,5.23857625 3,8 C3,10.7614237 5.23857625,13 8,13 C8.41606116,13 8.82489416,12.9492816 9.22016967,12.8501831 L9.51398538,12.7668244 L9.71904608,12.6967907 C9.97835552,12.6018527 10.2655298,12.735102 10.3604678,12.9944115 C10.4554058,13.2537209 10.3221565,13.5408952 10.062847,13.6358332 C9.98136966,13.6656636 9.89921124,13.6937253 9.81642131,13.7199941 C9.23376848,13.9048669 8.62299728,14 8,14 C4.6862915,14 2,11.3137085 2,8 C2,4.6862915 4.6862915,2 8,2 Z M8,6 C7.11563599,6 6.5,6.88109808 6.5,8 C6.5,9.11890192 7.11563599,10 8,10 C8.88436401,10 9.5,9.11890192 9.5,8 C9.5,6.88109808 8.88436401,6 8,6 Z"></path>
                                            </svg>
                                        </div>
                                        <x-input
                                            type="text"
                                            id="edit_username"
                                            class="block w-full pl-10 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                                            wire:model.blur="form.edit_username"
                                        />
                                    </div>

                                    <x-input-error for="form.edit_username" class="mt-2" />
                                </div>

                                <div class="col-span-2 space-y-4" x-data="{ edit_showBothPasswords: false }">
                                    <!-- Password Field -->
                                    <div>
                                        <x-label for="edit_password" value="Password" />

                                        <div class="relative">
                                            <!-- Password Icon -->
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" id="Password" class="h-5 w-5 text-white">
                                                    <path d="M25 1L12.611 13.388A9 9 0 0 0 1 22a9 9 0 0 0 9 9 9 9 0 0 0 8.611-11.612L21 17v-2h2l8-8V1h-6zm4 5.171L22.172 13H19v3.171l-1.803 1.802-.848.848.348 1.147c.201.662.303 1.345.303 2.032 0 3.86-3.141 7-7 7s-7-3.14-7-7 3.141-7 7-7c.686 0 1.37.102 2.031.302l1.146.348.848-.848L25.828 3H29v3.171z" fill="currentColor"/>
                                                    <circle cx="8" cy="24" r="2" fill="currentColor"/>
                                                    <path d="M20.646 10.647l6-6 .707.707-6 6z" fill="currentColor"/>
                                                </svg>
                                            </div>

                                            <!-- Password Input -->
                                            <input
                                                :type="edit_showBothPasswords ? 'text' : 'password'"
                                                id="edit_password"
                                                wire:model.blur="form.edit_password"
                                                class="block w-full pl-10 pr-10 dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300"
                                                autocomplete="new-password"
                                            />
                                        </div>

                                        <x-input-error for="form.edit_password" class="mt-2" />
                                    </div>

                                    <!-- Confirm Password Field -->
                                    <div>
                                        <x-label for="edit_confirm_password" value="Confirm Password" />
                                        <div class="relative">
                                            <!-- Password Icon -->
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" id="Password" class="h-5 w-5 text-white">
                                                    <path d="M25 1L12.611 13.388A9 9 0 0 0 1 22a9 9 0 0 0 9 9 9 9 0 0 0 8.611-11.612L21 17v-2h2l8-8V1h-6zm4 5.171L22.172 13H19v3.171l-1.803 1.802-.848.848.348 1.147c.201.662.303 1.345.303 2.032 0 3.86-3.141 7-7 7s-7-3.14-7-7 3.141-7 7-7c.686 0 1.37.102 2.031.302l1.146.348.848-.848L25.828 3H29v3.171z" fill="currentColor"/>
                                                    <circle cx="8" cy="24" r="2" fill="currentColor"/>
                                                    <path d="M20.646 10.647l6-6 .707.707-6 6z" fill="currentColor"/>
                                                </svg>
                                            </div>

                                            <!-- Confirm Password Input -->
                                            <input
                                                :type="edit_showBothPasswords ? 'text' : 'password'"
                                                id="edit_confirm_password"
                                                wire:model.blur="form.edit_confirm_password"
                                                class="block w-full pl-10 pr-10 dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300"
                                                autocomplete="new-password"
                                            />
                                        </div>

                                        <x-input-error for="form.edit_confirm_password" class="mt-2" />
                                    </div>

                                    <!-- Show/Hide Password -->
                                    <div class="mt-4">
                                        <label for="edit_checkbox" class="inline-flex items-center text-sm text-gray-600 dark:text-gray-400">
                                            <input
                                                id="edit_checkbox"
                                                type="checkbox"
                                                class="form-checkbox rounded border-gray-300 dark:border-gray-700 text-primary-600 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50 dark:bg-gray-900"
                                                x-model="edit_showBothPasswords"
                                            >
                                            <span class="ml-2">Show passwords</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="border-gray-300 dark:border-gray-600" />

                        <!-- Address Section -->
                        <div class="bg-white dark:bg-gray-800 p-2 rounded-lg shadow-sm space-y-4 w-full">
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Address Information</h2>

                            <div class="grid grid-cols-2 gap-4">
                                <!-- House Number -->
                                <div class="col-span-1">
                                    <x-label for="edit_house_number" value="House Number" />
                                    <x-input
                                        id="edit_house_number"
                                        type="text"
                                        class="mt-1 block w-full dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300"
                                        wire:model.blur="form.edit_house_number"
                                        placeholder="e.g., 123"
                                    />

                                    <x-input-error for="form.edit_house_number" class="mt-2" />
                                </div>

                                <!-- Street -->
                                <div class="col-span-1">
                                    <x-label for="edit_street" value="Street" required />
                                    <x-input
                                        id="edit_street"
                                        type="text"
                                        class="mt-1 block w-full dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300"
                                        wire:model.blur="form.edit_street"
                                        required
                                        placeholder="e.g., Main Street"
                                    />

                                    <x-input-error for="form.edit_street" class="mt-2" />
                                </div>

                                <!-- Barangay -->
                                <div class="col-span-2">
                                    <x-label for="edit_barangay" value="Barangay" required />
                                    <x-input
                                        id="edit_barangay"
                                        type="text"
                                        class="mt-1 block w-full dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300"
                                        wire:model.blur="form.edit_barangay"
                                        required
                                        placeholder="e.g., Barangay 123"
                                    />

                                    <x-input-error for="form.edit_barangay" class="mt-2" />
                                </div>

                                <!-- City -->
                                <div class="col-span-2">
                                    <x-label for="edit_city" value="City" required />
                                    <x-input
                                        id="edit_city"
                                        type="text"
                                        class="mt-1 block w-full dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300"
                                        wire:model.blur="form.edit_city"
                                        required
                                        placeholder="e.g., Manila"
                                    />


                                    <x-input-error for="form.edit_city" class="mt-2" />
                                </div>

                                <!-- Province -->
                                <div class="col-span-2">
                                    <x-label for="edit_province" value="Province" required />
                                    <x-input
                                        id="edit_province"
                                        type="text"
                                        class="mt-1 block w-full dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300"
                                        wire:model.blur="form.edit_province"
                                        required
                                        placeholder="e.g., Metro Manila"
                                    />

                                    <x-input-error for="form.edit_province" class="mt-2" />
                                </div>

                                <!-- Region -->
                                <div class="col-span-2">
                                    <x-label for="edit_region" value="Region" required />
                                    <x-input
                                        id="edit_region"
                                        type="text"
                                        class="mt-1 block w-full dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300"
                                        wire:model.blur="form.edit_region"
                                        required
                                        placeholder="e.g., NCR"
                                    />

                                    <x-input-error for="form.edit_region" class="mt-2" />
                                </div>

                                <!-- Country -->
                                <div class="col-span-2">
                                    <x-label for="edit_country" value="Country" required />
                                    <x-input
                                        id="edit_country"
                                        type="text"
                                        class="mt-1 block w-full dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300"
                                        wire:model.blur="form.edit_country"
                                        readonly
                                    />

                                    <x-input-error for="form.edit_country" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <hr class="border-gray-300 dark:border-gray-600" />

                        <!-- Role-specific Information -->
                        <div class="bg-white dark:bg-gray-800 p-2 rounded-lg shadow-sm space-y-4 w-full">
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Additional Information</h2>
                            <!-- Role fields -->
                            <div>
                                <x-label for="edit_role" value="Role" required />
                                <select
                                    id="edit_role"
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-200 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                    wire:model.live="form.edit_role"
                                    required
                                >
                                    <option selected="">Select Role</option>
                                    <option value="barangay-official">Barangay Official</option>
                                    <option value="bhw">BHW</option>
                                    <option value="doctor">Doctor</option>
                                </select>


                                <x-input-error for="form.edit_role" class="mt-2" />
                            </div>
                        </div>
                        @if($form->edit_role == 'barangay-official')
                            <div class="bg-white dark:bg-gray-800 p-2 rounded-lg shadow-sm space-y-4 w-full">
                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Barangay Official Information</h2>
                                {{-- Barangay Official fields --}}
                                <div class="grid grid-cols-2 gap-4">
                                    <!-- Position -->
                                    <div class="col-span-2">
                                        <x-label for="edit_position" value="Position" required />
                                        <x-input
                                            id="edit_position"
                                            type="text"
                                            class="mt-1 block w-full dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300"
                                            wire:model.blur="form.edit_position"
                                            required
                                            placeholder="e.g., Barangay Captain"
                                        />

                                        <x-input-error for="form.edit_position" class="mt-2" />
                                    </div>

                                    <!-- Term Start -->
                                    <div class="col-span-1">
                                        <x-label for="edit_term_start" value="Term Start Date" required />
                                        <x-input
                                            id="edit_term_start"
                                            type="date"
                                            class="mt-1 block w-full dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300"
                                            wire:model.blur="form.edit_term_start"
                                            x-on:change="$dispatch('edit-term-start-changed', { value: $event.target.value })"
                                        />
                                        <x-input-error for="form.edit_term_start" class="mt-2" />
                                    </div>

                                    <!-- Term End -->
                                    <div class="col-span-1">
                                        <x-label for="edit_term_end" value="Term End Date" required />
                                        <x-input
                                            id="edit_term_end"
                                            type="date"
                                            class="mt-1 block w-full dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300"
                                            wire:model.blur="form.edit_term_end"
                                            x-on:term-start-changed.window="$el.min = $event.detail.value"
                                        />
                                        <x-input-error for="form.edit_term_end" class="mt-2" />
                                    </div>
                                </div>
                            </div>
                        @elseif($form->edit_role == 'bhw')
                            <div class="bg-white dark:bg-gray-800 p-2 rounded-lg shadow-sm space-y-4 w-full">
                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">BHW Information</h2>

                                <div class="grid grid-cols-2 gap-4">
                                    <!-- Certification Number -->
                                    <div class="col-span-1">
                                        <x-label for="edit_certification_no" value="Certification No." required />
                                        <div class="relative">
                                            <x-input
                                                id="edit_certification_no"
                                                type="text"
                                                class="mt-1 block w-full uppercase dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300"
                                                wire:model.blur="form.edit_certification_no"
                                                required
                                                maxlength="20"
                                                placeholder="e.g., CERT-2025-0001"
                                                x-data=""
                                                x-on:input="$el.value = $el.value.toUpperCase()"
                                            />
                                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pt-1">
                                                <span class="text-sm text-gray-400 dark:text-gray-500" x-text="edit_certification_no ? edit_certification_no.length : 0">/20</span>
                                            </div>
                                        </div>
                                        <div class="mt-1 text-xs text-gray-500 dark:text-gray-400 text-wrap">
                                            Maximum of 20 characters. Automatically converted to uppercase.
                                        </div>

                                        <x-input-error for="form.edit_certification_no" class="mt-2" />
                                    </div>

                                    <!-- Barangay -->
                                    <div class="col-span-1">
                                        <x-label for="edit_barangay" value="Barangay" required />
                                        <x-input
                                            id="edit_barangay"
                                            type="text"
                                            class="mt-1 block w-full dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300"
                                            wire:model.blur="form.edit_bhw_barangay"
                                            required
                                            placeholder="e.g., Barangay 123"
                                        />

                                        <x-input-error for="form.edit_bhw_barangay" class="mt-2" />
                                    </div>
                                </div>
                            </div>
                        @elseif($form->edit_role == 'doctor')
                            <div class="bg-white dark:bg-gray-800 p-2 rounded-lg shadow-sm space-y-4 w-full">
                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Doctor Information</h2>

                                <div class="grid grid-cols-2 gap-4">
                                    <!-- License Number -->
                                    <div class="col-span-1">
                                        <x-label for="edit_license_number" value="PRC License Number" required />
                                        <div class="relative">
                                            <x-input
                                                id="edit_license_number"
                                                type="text"
                                                class="mt-1 block w-full uppercase dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300"
                                                wire:model.blur="form.edit_license_number"
                                                required
                                                maxlength="7"
                                                placeholder="e.g., 0123456"
                                                x-data="{
                                                    mask(e) {
                                                        let value = e.target.value.replace(/\D/g, '');
                                                        if (value.length > 7) value = value.slice(0, 7);
                                                        e.target.value = value;
                                                        return value;
                                                    }
                                                }"
                                                x-on:input="mask($event)"
                                            />
                                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pt-1">
                                                <span class="text-sm text-gray-400 dark:text-gray-500" x-text="edit_license_number ? edit_license_number.length : 0">/7</span>
                                            </div>
                                        </div>
                                        <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                            Enter your 7-digit PRC license number
                                        </div>

                                        <x-input-error for="form.edit_license_number" class="mt-2" />
                                    </div>

                                    <!-- Specialization -->
                                    <div class="col-span-1">
                                        <x-label for="edit_specialization" value="Specialization" required />
                                        <select
                                            id="edit_specialization"
                                            wire:model.blur="form.edit_specialization"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300 focus:border-primary-500 focus:ring-primary-500"
                                            required
                                        >
                                            <option value="">Select Specialization</option>
                                            <optgroup label="Primary Care">
                                                <option value="family_medicine">Family Medicine</option>
                                                <option value="internal_medicine">Internal Medicine</option>
                                                <option value="pediatrics">Pediatrics</option>
                                                <option value="general_practice">General Practice</option>
                                            </optgroup>
                                            <optgroup label="Medical Specialties">
                                                <option value="cardiology">Cardiology</option>
                                                <option value="dermatology">Dermatology</option>
                                                <option value="endocrinology">Endocrinology</option>
                                                <option value="gastroenterology">Gastroenterology</option>
                                                <option value="neurology">Neurology</option>
                                                <option value="oncology">Oncology</option>
                                                <option value="psychiatry">Psychiatry</option>
                                                <option value="pulmonology">Pulmonology</option>
                                            </optgroup>
                                            <optgroup label="Surgical Specialties">
                                                <option value="general_surgery">General Surgery</option>
                                                <option value="neurosurgery">Neurosurgery</option>
                                                <option value="orthopedics">Orthopedics</option>
                                                <option value="plastic_surgery">Plastic Surgery</option>
                                                <option value="urology">Urology</option>
                                            </optgroup>
                                            <optgroup label="Other Specialties">
                                                <option value="anesthesiology">Anesthesiology</option>
                                                <option value="obstetrics_gynecology">Obstetrics & Gynecology</option>
                                                <option value="ophthalmology">Ophthalmology</option>
                                                <option value="otolaryngology">Otolaryngology (ENT)</option>
                                                <option value="pathology">Pathology</option>
                                                <option value="radiology">Radiology</option>
                                            </optgroup>
                                        </select>

                                        <x-input-error for="form.edit_specialization" class="mt-2" />
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </form>
        </x-slot>

        <x-slot name="footer" class="border-t border-gray-300 dark:border-gray-600">
            <div class="flex items-center justify-end space-x-3">
                <x-secondary-button wire:click="close" wire:loading.attr="disabled">
                    Cancel
                </x-secondary-button>

                <x-button
                    class="ml-3"
                    color="blue"
                    :darkMode="false"
                    wire:click="update"
                    wire:loading.attr="disabled"
                    :disabled="$errors->any()"
                >
                    <span wire:loading.remove wire:target="save">Save</span>
                    <span wire:loading wire:target="save">Saving...</span>
                </x-button>
            </div>
        </x-slot>
    </x-dialog-modal>
</div>
