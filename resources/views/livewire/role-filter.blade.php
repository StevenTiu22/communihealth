<div class="flex items-center space-x-2">
    <div class="relative">
        <select
            wire:model.live="selectedRoles"
            class="block w-48 px-3 py-2 text-sm border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
        >
            <option value="">All Roles</option>
            @foreach($roles as $role)
                <option value="{{ $role['value'] }}">{{ $role['label'] }}</option>
            @endforeach
        </select>
    </div>
</div>