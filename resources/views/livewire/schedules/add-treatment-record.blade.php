<div>
    <button
        type="button"
        wire:click="open"
        class="bg-cyan-600 hover:bg-cyan-700 focus:ring focus:ring-cyan-300 rounded-full focus:outline-none dark:bg-cyan-500 dark:hover:bg-cyan-600 dark:focus:ring-cyan-700 text-white text-sm px-3 py-1 font-medium"
    >
        Add Treatment Record
    </button>

    <x-dialog-modal wire:model="showModal">
        <x-slot name="title">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Add Treatment Record</h3>
        </x-slot>

        <x-slot name="content">
            <div class="space-y-5 dark:text-gray-200">
                <div>
                    <label for="disease_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Disease</label>
                    <select
                        id="disease_id"
                        wire:model.live="disease_id"
                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md dark:bg-gray-900 dark:border-gray-700 dark:text-gray-200 dark:focus:ring-indigo-500 dark:focus:border-indigo-500"
                    >
                        <option value="">None</option>
                        @forelse($diseases as $disease)
                            <option value="{{ $disease->id }}">{{ $disease->name }}</option>
                        @empty
                            <option value="" disabled>No diseases available</option>
                        @endforelse
                    </select>
                    <x-input-error for="disease_id" class="mt-1" />
                </div>

                <div>
                    <label for="assessment" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Assessment</label>
                    <textarea
                        id="assessment"
                        wire:model.live="assessment"
                        rows="3"
                        class="mt-1 block w-full border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md dark:bg-gray-900 dark:border-gray-700 dark:text-gray-200 dark:focus:ring-indigo-500 dark:focus:border-indigo-500"
                        placeholder="Enter assessment details"
                    ></textarea>
                    <x-input-error for="assessment" class="mt-1" />
                </div>

                <div>
                    <label for="diagnosis" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Diagnosis</label>
                    <textarea
                        id="diagnosis"
                        wire:model="diagnosis"
                        rows="3"
                        class="mt-1 block w-full border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md dark:bg-gray-900 dark:border-gray-700 dark:text-gray-200 dark:focus:ring-indigo-500 dark:focus:border-indigo-500"
                        placeholder="Enter diagnosis details"
                    ></textarea>
                    <x-input-error for="diagnosis" class="mt-1" />
                </div>

                <div>
                    <label for="treatment" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Treatment <span class="text-gray-500 dark:text-gray-400 font-normal">(Optional)</span>
                    </label>
                    <textarea
                        id="treatment"
                        wire:model="treatment"
                        rows="3"
                        class="mt-1 block w-full border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md dark:bg-gray-900 dark:border-gray-700 dark:text-gray-200 dark:focus:ring-indigo-500 dark:focus:border-indigo-500"
                        placeholder="Enter treatment details"
                    ></textarea>
                    <x-input-error for="treatment" class="mt-1" />
                </div>

                <div>
                    <label for="medication" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Medication <span class="text-gray-500 dark:text-gray-400 font-normal">(Optional)</span>
                    </label>
                    <textarea
                        id="medication"
                        wire:model="medication"
                        rows="3"
                        class="mt-1 block w-full border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md dark:bg-gray-900 dark:border-gray-700 dark:text-gray-200 dark:focus:ring-indigo-500 dark:focus:border-indigo-500"
                        placeholder="Enter medication details"
                    ></textarea>
                    <x-input-error for="medication" class="mt-1" />
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <div class="flex justify-end space-x-3">
                <x-button
                    type="button"
                    class="bg-gray-600 hover:bg-gray-700 dark:bg-gray-700 dark:hover:bg-gray-600 transition-all duration-200"
                    wire:click="close"
                >
                    Cancel
                </x-button>
                <button
                    type="button"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:bg-indigo-700 dark:hover:bg-indigo-800 transition-all duration-200"
                    wire:click="save"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Save Record
                </button>
            </div>
        </x-slot>
    </x-dialog-modal>
</div>
