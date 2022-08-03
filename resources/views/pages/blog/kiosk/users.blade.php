@extends('layouts.app')

@section('content')
    <x-ark-container>
        <div class="flex justify-end space-x-3">
            <a href="{{ route('kiosk.articles') }}" class="button-primary">
                Articles
            </a>

            <a href="{{ route('kiosk.users.create') }}" class="button-primary">
                New User
            </a>
        </div>

        <div class="flex flex-col">
            <div class="overflow-x-auto">
                <div class="inline-block py-2 min-w-full align-middle">
                    <div class="overflow-hidden sm:rounded-lg">
                        <table class="min-w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="py-3 pr-6 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Name
                                    </th>
                                    <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Date Created
                                    </th>
                                    <th scope="col" class="relative py-3 pl-6"></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-theme-secondary-200">
                                @foreach($users as $user)
                                    <tr>
                                        <td class="py-4 pr-6 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 w-10 h-10">
                                                    <img class="w-10 h-10 rounded-full" src="{{ $user->photo() }}" alt="">
                                                </div>
                                                <div class="ml-4">
                                                    <div class="font-medium text-gray-900">
                                                        {{ $user->name }}
                                                    </div>

                                                    <div class="mt-1 text-sm text-gray-600">
                                                        {{ $user->email }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4 px-6 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ $user->created_at->toDayDateTimeString() }}
                                            </div>
                                        </td>
                                        <td class="py-4 pl-6 text-sm font-medium text-right whitespace-nowrap" x-data>
                                            <div class="flex justify-end items-center space-x-8">
                                                <a href="{{ route('kiosk.user', $user) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                                <button
                                                    type="button"
                                                    class="flex items-center space-x-1 text-sm font-medium text-theme-danger-600"
                                                    @click="window.livewire.emit('triggerUserDelete', {{ $user->id }})"
                                                >
                                                    <x-ark-icon name="trash" size="sm" />

                                                    <span>Remove</span>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-center mt-6">
            {{ $users->links("ark::pagination-url") }}
        </div>

        <livewire:kiosk-delete-user />
    </x-ark-container>
@endsection
