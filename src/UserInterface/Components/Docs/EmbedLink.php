<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\UserInterface\Components\Docs;

use Alaouy\Youtube\Facades\Youtube;
use Embed\Embed;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Livewire\Component;

class EmbedLink extends Component
{
    public string $url;

    public string $caption;

    public function render(): View
    {
        if (str_starts_with($this->url, 'https://www.youtube.com/channel/')) {
            $data = Cache::rememberForever(md5($this->url), function (): array {
                $info = Youtube::getChannelById(str_replace('https://www.youtube.com/channel/', '', $this->url));

                return [
                    'title'       => $info->snippet->title,
                    'description' => Str::limit($info->snippet->description, 128),
                    'image'       => $info->snippet->thumbnails->high->url,
                    'host'        => data_get(parse_url($this->url), 'host'),
                    'hostUrl'     => $this->url,
                ];
            });
        } else {
            $data = Cache::rememberForever(md5($this->url), function (): array {
                $info = (new Embed())->get($this->url);

                return [
                    'title'       => $info->title,
                    'description' => $info->description,
                    'image'       => (string) $info->image,
                    'host'        => $info->providerUrl->getHost(),
                    'hostUrl'     => (string) $info->providerUrl,
                ];
            });
        }

        return view('ark::livewire.docs.embed-link', $data);
    }
}
