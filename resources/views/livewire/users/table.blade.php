<div class="flex flex-col h-full mt-5">
    <div class="overflow-x-auto rounded-lg">
        <div class="inline-block min-w-full align-middle">
            <div class="overflow-hidden shadow-sm border border-gray-200 dark:border-gray-700">
                <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                    <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr>
                        <th scope="col" class="w-[100px] p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">{{__('Profile Picture')}}</th>
                        <th scope="col" class="w-[250px] p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">{{__('Full Name')}}</th>
                        <th scope="col" class="w-[120px] p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">{{__('Email')}}</th>
                        <th scope="col" class="w-[100px] p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">{{__('Username')}}</th>
                        <th scope="col" class="w-[120px] p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">{{__('Role')}}</th>
                        <th scope="col" class="w-[100px] p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">{{__('Status')}}</th>
                        <th scope="col" class="w-[100px] p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">{{__('Actions')}}</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                            <td class="flex items-center p-4 mr-6 space-x-6 whitespace-nowrap">
                                <img class="w-10 h-10 rounded-full" src="{{ asset($user->profile_photo_path) }}" alt="{{ $user->full_name }}">
                                <div class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                    <div class="text-base font-semibold text-gray-900 dark:text-white"></div>
                                </div>
                            </td>
                            <td class="p-4 overflow-hidden text-base font-normal text-gray-500 truncate dark:text-gray-400">
                                {{ $user->full_name }}
                            </td>

                            <td class="p-4 overflow-hidden text-base font-medium text-gray-900 truncate dark:text-white">
                                {{ $user->email }}
                            </td>

                            <td class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                {{ $user->username }}
                            </td>

                            <td class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                {{
                                    ucwords(str_replace('-', ' ', ($user->getRoleNames()[0])))
                                }}
                            </td>

                            @if ($user->last_login_at >= \Carbon\Carbon::now()->subMinutes(5))
                                <td class="p-4 text-sm font-normal text-green-500 whitespace-nowrap dark:text-green-400">
                                    <svg class="inline w-3 h-3 mb-1 mr-1 text-green-500 fill-current" viewBox="0 0 20 20">
                                        <circle cx="10" cy="10" r="10"/>
                                    </svg>
                                    {{__('Online')}}
                                </td>
                            @else
                                <td class="p-4 text-sm font-normal text-red-500 whitespace-nowrap dark:text-red-400">
                                    <svg class="inline w-3 h-3 mb-1 mr-1 text-red-500 fill-current" viewBox="0 0 20 20">
                                        <circle cx="10" cy="10" r="10"/>
                                    </svg>
                                    {{__('Offline')}}
                                </td>
                            @endif

                            <td class="p-4 space-x-1 whitespace-nowrap">
                                Edit/Delete
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="p-4 text-md text-center font-normal text-gray-500 dark:text-gray-400" colspan="7">{{__('No users found.')}}</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="mt-4 px-4">
        {{ $users->links() }}
    </div>
</div>
