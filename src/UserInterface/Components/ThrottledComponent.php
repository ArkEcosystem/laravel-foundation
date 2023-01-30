<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\UserInterface\Components;

use ARKEcosystem\Foundation\UserInterface\Components\Concerns\HandleToast;
use Carbon\Carbon;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;

abstract class ThrottledComponent extends Component
{
    use WithRateLimiting;
    use HandleToast;

    protected string $throttledType = 'warning';

    abstract protected function getThrottlingMaxAttempts(): int;

    abstract protected function getThrottlingTime(): int;

    abstract protected function getThrottlingKey(): string;

    abstract protected function getThrottlingMessage(string $availableIn): string;

    final protected function getThrottlingAvailableIn(): string
    {
        $throttlingKey = $this->getThrottlingKey();

        $secondsUntilAvailable = RateLimiter::availableIn($this->getRateLimitKey($throttlingKey));

        $diff = Carbon::createFromTimeStamp($secondsUntilAvailable)->diff(Carbon::createFromTimeStamp(0));

        $hours   = $diff->h + ($diff->d * 24);
        $minutes = $diff->i;
        $seconds = $diff->s;

        if ($hours > 0) {
            if ($minutes > 0) {
                return sprintf(
                    '%s, %s',
                    trans_choice('ui::general.amount_hours', $hours, ['amount' => $hours]),
                    trans_choice('ui::general.amount_minutes', $minutes, ['amount' => $minutes]),
                );
            }

            return trans_choice('ui::general.amount_hours', $hours, ['amount' => $hours]);
        }

        if ($minutes > 0) {
            return trans_choice('ui::general.amount_minutes', $minutes, ['amount' => $minutes]);
        }

        return trans_choice('ui::general.amount_seconds', $secondsUntilAvailable, ['amount' => $secondsUntilAvailable]);
    }

    protected function isThrottled(): bool
    {
        try {
            $this->rateLimit(
                $this->getThrottlingMaxAttempts(),
                $this->getThrottlingTime(),
                $this->getThrottlingKey()
            );
        } catch (TooManyRequestsException) {
            $this->toast($this->getThrottlingMessage($this->getThrottlingAvailableIn()), $this->throttledType);

            return true;
        }

        return false;
    }
}
