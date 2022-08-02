<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Blog\Components;

use ARKEcosystem\Foundation\Blog\Components\Concerns\HasFilter;
use ARKEcosystem\Foundation\Blog\Components\Concerns\HasPagination;
use ARKEcosystem\Foundation\Blog\Components\Concerns\IsSortable;
use ARKEcosystem\Foundation\Blog\Enums\Category;
use ARKEcosystem\Foundation\Blog\Models\Article;
use ARKEcosystem\Foundation\Blog\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;

final class ArticleList extends Component
{
    use HasFilter;
    use HasPagination;
    use IsSortable;

    public const PER_PAGE = 10;

    public ?User $author = null;

    public string $term = '';

    public string $categoryQueryString = '';

    public ?array $headerGradient = null;

    /**
     * @var string[]
     */
    public array $categories;

    /**
     * @var mixed
     */
    protected $queryString = [
        'term'                => ['except' => '', 'as' => 'q'],
        'sortDirection'       => ['except' => 'desc', 'as' => 'order'],
        'categoryQueryString' => ['except' => '', 'as' => 'category'],
        'page'                => ['except' => 1],
    ];

    public function render() : Renderable
    {
        $featuredArticle = $this->featuredArticle();

        return view('ark::components.blog.article-list', [
            'articles'        => $this->articles($featuredArticle),
            'featuredArticle' => $this->page <= 1 ? $featuredArticle : null,
        ]);
    }

    public function mount(Request $request, ?array $headerGradient = null) : void
    {
        $this->categories    = collect(Category::cases())->map->value->toArray();
        $this->sortDirection = $request->query('order') === 'asc' ? 'asc' : 'desc';

        $this->resetCategories();

        /** @var string */
        $search = $request->query('q', '');

        if ($search !== '') {
            $this->term = $search;
        }

        /** @var string */
        $categories = $request->query('category', '');

        if ($categories !== '') {
            $this->selectCategories(explode(',', $categories));
        }
    }

    public function getAuthorArticleCountProperty(): ?int
    {
        return $this->author?->articles()->count();
    }

    public function updatingTerm() : void
    {
        $this->resetPage();
    }

    private function featuredArticle() : ?Article
    {
        return Article::featured();
    }

    private function articles(?Article $featured) : LengthAwarePaginator
    {
        $query = Article::published();

        if ($this->author) {
            $query->where('user_id', $this->author->id);
        } elseif ($featured !== null) {
            $query->where('id', '!=', $featured->id);
        }

        return $query
                ->when(strlen($this->term) <= 30, fn ($q) => $q->search($this->term))
                ->when(count($this->categories()) > 0, fn ($q) => $q->whereIn('category', $this->categories()))
                ->orderBy('published_at', $this->sortDirection)
                ->paginate(static::PER_PAGE);
    }

    /*
     * @return string[]
     */
    private function categories() : array
    {
        return tap(array_keys(array_filter($this->searchCategories)), function (array $categories) {
            $this->categoryQueryString = implode(',', $categories);
        });
    }

    /*
     * @param string[] $categories
     */
    private function selectCategories(array $categories) : void
    {
        collect($categories)->intersect($this->categories)->each(function (string $category) {
            $this->searchCategories[$category]  = true;
            $this->pendingCategories[$category] = true;
        });
    }
}
