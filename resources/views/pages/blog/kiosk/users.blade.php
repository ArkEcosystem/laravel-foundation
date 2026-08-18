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
                <div class="inline-block min-w-full py-2 align-middle">
                    <div class="overflow-hidden sm:rounded-lg">
                        <table class="min-w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="text-gray-500 py-3 pr-6 text-left text-xs font-medium uppercase tracking-wider">
                                        Name
                                    </th>
                                    <th scope="col"
                                        class="text-gray-500 px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                        Date Created
                                    </th>
                                    <th scope="col" class="relative py-3 pl-6"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-theme-secondary-200 bg-white">
                                @foreach ($users as $user)
                                    <tr>
                                        <td class="whitespace-nowrap py-4 pr-6">
                                            <div class="flex items-center">
                                                <div class="h-10 w-10 flex-shrink-0">
                                                    <img class="h-10 w-10 rounded-full" src="{{ $user->photo() }}"
                                                        alt="">
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-gray-900 font-medium">
                                                        {{ $user->name }}
                                                    </div>

                                                    <div class="text-gray-600 mt-1 text-sm">
                                                        {{ $user->email }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4">
                                            <div class="text-gray-900 text-sm">
                                                {{ $user->created_at->toDayDateTimeString() }}
                                            </div>
                                        </td>
                                        <td class="whitespace-nowrap py-4 pl-6 text-right text-sm font-medium" x-data>
                                            <div class="flex items-center justify-end space-x-8">
                                                <a href="{{ route('kiosk.user', $user) }}"
                                                    class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                                <button type="button"
                                                    class="flex items-center space-x-1 text-sm font-medium text-theme-danger-600"
                                                    @click="$dispatch('triggerUserDelete', {id: {{ $user->id }}})">
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

        <div class="mt-6 flex justify-center">
            {{ $users->links('ark::pagination-url') }}
        </div>

        <livewire:kiosk-delete-user />
    </x-ark-container>
@endsection
