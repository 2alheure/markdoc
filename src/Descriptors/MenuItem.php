<?php

namespace Dealheure\Markdoc\Descriptors;

use Dealheure\Markdoc\Traits\Options;

class MenuItem {
    use Options;

    protected string $filename;
    protected string $title;
    protected string $description;

    function __construct(string $filename, string $title, string $description, array $options = []) {
        $this->filename = $filename;
        $this->title = $title;
        $this->description = $description;

        $this->setOptions($options);
    }
}
