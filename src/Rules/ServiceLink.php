<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Str;
use InvalidArgumentException;

final class ServiceLink implements Rule
{
    public function __construct(private string $service)
    {
        //
    }

    public function passes($attribute, $value): bool
    {
        if ($this->service === 'hive') {
            $regexes =  [
                RegEx::socialMediaLink('hive'),
                RegEx::socialMediaLink('ecency'),
                RegEx::socialMediaLink('peakd'),
            ];

            return collect($regexes)->some(fn ($regex) => boolval(preg_match($regex, $value)));
        }

        if ($this->service === 'website') {
            $expression = RegEx::get($this->service);
        } elseif (array_key_exists($this->service, config('rules.regex.social_media_link'))) {
            $expression = RegEx::socialMediaLink($this->service);
        } elseif (array_key_exists($this->service, config('rules.regex.source_providers'))) {
            $expression = RegEx::sourceProviderLink($this->service);
        } else {
            throw new InvalidArgumentException("Service [{$this->service}] has no regular expression.");
        }

        return boolval(preg_match($expression, $value));
    }

    public function message()
    {
        return trans('ui::validation.social.'.Str::snake($this->service).'_url');
    }
}
