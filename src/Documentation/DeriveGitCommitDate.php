<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Documentation;

use Carbon\Carbon;
use Symfony\Component\Process\Process;

class DeriveGitCommitDate
{
    public static function execute(string $path): Carbon
    {
        $process = Process::fromShellCommandline('cd '.storage_path('app/public/docs').' && git log -1 --format="%ad" -- '.$path);
        $process->run();

        return Carbon::parse(str_replace("\n", '', $process->getOutput()));
    }
}
