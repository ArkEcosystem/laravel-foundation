<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Blog\Components\Kiosk;

use ARKEcosystem\Foundation\Blog\Enums\Category;
use ARKEcosystem\Foundation\Blog\Models\Article;
use ARKEcosystem\Foundation\Blog\Models\User;
use ARKEcosystem\Foundation\UserInterface\Components\Concerns\HandleToast;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use JamesMills\LaravelTimezone\Facades\Timezone;
use Livewire\Component;
use Livewire\WithFileUploads;

final class UpdateArticle extends Component
{
    use HandleToast;
    use WithFileUploads;

    public Article $article;

    public array $state = [
        'user_id'      => '',
        'title'        => '',
        'body'         => '',
        'category'     => '',
        'banner'       => '',
        'published_at' => '',
    ];

    public Collection $users;

    public function render(): Renderable
    {
        return view('ark::components.blog.kiosk.update-article');
    }

    public function mount(Article $article) : void
    {
        $this->article = $article;

        $this->state = $article->withoutRelations()->toArray() + [
            'banner' => '',
        ];

        $this->users = User::orderBy('name')->withTrashed()->get();

        if ($article->published_at !== null) {
            // @phpstan-ignore-next-line
            $this->state['published_at'] = Timezone::convertToLocal($article->published_at, 'Y-m-d\TH:i');
        }
    }

    public function save() : void
    {
        $this->validate([
            'state.user_id'      => ['required', Rule::exists('users', 'id')],
            'state.title'        => ['required', 'string', 'max:255', Rule::unique('articles', 'title')->ignore($this->article)],
            'state.body'         => ['required', 'string'],
            'state.category'     => ['required', 'string', new Enum(Category::class)],
            'state.banner'       => ['nullable', 'image'],
            'state.published_at' => ['nullable', 'date'],
        ]);

        if ($this->state['published_at'] !== '' && $this->state['published_at'] !== null) {
            $this->state['published_at'] = Timezone::convertFromLocal($this->state['published_at']);
        } else {
            $this->state['published_at'] = null;
        }

        $this->state['slug'] = Str::slug($this->state['title']);

        $this->article->update(Arr::except($this->state, ['banner']));

        if ($this->state['banner'] !== null && $this->state['banner'] !== '') {
            $uploadedFile = $this->state['banner'];
            $uploadedFile = new UploadedFile($uploadedFile->path(), $uploadedFile->getClientOriginalName());
            $this->article->addMedia($uploadedFile)->toMediaCollection('banner');
        }

        $this->toast('The article has been updated.');

        $this->redirectRoute('kiosk.articles');
    }
}
