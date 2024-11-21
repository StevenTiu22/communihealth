<div>
    <x-modal wire:model.live="show">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 mb-4">
                Edit Patient Information
            </h2>

            <form wire:submit="save" class="space-y-4">
                <div class="grid grid-cols-3 gap-4">
                    <!-- First Name -->
                    <div>
                        <x-label for="first_name" value="First Name" />
                        <x-input wire:model="first_name" id="first_name" type="text" class="mt-1 block w-full" />
                        @error('first_name') <x-input-error for="first_name" class="mt-2" /> @enderror
                    </div>

                    <!-- Middle Name -->
                    <div>
                        <x-label for="middle_name" value="Middle Name" />
                        <x-input wire:model="middle_name" id="middle_name" type="text" class="mt-1 block w-full" />
                        @error('middle_name') <x-input-error for="middle_name" class="mt-2" /> @enderror
                    </div>

                    <!-- Last Name -->
                    <div>
                        <x-label for="last_name" value="Last Name" />
                        <x-input wire:model="last_name" id="last_name" type="text" class="mt-1 block w-full" />
                        @error('last_name') <x-input-error for="last_name" class="mt-2" /> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <!-- Sex -->
                    <div>
                        <x-label for="sex" value="Sex" />
                        <select wire:model="sex" id="sex" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="">Select Sex</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                        @error('sex') <x-input-error for="sex" class="mt-2" /> @enderror
                    </div>

                    <!-- Birthdate -->
                    <div>
                        <x-label for="birthdate" value="Birthdate" />
                        <x-input wire:model="birthdate" id="birthdate" type="date" class="mt-1 block w-full" />
                        @error('birthdate') <x-input-error for="birthdate" class="mt-2" /> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <!-- Contact Number -->
                    <div>
                        <x-label for="contact_num" value="Contact Number" />
                        <x-input wire:model="contact_num" id="contact_num" type="text" class="mt-1 block w-full" />
                        @error('contact_num') <x-input-error for="contact_num" class="mt-2" /> @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <x-label for="email" value="Email" />
                        <x-input wire:model="email" id="email" type="email" class="mt-1 block w-full" />
                        @error('email') <x-input-error for="email" class="mt-2" /> @enderror
                    </div>
                </div>

                <div class="flex space-x-4">
                    <!-- 4Ps -->
                    <div class="flex items-center">
                        <input wire:model="is_4ps" id="is_4ps" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                        <x-label for="is_4ps" value="4Ps Member" class="ml-2" />
                    </div>

                    <!-- NHTS -->
                    <div class="flex items-center">
                        <input wire:model="is_NHTS" id="is_NHTS" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                        <x-label for="is_NHTS" value="NHTS Member" class="ml-2" />
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <x-button wire:click="close">Cancel</x-secondary-button>
                    <x-button type="submit">Save Changes</x-primary-button>
                </div>
            </form>
        </div>
    </x-modal>
</div> 