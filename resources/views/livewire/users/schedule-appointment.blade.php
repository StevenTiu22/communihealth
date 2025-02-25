<div>
    <form wire:submit.prevent="save">
        <div class="space-y-4">
            <!-- Walk-in Toggle -->
            <div>
                <label class="inline-flex items-center">
                    <input type="checkbox" wire:model.live="isWalkIn" class="form-checkbox">
                    <span class="ml-2">Walk-in Appointment</span>
                </label>
            </div>

            <!-- Appointment Type -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Appointment Type</label>
                <select wire:model.live="appointmentTypeId" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <option value="">Select Type</option>
                    @foreach($appointmentTypes as $type)
                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Doctor Selection -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Doctor</label>
                <select wire:model="doctorId" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <option value="">Select Doctor</option>
                    @foreach($availableDoctors as $doctor)
                        <option value="{{ $doctor->id }}">Dr. {{ $doctor->full_name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Chief Complaint -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Chief Complaint</label>
                <textarea wire:model="chiefComplaint" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" rows="3"></textarea>
            </div>

            <!-- Date and Time -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Date</label>
                    <input type="date" wire:model="appointmentDate" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Time</label>
                    <input type="time" wire:model="appointmentTime" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                    Schedule Appointment
                </button>
            </div>
        </div>
    </form>
</div> 