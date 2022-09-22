<?php

namespace Dealheure\Markdoc\Descriptors;

use Dealheure\Markdoc\Traits\Options;

class MenuItem {
    use Options;

    protected string $filename;
    protected string $title;
    protected string $description;
    protected int $order = PHP_INT_MAX;

    function __construct(string $filename = '', string $title = '', string $description = '', array $options = []) {
        $this->filename = $filename;
        $this->title = $title;
        $this->description = $description;

        $this->setOptions($options);
    }

    public function getOrder(): int {
        return $this->order;
    }

    public function setOrder(int $order): self {
        $this->order = $order;
        return $this;
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function setTitle(string $title): self {
        $this->title = $title;
        return $this;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function setDescription(string $description): self {
        $this->description = $description;
        return $this;
    }

    public function getFilename(): string {
        return $this->filename;
    }

    public function setFilename(string $filename): self {
        $this->filename = $filename;
        return $this;
    }

    public function __toString() {
        return '<li><a href="' . $this->filename . '" title="' . $this->description . '">' . $this->title . '</a></li>';
    }
}
