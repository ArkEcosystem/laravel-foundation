<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\CommonMark\View;

use Illuminate\View\FileViewFinder as Finder;
use InvalidArgumentException;
use Spatie\Regex\Regex;

final class FileViewFinder extends Finder
{
    /**
     * Find the given view in the list of paths.
     *
     * @param  string  $name
     * @param  array  $paths
     * @throws \InvalidArgumentException
     * @return string
     */
    protected function findInPaths($name, $paths)
    {
        $regex = Regex::match('/\d.\d/', $name);

        foreach ((array) $paths as $path) {
            if ($regex->hasMatch()) {
                $possibleViewFiles = $this->getPossibleViewFilesConsideringNumbersWithDecimals($name, $path);
            } else {
                $possibleViewFiles = $this->getPossibleViewFiles($name);
            }

            foreach ($possibleViewFiles as $file) {
                if ($this->files->exists($viewPath = $path.'/'.$file)) {
                    return $viewPath;
                }
            }
        }

        throw new InvalidArgumentException("View [{$name}] not found.");
    }

    protected function getPossibleViewFilesConsideringNumbersWithDecimals(string $name, string $path): array
    {
        $regex = Regex::match('/\d.\d/', $name);

        return array_map(function ($extension) use ($path, $name, $regex) : string {
            $number            = $regex->result();
            $nameWithoutNumber = rtrim(explode($number, $name)[0], '.');

            $file =  str_replace('.', '/', $nameWithoutNumber).'/'.$number.'.'.$extension;

            // Only return the file if it exists, that prevents applying this
            // custom path to numbers returned from custom render functions
            // like `src/UserInterface/Components/Number.php`
            if ($this->files->exists($path.'/'.$file)) {
                return $file;
            }

            // If file doesnt exists, return the original path
            return str_replace('.', '/', $name).'.'.$extension;
        }, $this->extensions);
    }
}
