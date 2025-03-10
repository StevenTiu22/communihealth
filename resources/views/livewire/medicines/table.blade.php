<div class="flex flex-col h-full mt-5">
    <div class="overflow-x-auto rounded-lg">
        <div class="inline-block min-w-full align-middle">
            <div class="overflow-hidden shadow-sm border border-gray-200 dark:border-gray-700">
                <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                    <thead class="bg-gray-100 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400 cursor-pointer" wire:click="sortBy('generic_name')">
                                Tracking Number
                            </th>
                            <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400 cursor-pointer" wire:click="sortBy('name')">
                                Generic Name
                            </th>
                            <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400 cursor-pointer" wire:click="sortBy('name')">
                                Brand Name
                            </th>
                            <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                Category
                            </th>
                            <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400 cursor-pointer" wire:click="sortBy('expiry_date')">
                                Expiry Date
                            </th>
                            <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400 cursor-pointer" wire:click="sortBy('stock')">
                                Stock
                            </th>
                            <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                        @forelse($medicines as $medicine)
                            <tr wire:key="{{ $medicine->id }}" class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $medicine->tracking_number }}
                                </td>
                                <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $medicine->generic_name }}
                                </td>
                                <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $medicine->name }}
                                </td>
                                <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $medicine->category->name }}
                                </td>
                                <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $medicine->expiry_date->format('F j, Y') }}
                                </td>
                                <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $medicine->stock_level }}
                                </td>
                                <td class="p-4 whitespace-nowrap">
                                    <div class="inline-flex items-center gap-2 h-[20px]">
                                        <livewire:medicines.show :medicine_id="$medicine->id" wire:key="'view-'.$medicine->id" />
                                        <livewire:medicines.edit :medicine_id="$medicine->id" wire:key="'edit-'.$medicine->id" />
                                        <livewire:medicines.delete :medicine_id="$medicine->id" wire:key="'delete-'.$medicine->id" />
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-4 text-center text-gray-500 dark:text-gray-400">
                                    No medicines found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-4 px-4">
        {{ $medicines->links() }}
    </div>
</div>
