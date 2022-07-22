<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Blog\Components\Concerns;

trait HasFilter
{
    /**
     * @var array<string, boolean>
     */
    public array $searchCategories = [];

    /**
     * @var array<string, boolean>
     */
    public array $pendingCategories = [];

    public function applyFilter() : void
    {
        $this->searchCategories = $this->pendingCategories;

        $this->resetPage();
    }

    public function resetFilter() : void
    {
        $this->resetCategories();

        $this->resetPage();
    }

    private function resetCategories() : void
    {
        foreach ($this->categories as $key => $value) {
            $category = is_string($key) ? $key : $value;

            $this->searchCategories[$category]  = false;
            $this->pendingCategories[$category] = false;
        }
    }
}
