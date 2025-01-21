<div wire:ignore.self id="edit-modal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
     <!-- Modal content -->
    <div class="relative w-full max-w-2xl max-h-full bg-white rounded-lg shadow dark:bg-gray-700">
        <!-- Modal header -->
        <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                Edit User
            </h3>
            <button type="button" wire:click="close" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="edit-modal">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
        </div>

        {{ dd($selectedUser); }}
        {{--
        <!-- Modal body -->
        <div class="p-6 space-y-4 max-h-[calc(100vh-200px)] overflow-y-auto">   
            <form id="editUserForm" action="#" method="post" enctype="multipart/form-data">
                @csrf
                <div class="grid gap-4">
                    <!-- User Details -->
                    <div>
                        <h3 class="mb-3 text-lg font-medium text-gray-900 dark:text-white">User Details</h3>
                        <div class="grid gap-3 mb-4">
                            <div>
                                <label for="role" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Role</label>
                                <select name="role" id="role" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                    <option value='0' {{ $selectedUser->role === 'BHW' ? 'selected' : '' }}>BHW</option>
                                    <option value='1' {{ $selectedUser->role === 'Doctor' ? 'selected' : '' }}>Doctor</option>
                                    <option value='2' {{ $selectedUser->role === 'Barangay Official' ? 'selected' : '' }}>Barangay Official</option>
                                </select>
                            </div>
                            <!-- Doctor Details -->
                            <div id="doctorFields" style="display: none;">
                                <hr class="my-3.5 border-gray-200 dark:border-gray-700">
                                <h4 class="mt-2 mb-4 text-lg font-medium text-gray-900 dark:text-white">Doctor Details</h4>
                                <div class="mb-2">
                                    <label for="license_number" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">License Number</label>
                                    <input type="text" name="license_number" id="license_number" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="License Number" value="{{ $selectedUser->doctor->license_number ?? '' }}">
                                </div>
                                <div class="mb-10">
                                    <label for="specialization" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Specialization</label>
                                    <input type="text" name="specialization" id="specialization" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Specialization" value="{{ $selectedUser->role === '1' ? $selectedUser->doctor->specializations->first()->name : '' }}">
                                </div>
                                <hr class="mt-4 border-gray-200 dark:border-gray-700">
                            </div>
                            <div>
                                <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">First Name</label>
                                <input type="text" name="first_name" id="first_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="{{ $selectedUser->first_name }}" required>
                            </div>
                            <div>
                                <label for="middle_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Middle Name</label>
                                <input type="text" name="middle_name" id="middle_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="{{ $selectedUser->middle_name }}">
                            </div>
                            <div>
                                <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Last Name</label>
                                <input type="text" name="last_name" id="last_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="{{ ucfirst(strtolower($selectedUser->last_name)) }}" required>
                            </div>
                            <div>
                                <label for="birth_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Date of Birth</label>
                                <input type="date" name="birth_date" id="birth_date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 [&::-webkit-calendar-picker-indicator]:filter [&::-webkit-calendar-picker-indicator]:invert" value="{{ date('Y-m-d', strtotime($selectedUser->birth_date)) }}" required>
                            </div>
                            <div>
                                <label for="gender" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Gender</label>
                                <select name="gender" id="gender" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                    <option value="">Select gender</option>
                                    <option value="0" {{ $selectedUser->gender === 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="1" {{ $selectedUser->gender === 'Female' ? 'selected' : '' }}>Female</option>
                                </select>
                            </div>
                            <div>
                                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                                <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="{{ $selectedUser->email }}" required>
                            </div>
                            <div>
                                <label for="contact_number" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Phone Number</label>
                                <input type="tel" name="contact_number" id="contact_number" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="{{ $selectedUser->contact_number }}" pattern="[0-9]{11}" maxlength="11" required>
                            </div>
                        </div>
                    </div>
                    
                    <hr class="h-px my-4 bg-gray-300 border-0 dark:bg-gray-600">
                    
                    <!-- Address -->
                    <div>
                        <h3 class="mb-3 text-lg font-medium text-gray-900 dark:text-white">Address</h3>
                        <div class="grid gap-3 mb-3">
                            <div>
                                <label for="house_number" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">House Number</label>
                                <input type="text" name="house_number" id="house_number" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="{{ $selectedUser->addresses->first()->house_number }}" required>
                            </div>
                            <div>
                                <label for="street" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Street</label>
                                <input type="text" name="street" id="street" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="{{ $selectedUser->addresses->first()->street }}" required>
                            </div>
                            <div>
                                <label for="barangay" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Barangay</label>
                                <input type="text" name="barangay" id="barangay" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="{{ $selectedUser->addresses->first()->barangay }}" required>
                            </div>
                            <div>
                                <label for="city" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">City</label>
                                <input type="text" name="city" id="city" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="{{ $selectedUser->addresses->first()->city }}" required>
                            </div>
                        </div>
                    </div>
                    <hr class="h-px my-4 bg-gray-300 border-0 dark:bg-gray-600">
                </div>
            </form>
        </div>

        <!-- Modal footer -->
        <div class="flex items-center justify-end p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
            <button type="button" data-modal-hide="edit-modal" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Cancel</button>
            <button type="submit" form="editUserForm" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Update</button>
        </div>

        --}}
    </div>
</div>