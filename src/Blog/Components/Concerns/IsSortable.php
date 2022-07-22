<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Blog\Components\Concerns;

trait IsSortable
{
    public string $sortDirection = 'asc';

    public function sort() : void
    {
        if ($this->sortDirection === 'asc') {
            $this->sortDirection = 'desc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->resetPage();
    }
}
