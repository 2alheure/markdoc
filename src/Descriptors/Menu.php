<?php

namespace Dealheure\Markdoc\Descriptors;

use Dealheure\Markdoc\Traits\Options;

class Menu {
    use Options;

    protected array $items = [];
    protected bool $sorted = false;

    function __construct(array $options = []) {
        $this->setOptions($options);
    }

    public function getItems(): array {
        $this->sortItems();

        return $this->items;
    }

    public function setItems(array $items): self {
        foreach ($items as $item)
            $this->addItem($item);

        $this->sorted = false;

        return $this;
    }

    public function addItem(MenuItem $item): self {
        $this->items[] = $item;
        $this->sorted = false;

        return $this;
    }

    public function getOptions(): array {
        return $this->options;
    }

    public function sortItems() {
        if (!$this->sorted) {
            usort($this->items, function ($a, $b) {
                return $a->getOrder() <=> $b->getOrder();
            });

            $this->sorted = true;
        }
    }
}
