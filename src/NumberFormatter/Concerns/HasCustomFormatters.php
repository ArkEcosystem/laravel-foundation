<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\NumberFormatter\Concerns;

use ARKEcosystem\Foundation\NumberFormatter\ResolveScientificNotation;
use Illuminate\Support\Str;

trait HasCustomFormatters
{
    public function formatWithCurrencyShort(int | float | string $value, string $currency): string
    {
        $i     = 0;
        $units = ['', 'K', 'M', 'B', 'T'];

        for ($i = 0; $value >= 1000; $i++) {
            $value /= 1000;
        }

        return round((float) $value, 1).$units[$i].' '.strtoupper($currency);
    }

    public function formatWithCurrencyCustom(int | float | string $value, string $currency, ?int $decimals = null): string
    {
        $result = $this->formatWithDecimal((float) $value);

        if (Str::contains((string) $value, '.')) {
            $result = number_format((float) ResolveScientificNotation::execute((float) $value), $decimals ?? 8);

            if (Str::contains((string) $result, '.')) {
                $result = rtrim(rtrim((string)$result, '0'), '.');
            }
        } else if (Str::contains((string) $value, ',')) {
            $result = $value;
        }

        // Gets rid of trailing .00 if amount of decimals is 0
        if ($decimals === 0 && Str::contains((string) $result, '.')) {
            $result = rtrim(rtrim($result, '0'), '.');
        }

        return rtrim($result.' '.strtoupper($currency));
    }
}
