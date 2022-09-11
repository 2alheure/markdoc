<?php

namespace Dealheure\Markdoc\Descriptors;

use Dealheure\Markdoc\Traits\Options;

class Menu {
    use Options;

    protected array $items = [];

    function __construct(array $options = []) {
        $this->setOptions($options);
    }

    public function getItems(): array {
        return $this->items;
    }

    public function setItems(array $items): self {
        foreach ($items as $item)
            $this->addItem($item);

        return $this;
    }

    public function addItem(MenuItem $item): self {
        $this->items[] = $item;
        return $this;
    }

    public function getOptions(): array {
        return $this->options;
    }
}
