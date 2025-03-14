<!-- Large container rectangle -->
<div class="bg-gray-900 rounded-lg p-5">
    <!-- Grid of 4 rectangles -->
    <div class="grid grid-cols-4 gap-6">
        <!-- Barangay Officials -->
        <div class="bg-blue-600 rounded-lg p-4 h-28 flex items-center">
            <div class="flex flex-col">
                <span class="text-gray-100 text-lg mb-1">{{__('Barangay Officials')}}</span>
                <span class="text-white text-4xl font-bold">{{ $barangay_official_count }}</span>
            </div>
        </div>
        <!-- BHW -->
        <div class="bg-green-600 rounded-lg p-4 h-28 flex items-center">
            <div class="flex flex-col">
                <span class="text-gray-100 text-lg mb-1">{{__('BHWs')}}</span>
                <span class="text-white text-4xl font-bold">{{ $bhw_count }}</span>
            </div>
        </div>
        <!-- Doctor -->
        <div class="bg-purple-600 rounded-lg p-4 h-28 flex items-center">
            <div class="flex flex-col">
                <span class="text-gray-100 text-lg mb-1">{{__('Doctors')}}</span>
                <span class="text-white text-4xl font-bold">{{ $doctor_count }}</span>
            </div>
        </div>
        <!-- Deleted Accounts -->
        <div class="bg-red-600 rounded-lg p-4 h-28 flex items-center">
            <div class="flex flex-col">
                <span class="text-gray-100 text-lg mb-1">{{__('Deleted Accounts')}}</span>
                <span class="text-white text-4xl font-bold">{{ $deleted_user_count }}</span>
            </div>
        </div>
    </div>
</div>
