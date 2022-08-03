<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Blog\Enums;

enum Category : string
{
    case News       = 'news';
    case Editorials = 'editorials';
    case Updates    = 'updates';
    case Tutorials  = 'tutorials';

    public function className() : string
    {
        return match ($this) {
            Category::News       => 'bg-theme-primary-600',
            Category::Editorials => 'bg-theme-success-600',
            Category::Updates    => 'bg-theme-hint-600',
            Category::Tutorials  => 'bg-theme-danger-400',
        };
    }

    public function label() : string
    {
        return match ($this) {
            Category::News       => 'News',
            Category::Editorials => 'Editorials',
            Category::Updates    => 'Updates',
            Category::Tutorials  => 'Tutorials',
        };
    }
}
