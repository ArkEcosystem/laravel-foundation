<x-ark-container>
    <div class="flex items-center justify-end space-x-3">
        <div>
            <x-ark-input name="search" placeholder="Search..." input-class="-mt-2" hide-label />
        </div>

        <a href="{{ route('kiosk.users') }}" class="button-primary">
            Users
        </a>

        <a href="{{ route('kiosk.articles.create') }}" class="button-primary">
            New Article
        </a>
    </div>

    <div class="flex flex-col">
        <div class="overflow-x-auto">
            <div class="inline-block min-w-full py-2 align-middle">
                <div class="overflow-hidden sm:rounded-lg">
                    @if ($this->articles->isEmpty())
                        <x-ark-no-results />
                    @else
                        <table class="min-w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="text-gray-500 py-3 pr-6 text-left text-xs font-medium uppercase tracking-wider">
                                        Title
                                    </th>
                                    <th scope="col"
                                        class="text-gray-500 px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                        Date
                                    </th>
                                    <th scope="col" class="relative py-3 pl-6"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-theme-secondary-200 bg-white">
                                @foreach ($this->articles as $article)
                                    <tr>
                                        <td class="whitespace-nowrap py-4 pr-6">
                                            <div class="flex items-center">
                                                <div class="h-10 w-10 flex-shrink-0">
                                                    <img class="h-10 w-10 rounded-full"
                                                        src="{{ $article->author->photo() }}" alt="">
                                                </div>
                                                <div class="ml-4 flex items-center space-x-2">
                                                    <div class="text-gray-900 font-medium">
                                                        <a href="{{ $article->url() }}">{{ $article->title }}</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4">
                                            <div class="text-gray-900 text-sm">
                                                @if ($article->published_at)
                                                    {{ $article->published_at->toDayDateTimeString() }}
                                                @else
                                                    <span class="font-bold">DRAFT</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="whitespace-nowrap py-4 pl-6 text-right text-sm font-medium" x-data>
                                            <div class="flex items-center justify-end space-x-8">
                                                <a href="{{ route('kiosk.article', $article) }}"
                                                    class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                                <button type="button"
                                                    class="flex items-center space-x-1 text-sm font-medium text-theme-danger-600"
                                                    @click="$dispatch('triggerArticleDelete', {id: {{ $article->id }}})">
                                                    <x-ark-icon name="trash" size="sm" />

                                                    <span>Remove</span>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="mt-6 flex justify-center">
        {{ $this->articles->links('ark::pagination-url') }}
    </div>

    <livewire:kiosk-delete-article />
</x-ark-container>
