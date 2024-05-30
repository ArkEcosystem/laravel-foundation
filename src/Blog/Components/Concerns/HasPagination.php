<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Blog\Components\Concerns;

use Livewire\WithPagination;

trait HasPagination
{
    use WithPagination;

    public int $page = 1;

    public function __get($property): mixed
    {
        if ($property === 'page') {
            return $this->getPage();
        }

        if (property_exists($this, $property)) {
            return $this->{$property};
        }

        throw new \Exception('Property ['.$property.'] does not exist.');
    }

    public function __set($property, $value): void
    {
        if ($property === 'page') {
            $this->setPage($value);
        }

        if (property_exists($this, $property)) {
            $this->{$property} = $value;
        }

        throw new \Exception('Property ['.$property.'] does not exist.');
    }

    /**
     * Livewire's WithPagination trait checks whether there's an `updatedPaginators` method
     * and it will fire after page has changed if the method exists.
     *
     * @return void
     */
    public function updatedPaginators() : void
    {
        $this->dispatch('pageChanged');
    }
}
