<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Fortify\Console\Playbooks;

use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class ManagementUserPlaybook extends Playbook
{
    public function run(InputInterface $input, OutputInterface $output): void
    {
        $users = json_decode((string) file_get_contents(database_path('seeders/app/permissions.json')), true)['users'];

        foreach ($users as $domain => $user) {
            foreach ($user as $name => $roles) {
                $rolesSignature = collect($roles)
                    ->map(fn ($role) => '--role='.$role)
                    ->join(' ');

                Artisan::call(sprintf(
                    'user:create %s %s --silent --domain=%s',
                    $name,
                    $rolesSignature,
                    $domain
                ));
            }
        }
    }
}
