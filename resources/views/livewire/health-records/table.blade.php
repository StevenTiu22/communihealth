<div class="overflow-hidden">
    <div class="overflow-x-auto rounded-lg shadow-sm">
        <table class="min-w-full divide-y divide-gray-600">
            <thead class="bg-gray-900">
            <tr>
                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                    Patient
                </th>
                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                    Doctor
                </th>
                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                    Date
                </th>
                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                    Type
                </th>
                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                    Vital Signs
                </th>
                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                    Diagnosis
                </th>
                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                    Treatment
                </th>
                <th scope="col" class="px-4 py-3 text-center text-xs font-medium text-gray-300 uppercase tracking-wider">
                    Actions
                </th>
            </tr>
            </thead>
            <tbody class="bg-gray-700 divide-y divide-gray-600 rounded-b-lg">
            @forelse($health_records as $record)
                <tr wire:key="{{ $record->id }}" class="hover:bg-gray-600">
                    <td class="px-4 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            @if($record->patient->profile_photo_path)
                                <div class="flex-shrink-0 h-8 w-8">
                                    <img class="h-8 w-8 rounded-full object-cover" src="{{ Storage::url($record->patient->profile_photo_path) }}" alt="{{ $record->patient->full_name }}">
                                </div>
                            @endif
                            <div class="ml-2">
                                <div class="text-sm font-medium text-gray-200">{{ $record->patient->full_name }}</div>
                                <div class="text-xs text-gray-400">
                                    {{ $record->patient->age }} yrs • {{ $record->patient->sex == 0 ? 'Male' : 'Female' }}
                                </div>
                            </div>
                        </div>
                    </td>
                    @if($record->doctor)
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-200">
                            {{ 'Dr. ' . $record->doctor->last_name }}
                        </td>
                    @else
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-400">
                            No doctor assigned
                        </td>
                    @endif
                    <td class="px-4 py-3 whitespace-nowrap">
                        <div class="text-sm text-gray-200">{{ $record->appointment_date->format('M d, Y') }}</div>
                        <div class="text-xs text-gray-400">
                            {{ $record->time_in ? \Carbon\Carbon::createFromTimestamp($record->time_in)->addHours(8)->format('g:i A') : '' }}
                            {{ $record->time_out ? ' - ' . \Carbon\Carbon::createFromTimestamp($record->time_out)->addHours(8)->format('g:i A') : '' }}
                        </div>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs font-semibold rounded-full
                                @if($record->is_cancelled)
                                    bg-red-800 text-red-200
                                @else
                                    bg-indigo-800 text-indigo-200
                                @endif">
                                {{ $record->appointmentType->name }}
                            </span>
                        @if($record->chief_complaint)
                            <div class="text-xs text-gray-400 mt-1">{{ Str::limit($record->chief_complaint, 20) }}</div>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-200">
                        @if($record->vitalSign)
                            <div class="grid grid-cols-2 gap-x-2 gap-y-1 text-xs">
                                <div>Blood Pressure: <span class="text-gray-300">{{ $record->vitalSign->systolic . '/' . $record->vitalSign->diastolic }}</span></div>
                                <div>Temp: <span class="text-gray-300">{{ $record->vitalSign->temperature }}°C</span></div>
                                <div>Weight: <span class="text-gray-300">{{ $record->vitalSign->weight }}kg</span></div>
                                <div>Height: <span class="text-gray-300">{{ $record->vitalSign->height }}cm</span></div>
                            </div>
                        @else
                            <span class="text-gray-400 text-xs">Not recorded</span>
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        @if($record->treatmentRecord)
                            <div class="text-sm font-medium text-gray-200">
                                {{ $record->treatmentRecord->disease->name ?? 'Unspecified' }}
                            </div>
                            <div class="text-xs text-gray-400">{{ Str::limit($record->treatmentRecord->diagnosis, 30) }}</div>
                        @else
                            <span class="text-gray-400 text-xs">No diagnosis</span>
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        @if($record->treatmentRecord)
                            <div class="text-xs text-gray-300">{{ Str::limit($record->treatmentRecord->treatment, 30) }}</div>
                            <div class="text-xs text-gray-400 mt-1">Meds: {{ Str::limit($record->treatmentRecord->medication, 25) }}</div>
                        @endif
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-center text-sm font-medium">
                        <div class="flex justify-center space-x-2">
                            <div class="flex justify-center">
                                <div class="dropdown dropdown-end center">
                                    <div tabindex="0" role="button" class="btn m-1 bg-inherit border-transparent active:bg-gray-900">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 16 16" id="ellipsis">
                                            <path fill="currentColor" d="M10 2a2 2 0 1 1-3.999.001A2 2 0 0 1 10 2zM10 8a2 2 0 1 1-3.999.001A2 2 0 0 1 10 8zM10 14a2 2 0 1 1-3.999.001A2 2 0 0 1 10 14z"></path>
                                        </svg>
                                    </div>
                                    <ul class="dropdown-content menu bg-base-100 rounded-box z-[1] w-40 p-2 shadow">
                                        <li>Edit Vital Signs</li>
                                        <li>Edit Treatment Record</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="px-4 py-8 text-center text-gray-300">
                        No health records found matching your criteria. Try adjusting your search or filters.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="bg-gray-800 px-4 py-3 border-t border-gray-600">
        {{ $health_records->links() }}
    </div>
</div>
