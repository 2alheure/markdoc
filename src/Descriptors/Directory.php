<?php

namespace Dealheure\Markdoc\Descriptors;

use InvalidArgumentException;
use Dealheure\Markdoc\Traits\Options;

class Directory {
    use Options;

    protected string $directory = '';
    protected array $files = [];
    protected array $menu = [];

    function __construct(string $directory, array $options = []) {
        $this->directory = $directory;
        $this->setOptions($options);

        $this->parse();
    }

    public function parse(): self {
        if (!is_dir($this->directory) || !is_readable($this->directory))
            throw new InvalidArgumentException($this->directory . ' is not a valid directory path.');

        $scanned = scandir($this->directory);
        foreach ($scanned as $file) {
            if (
                is_file($this->directory . '/' . $file)
                && is_readable($this->directory . '/' . $file)
                && substr($file, -3) === '.md'
            )
                $this->addFile($this->directory . '/' . $file);
        }


        // @TODO : Create menu

        return $this;
    }

    public function getDirectory(): string {
        return $this->directory;
    }

    public function getFiles(): array {
        return $this->files;
    }

    public function setFiles(array $files): self {
        foreach ($files as $file)
            $this->addFile($file);

        return $this;
    }

    public function addFile(string $filename): self {
        $this->files[] = new File($filename);
        return $this;
    }

    public function getMenu(): array {
        return $this->menu;
    }
}
