<div>
    {{-- Add User Button --}}
    <x-button
        wire:click="openModal"
        color="indigo"
        :darkMode="false"
        class="px-3 py-3 text-lg"
    >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
        </svg>
        Add User
    </x-button>

    {{-- Modal --}}
    <x-dialog-modal wire:model.live="showModal" maxWidth="xl" class="min-h-screen">
        <x-slot name="title">
            <div class="mt-4 border-b border-gray-300 dark:border-gray-600 pb-4">
                <h1 class="text-2xl font-bold">Add New User</h1>
            </div>
        </x-slot>

        <x-slot name="content">
            <form wire:submit.prevent="save" class="relative">
                <div class="h-[calc(100vh-15rem)] overflow-y-auto">
                    <div class="space-y-6 w-full">
                        {{-- Basic Information Section --}}
                        <div class="bg-white dark:bg-gray-800 p-2 rounded-lg shadow-sm space-y-4 w-full">
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Basic Information</h2>
                            {{-- First Name and other basic fields --}}
                        </div>

                        {{-- Address Section --}}
                        <div class="bg-white dark:bg-gray-800 p-2 rounded-lg shadow-sm space-y-4 w-full">
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Address Information</h2>
                            {{-- Address fields --}}
                        </div>

                        {{-- Role-specific Information --}}
                        @if($role == 0)
                            <div class="bg-white dark:bg-gray-800 p-2 rounded-lg shadow-sm space-y-4 w-full">
                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Barangay Official Information</h2>
                                {{-- Barangay Official fields --}}
                            </div>
                        @elseif($role == 1)
                            <div class="bg-white dark:bg-gray-800 p-2 rounded-lg shadow-sm space-y-4 w-full">
                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">BHW Information</h2>
                                {{-- BHW fields --}}
                            </div>
                        @elseif($role == 2)
                            <div class="bg-white dark:bg-gray-800 p-2 rounded-lg shadow-sm space-y-4 w-full">
                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Doctor Information</h2>
                                {{-- Doctor fields --}}
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Loading State --}}
                <div
                    wire:loading
                    wire:target="save"
                    class="absolute inset-0 bg-gray-200 bg-opacity-50 flex items-center justify-center backdrop-blur-sm"
                >
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-500"></div>
                </div>
            </form>
        </x-slot>

        <x-slot name="footer" class="border-t border-gray-300 dark:border-gray-600">
            <div class="flex items-center justify-end space-x-3">
                <x-secondary-button wire:click="closeModal" wire:loading.attr="disabled">
                    Cancel
                </x-secondary-button>

                <x-button
                    class="ml-3"
                    color="blue"
                    :darkMode="false"
                    wire:click="save"
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
