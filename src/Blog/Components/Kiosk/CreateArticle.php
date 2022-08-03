<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Blog\Components\Kiosk;

use ARKEcosystem\Foundation\Blog\Enums\Category;
use ARKEcosystem\Foundation\Blog\Models\Article;
use ARKEcosystem\Foundation\UserInterface\Components\Concerns\HandleToast;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use JamesMills\LaravelTimezone\Facades\Timezone;
use Livewire\Component;
use Livewire\WithFileUploads;

final class CreateArticle extends Component
{
    use HandleToast;
    use WithFileUploads;

    public array $state = [
        'user_id'      => '',
        'title'        => '',
        'body'         => '',
        'category'     => '',
        'banner'       => '',
        'published_at' => '',
    ];

    public function render(): Renderable
    {
        return view('ark::components.blog.kiosk.create-article');
    }

    public function save() : void
    {
        $this->validate([
            'state.user_id'      => ['required', Rule::exists('users', 'id')],
            'state.title'        => ['required', 'string', 'max:255', Rule::unique('articles', 'title')],
            'state.body'         => ['required', 'string'],
            'state.category'     => ['required', 'string', new Enum(Category::class)],
            'state.banner'       => ['required', 'image'],
            'state.published_at' => ['nullable', 'date'],
        ]);

        if ($this->state['published_at'] !== '' && $this->state['published_at'] !== null) {
            $this->state['published_at'] = Timezone::convertFromLocal($this->state['published_at']);
        } else {
            $this->state['published_at'] = null;
        }

        $this->state['slug'] = Str::slug($this->state['title']);

        $article = Article::create(Arr::except($this->state, ['banner']));

        $uploadedFile = $this->state['banner'];
        $uploadedFile = new UploadedFile($uploadedFile->path(), $uploadedFile->getClientOriginalName());
        $article->addMedia($uploadedFile)->toMediaCollection('banner');

        $this->redirectRoute('kiosk.article', $article);
    }
}
