<div>
    <x-dialog-modal wire:model="isOpen">
        <x-slot name="title">
            {{ __('Add New Patient') }}
        </x-slot>

        <x-slot name="content">
            <div class="grid grid-cols-2 gap-4">
                <!-- First Name -->
                <div>
                    <x-label for="first_name" value="{{ __('First Name') }}" />
                    <x-input id="first_name" type="text" class="mt-1 block w-full" 
                        wire:model="patient.first_name" />
                    <x-input-error for="patient.first_name" class="mt-2" />
                </div>

                <!-- Last Name -->
                <div>
                    <x-label for="last_name" value="{{ __('Last Name') }}" />
                    <x-input id="last_name" type="text" class="mt-1 block w-full" 
                        wire:model="patient.last_name" />
                    <x-input-error for="patient.last_name" class="mt-2" />
                </div>

                <!-- Date of Birth -->
                <div>
                    <x-label for="date_of_birth" value="{{ __('Date of Birth') }}" />
                    <x-input id="date_of_birth" type="date" class="mt-1 block w-full" 
                        wire:model="patient.date_of_birth" />
                    <x-input-error for="patient.date_of_birth" class="mt-2" />
                </div>

                <!-- Gender -->
                <div>
                    <x-label for="gender" value="{{ __('Gender') }}" />
                    <select id="gender" wire:model="patient.gender" 
                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option value="">Select Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                    <x-input-error for="patient.gender" class="mt-2" />
                </div>

                <!-- Contact Number -->
                <div>
                    <x-label for="contact_number" value="{{ __('Contact Number') }}" />
                    <x-input id="contact_number" type="tel" class="mt-1 block w-full" 
                        wire:model="patient.contact_number" />
                    <x-input-error for="patient.contact_number" class="mt-2" />
                </div>

                <!-- Email -->
                <div>
                    <x-label for="email" value="{{ __('Email') }}" />
                    <x-input id="email" type="email" class="mt-1 block w-full" 
                        wire:model="patient.email" />
                    <x-input-error for="patient.email" class="mt-2" />
                </div>

                <!-- Address -->
                <div class="col-span-2">
                    <x-label for="address" value="{{ __('Address') }}" />
                    <x-textarea id="address" class="mt-1 block w-full" 
                        wire:model="patient.address" />
                    <x-input-error for="patient.address" class="mt-2" />
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="close" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-button class="ml-3" wire:click="save" wire:loading.attr="disabled">
                {{ __('Save') }}
            </x-button>
        </x-slot>
    </x-dialog-modal>
</div> 