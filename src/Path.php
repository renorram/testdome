<?php

namespace App;

class Path
{
    public $currentPath;

    public function __construct(string $path)
    {
        $this->currentPath = $path;
    }

    public function cd(string $newPath): void
    {
        if (!$this->validatePath($newPath)) {
            throw new \InvalidArgumentException(\sprintf('%s path invalid!', $newPath));
        }

        if ($newPath[0] == '/') {
            $path = explode("/", $newPath);
            foreach ($path as $k => $item) {
                if ($item == "..") {
                    unset($path[$k], $path[$k - 1]);
                }
            }

            $path = array_filter($path);
            $this->currentPath = "/" . \join("/", $path);
            return;
        }

        $currentPath = explode("/", $this->currentPath);
        $path = explode("/", $newPath);

        foreach ($path as $k => $item) {
            if ($item === '..') {
                array_pop($currentPath);
            } else {
                $currentPath[] = $item;
            }
        }
        $this->currentPath = \join("/", $currentPath);
    }

    public function validatePath(string $path): bool
    {
        return \preg_match_all("/[^\/A-Za-z\.]/", $path) === 0;
    }
}
