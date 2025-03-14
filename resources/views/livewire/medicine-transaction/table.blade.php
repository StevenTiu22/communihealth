<div>
    <div class="mx-6 px-6 py-5 flex justify-between items-center bg-gray-50 dark:bg-gray-700 rounded-t-lg">
        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100">Transaction Records</h3>
        <div class="flex items-center">
            <span class="mr-2 text-sm text-gray-500 dark:text-gray-400">Show</span>
            <select wire:model.live="perPage" class="border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50 rounded-md shadow-sm text-sm">
                <option>10</option>
                <option>25</option>
                <option>50</option>
                <option>100</option>
            </select>
        </div>
    </div>

    <div class="mx-6 overflow-x-auto bg-white dark:bg-gray-800">
        <table class="w-full divide-y divide-gray-200 outline-gray-400 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
            <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider cursor-pointer" wire:click="sortBy('transaction_id')">
                    <div class="flex items-center">
                        Transaction ID
                    </div>
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider cursor-pointer" wire:click="sortBy('medicine_name')">
                    <div class="flex items-center">
                        Medicine
                    </div>
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider cursor-pointer" wire:click="sortBy('quantity')">
                    <div class="flex items-center">
                        Quantity
                    </div>
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider cursor-pointer" wire:click="sortBy('patient_name')">
                    <div class="flex items-center">
                        Patient
                    </div>
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider cursor-pointer" wire:click="sortBy('created_at')">
                    <div class="flex items-center">
                        Date
                    </div>
                </th>
                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                    Actions
                </th>
            </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
            @forelse($transactions as $transaction)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                        {{ $transaction->id }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                        {{ $transaction->medicine->name }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                        {{ $transaction->quantity }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                        {{ $transaction->patient->full_name ?? 'N/A' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                        {{ $transaction->created_at->addHours(8)->format('M d, Y g:i A') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                        <div class="flex justify-center space-x-2">
                            <livewire:medicine-transaction.show :transaction_id="$transaction->id" />
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="px-6 py-10 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 text-center">
                        <div class="flex flex-col items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                            </svg>
                            <span class="mt-2 font-medium">No transactions found</span>
                            <p class="mt-1">Try adjusting your search or filter criteria</p>
                        </div>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mx-6 px-6 py-3 border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-b-lg">
        <div class="flex items-center justify-between">
            <div class="text-sm text-gray-500 dark:text-gray-400">
                Showing
                <span class="font-medium">{{ $transactions->firstItem() ?: 0 }}</span>
                to
                <span class="font-medium">{{ $transactions->lastItem() ?: 0 }}</span>
                of
                <span class="font-medium">{{ $transactions->total() }}</span>
                results
            </div>

            <div class="flex justify-end">
                {{ $transactions->links() }}
            </div>
        </div>
    </div>
</div>
