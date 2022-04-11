<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Documentation;

use ARKEcosystem\Foundation\Documentation\Concerns\CanBeShared;
use Illuminate\Database\Eloquent\Model;
use Sushi\Sushi;

class Documentation extends Model
{
    use CanBeShared;
    use Sushi;

    public function url(): string
    {
        return route('documentation', $this->slug);
    }
}
