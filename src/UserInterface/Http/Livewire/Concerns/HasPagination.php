<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\UserInterface\Http\Livewire\Concerns;

use Livewire\WithPagination;

trait HasPagination
{
    use WithPagination;

    public function resolvePage()
    {
        if (request()->exists('page') && ! is_numeric(request()->query('page'))) {
            $this->setPage(1);

            return 1;
        }

        // The "page" query string item should only be available
        // from within the original component mount run.
        return (int) request()->query('page', $this->getPage());
    }

    public function gotoPage(int $page, bool $emitEvent = true): void
    {
        if ($emitEvent) {
            $this->dispatch('pageChanged');
        }

        $this->setPage($page);
    }
}
