@props([
    'networks' => [
        [
            'icon' => 'brands.solid.twitter',
            'url' => trans('ui::urls.twitter')
        ],
        [
            'icon' => 'brands.solid.linkedin',
            'url' => trans('ui::urls.linkedin')
        ],
        [
            'icon' => 'brands.solid.facebook',
            'url' => trans('ui::urls.facebook')
        ],
        [
            'icon' => 'brands.solid.youtube',
            'url' => trans('ui::urls.youtube')
        ],
        [
            'icon' => 'brands.solid.github',
            'url' => trans('ui::urls.github')
        ],
        [
            'icon' => 'brands.solid.telegram',
            'url' => trans('ui::urls.telegram')
        ],
    ],
])

<div class="flex space-x-5">
    @foreach($networks as $network)
        <x-ark-social-link :url="$network['url']" :icon="$network['icon']" data-safe-external />
    @endforeach
</div>
