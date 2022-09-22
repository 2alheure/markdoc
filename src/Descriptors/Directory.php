<?php

namespace Dealheure\Markdoc\Descriptors;

use InvalidArgumentException;
use Dealheure\Markdoc\Traits\Options;

class Directory {
    use Options;

    protected string $directory = '';
    protected array $files = [];
    protected Menu $menu;

    function __construct(string $directory, array $options = []) {
        $this->directory = $directory;
        $this->setOptions($options);
        $this->menu = new Menu($options);

        $this->parse();
    }

    public function defaultOptions() {
        return [
            'menu_order' => [
                'index'
            ]
        ];
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
        $file = new File($filename);
        $this->files[] = $file;

        $basename = substr(basename($file->getFilename()), 0, -3);
        $menuItem = new MenuItem($basename);

        $menuItem->setOrder(array_keys($this->getOptions('menu_order'), $basename)[0] ?? PHP_INT_MAX);

        if ($file->hasMeta('title')) $menuItem->setTitle($file->getMeta('title'));
        else $menuItem->setTitle(str_replace(['-', '_', '.'], ' ', ucFirst($basename)));

        if ($file->hasMeta('description')) $menuItem->setDescription($file->getMeta('description'));

        $this->menu->addItem($menuItem);

        return $this;
    }

    public function getMenu(): Menu {
        return $this->menu;
    }
}
