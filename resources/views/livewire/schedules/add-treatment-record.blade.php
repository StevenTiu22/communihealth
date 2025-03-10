<div>
    <x-button type="button" class="bg-blue-500 hover:bg-blue-600" wire:click="open">
        Add Treatment Record
    </x-button>

    <x-dialog-modal wire:model="showModal">
        <x-slot name="title">
            <h3 class="text-lg font-medium text-gray-900">Add Treatment Record</h3>
        </x-slot>

        <x-slot name="content">
            <div class="space-y-4">
                <div>
                    <label for="disease_id" class="block text-sm font-medium text-gray-700">Disease</label>
                    <select
                        id="disease_id"
                        wire:model.live="disease_id"
                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md"
                    >
                        <option value="">Routine Check-up</option>
                        @forelse($diseases as $disease)
                            <option value="{{ $disease->id }}">{{ $disease->name }}</option>
                        @empty
                            <option value="" disabled>No diseases available</option>
                        @endforelse
                    </select>
                    <x-input-error for="disease_id" class="mt-1" />
                </div>

                <div>
                    <label for="assessment" class="block text-sm font-medium text-gray-700">Assessment</label>
                    <textarea
                        id="assessment"
                        wire:model.live="assessment"
                        rows="3"
                        class="mt-1 block w-full border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md"
                        placeholder="Enter assessment details"
                    ></textarea>
                    <x-input-error for="assessment" class="mt-1" />
                </div>

                <div>
                    <label for="diagnosis" class="block text-sm font-medium text-gray-700">Diagnosis</label>
                    <textarea
                        id="diagnosis"
                        wire:model="diagnosis"
                        rows="3"
                        class="mt-1 block w-full border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md"
                        placeholder="Enter diagnosis details"
                    ></textarea>
                    <x-input-error for="diagnosis" class="mt-1" />
                </div>

                <div>
                    <label for="treatment" class="block text-sm font-medium text-gray-700">Treatment (Optional)</label>
                    <textarea
                        id="treatment"
                        wire:model="treatment"
                        rows="3"
                        class="mt-1 block w-full border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md"
                        placeholder="Enter treatment details"
                    ></textarea>
                    <x-input-error for="treatment" class="mt-1" />
                </div>

                <div>
                    <label for="medication" class="block text-sm font-medium text-gray-700">Medication (Optional)</label>
                    <textarea
                        id="medication"
                        wire:model="medication"
                        rows="3"
                        class="mt-1 block w-full border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md"
                        placeholder="Enter medication details"
                    ></textarea>
                    <x-input-error for="medication" class="mt-1" />
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <div class="flex justify-end space-x-3">
                <x-button type="button" class="bg-gray-300 hover:bg-gray-400" wire:click="close">
                    Cancel
                </x-button>
                <x-button type="button" class="bg-blue-500 hover:bg-blue-600" wire:click="save">
                    Save Record
                </x-button>
            </div>
        </x-slot>
    </x-dialog-modal>
</div>
