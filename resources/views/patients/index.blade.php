<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Patient Records') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <div class="flex space-x-4">
                        <livewire:patients.patient-search />
                        @livewire('patients.patient-filter')
                    </div>
                    <livewire:patients.add-patient-modal />
                </div>

                @livewire('patients.patient-table')
                
                {{-- Modal Components --}}
                @livewire('patients.edit-patient-modal')
                @livewire('patients.delete-patient-modal')
                @livewire('patients.view-patient-modal')
            </div>
        </div>
    </div>
</x-app-layout> 