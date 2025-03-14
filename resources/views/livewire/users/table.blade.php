<div class="flex flex-col h-full">
    <div>
        <div class="inline-block min-w-full align-middle">
            <div class="shadow-sm border border-gray-200 dark:border-gray-700 rounded-lg">
                <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                    <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr>
                        <th scope="col" class="w-[150px] p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                            {{__('Profile Picture')}}
                        </th>
                        <th scope="col" class="w-[200px] p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                            {{__('Full Name')}}
                        </th>
                        <th scope="col" class="w-[200px] p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                            {{__('Email')}}
                        </th>
                        <th scope="col" class="w-[150px] p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                            {{__('Username')}}
                        </th>
                        <th scope="col" class="w-[120px] p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                            {{__('Role')}}
                        </th>
                        <th scope="col" class="w-[100px] p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                            {{__('Status')}}
                        </th>
                        <th scope="col" class="w-[100px] p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-gray-400">
                            {{__('Actions')}}
                        </th>
                    </tr>
                    </thead>

                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">

                    @forelse($users as $user)
                        <tr wire:key="{{ $user->id }}" class="hover:bg-gray-300 dark:hover:bg-gray-800">
                            <td class="p-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <img class="w-10 h-10 rounded-full" src="{{ Storage::URL($user->profile_photo_path) }}" alt="{{ $user->full_name }}">
                                </div>
                            </td>
                            <td class="p-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-gray-900 dark:text-white">
                                    {{ $user->full_name . ($user->id === auth()->id() ? ' (You)' : '') }}
                                </div>
                            </td>
                            <td class="p-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-white">
                                    {{ $user->email }}
                                </div>
                            </td>
                            <td class="p-4 whitespace-nowrap">
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $user->username }}
                                </div>
                            </td>
                            <td class="p-4 whitespace-nowrap">
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $user->getRoleNames()[0] == 'bhw' ? 'BHW' : ucwords(str_replace('-', ' ', $user->getRoleNames()[0]))  }}
                                </div>
                            </td>
                            <td class="p-4 whitespace-nowrap">
                                @if ($user->last_login_at >= \Carbon\Carbon::now()->subMinutes(5))
                                    <div class="flex items-center">
                                        <div class="h-2.5 w-2.5 rounded-full bg-green-500 mr-2"></div>
                                        <span class="text-sm text-green-500 dark:text-green-400">{{__('Online')}}</span>
                                    </div>
                                @else
                                    <div class="flex items-center">
                                        <div class="h-2.5 w-2.5 rounded-full bg-red-500 mr-2"></div>
                                        <span class="text-sm text-red-500 dark:text-red-400">{{__('Offline')}}</span>
                                    </div>
                                @endif
                            </td>
                            <td class="p-4 whitespace-nowrap">
                                @if(! $user->trashed())
                                    @if($user->id === auth()->id())
                                        <div class="flex justify-center">
                                            <div class="dropdown dropdown-end center">
                                                <div tabindex="0" role="button" class="btn m-1 bg-inherit border-transparent active:bg-gray-900">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 16 16" id="ellipsis">
                                                        <path fill="currentColor" d="M10 2a2 2 0 1 1-3.999.001A2 2 0 0 1 10 2zM10 8a2 2 0 1 1-3.999.001A2 2 0 0 1 10 8zM10 14a2 2 0 1 1-3.999.001A2 2 0 0 1 10 14z"></path>
                                                    </svg>
                                                </div>
                                                <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box z-[1] w-52 p-2 shadow">
                                                    <li><a href="{{ route('profile.show') }}">Manage Account</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    @else
                                        <div class="flex justify-center space-x-2">
                                            <livewire:users.edit :user_id="$user->id" :key="'edit-user-'.$user->id" />
                                            <livewire:users.delete :user_id="$user->id" :key="'delete-user-'.$user->id" />
                                        </div>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                {{__('No users found.')}}
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-4 px-4">
            {{ $users->links() }}
        </div>
    </div>
</div>
