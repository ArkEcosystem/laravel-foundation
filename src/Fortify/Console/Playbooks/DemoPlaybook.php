<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Fortify\Console\Playbooks;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class DemoPlaybook extends Playbook
{
    public function before(): array
    {
        return [
            AccessControlPlaybook::once(),
            ManagementUserPlaybook::once(),
        ];
    }

    public function run(InputInterface $input, OutputInterface $output): void
    {
        $output->writeln('<info>[Playbook] Demo - success</info>');
    }
}
