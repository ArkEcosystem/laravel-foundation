<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\UserInterface\Http\Livewire\Concerns;

use Livewire\WithPagination;

trait HasPagination
{
    use WithPagination;

    public function resolvePage()
    {
        if(request()->exists('page') && ! is_numeric(request()->query('page'))) {
            $this->page = 1;
            return $this->page;
        }
        // The "page" query string item should only be available
        // from within the original component mount run.
        return (int) request()->query('page', $this->page);
    }

    public function gotoPage(int $page): void
    {
        $this->emit('pageChanged');
        $this->setPage($page);
    }
}
