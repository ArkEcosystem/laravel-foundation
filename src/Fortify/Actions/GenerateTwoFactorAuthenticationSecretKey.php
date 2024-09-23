<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Fortify\Actions;

use Laravel\Fortify\Contracts\TwoFactorAuthenticationProvider;

class GenerateTwoFactorAuthenticationSecretKey
{
    /**
     * The two factor authentication provider.
     *
     * @var TwoFactorAuthenticationProvider
     */
    protected $provider;

    /**
     * Create a new action instance.
     *
     * @param TwoFactorAuthenticationProvider $provider
     *
     * @return void
     */
    public function __construct(TwoFactorAuthenticationProvider $provider)
    {
        $this->provider = $provider;
    }

    /**
     * Generate a Two-Factor Authentication Secret Key.
     *
     * @return string
     */
    public function __invoke(): string
    {
        return $this->provider->generateSecretKey();
    }
}
