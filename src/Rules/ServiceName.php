<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Rules;

use Illuminate\Contracts\Validation\Rule;

final class ServiceName implements Rule
{
    public function __construct(private string $service)
    {
        //
    }

    public function passes($attribute, $value): bool
    {
        return boolval(preg_match(RegEx::socialMediaName($this->service), $value));
    }

    public function message()
    {
        return trans("ui::validation.social.{$this->service}_name");
    }
}
