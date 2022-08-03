<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Blog\Components\Kiosk;

use ARKEcosystem\Foundation\Blog\Models\Article;
use ARKEcosystem\Foundation\UserInterface\Http\Livewire\Concerns\HasModal;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

final class DeleteArticle extends Component
{
    use HasModal;

    public ?Article $article;

    /** @var mixed */
    protected $listeners = ['triggerArticleDelete' => 'open'];

    public function render(): Renderable
    {
        return view('ark::components.blog.kiosk.delete-article');
    }

    public function open(int $id): void
    {
        abort_if(Auth::guest(), 404);

        $this->article = Article::findOrFail($id);

        $this->openModal();
    }

    public function close(): void
    {
        $this->resetErrorBag();

        $this->article = null;

        $this->closeModal();
    }

    public function deleteUser(): void
    {
        abort_if(Auth::guest(), 404);

        /** @var Article $article */
        $article = $this->article;

        $article->delete();

        $this->close();

        $this->redirect(route('kiosk.articles'));
    }
}
