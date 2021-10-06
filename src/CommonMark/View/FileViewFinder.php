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
     * @return string
     *
     * @throws \InvalidArgumentException
     */
    protected function findInPaths($name, $paths)
    {
        // Match number with optional decimals
        $regex = Regex::match('/\d.\d/', $name);
        $isNumericName = $regex->hasMatch();

        foreach ((array) $paths as $path) {
            if ($isNumericName) {
                $possibleViewFiles = $this->getPossibleViewFilesForNumericName($name, $path);
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

    protected function getPossibleViewFilesForNumericName(string $name, string $path): array
    {
        $regex = Regex::match('/\d.\d/', $name);

        return array_map(function ($extension) use ($path, $name, $regex) : string {
            $name = rtrim(explode($regex->result(), $name)[0], '.');

            $file =  str_replace('.', '/', $name).'/'.$regex->result().'.'.$extension;

            // Only return the file if it exists, that prevents applying this
            // custom logic to numbers returned from custom render functions
            // like `src/UserInterface/Components/Number.php`
            if ($this->files->exists($path.'/'.$file)) {
                return $file;
            }

            return str_replace('.', '/', $name).'.'.$extension;
        }, $this->extensions);
    }
}
