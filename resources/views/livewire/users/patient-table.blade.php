<div class="overflow-x-auto">
    <table class="min-w-full bg-white">
        <thead>
            <tr>
                <th class="px-6 py-3 border-b-2 border-gray-300 text-left">Name</th>
                <th class="px-6 py-3 border-b-2 border-gray-300 text-left">Date of Birth</th>
                <th class="px-6 py-3 border-b-2 border-gray-300 text-left">Contact</th>
                <th class="px-6 py-3 border-b-2 border-gray-300 text-left">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($patients as $patient)
                <tr>
                    <td class="px-6 py-4 border-b">{{ $patient->first_name }} {{ $patient->last_name }}</td>
                    <td class="px-6 py-4 border-b">{{ $patient->date_of_birth->format('M d, Y') }}</td>
                    <td class="px-6 py-4 border-b">{{ $patient->contact_number }}</td>
                    <td class="px-6 py-4 border-b space-x-2">
                        <button wire:click="view({{ $patient->id }})" 
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded">
                            View
                        </button>
                        <button wire:click="edit({{ $patient->id }})" 
                                class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-3 rounded">
                            Edit
                        </button>
                        <button wire:click="delete({{ $patient->id }})"
                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded">
                            Delete
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $patients->links() }}
    </div>
</div> 