<?php

namespace Dealheure\Markdoc\Descriptors;

use InvalidArgumentException;
use Dealheure\Markdoc\Traits\Options;

class Menu {
    use Options;

    protected array $items = [];
    protected bool $sorted = false;

    function __construct(array $options = []) {
        $this->setOptions($options);
    }

    public function checkOptions() {
        if (array_key_exists('type', $this->options) && !in_array($this->options['type'], ['ordered', 'unordered']))
            return false;

        return true;
    }

    public function defaultOptions() {
        return [
            'type' => 'unordered'
        ];
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

    public function sortItems() {
        if (!$this->sorted) {
            usort($this->items, function ($a, $b) {
                return $a->getOrder() <=> $b->getOrder();
            });

            $this->sorted = true;
        }
    }

    public function __toString() {
        switch ($this->getOptions('type')) {
            case 'ordered':
                $html_tag = 'ol';
                break;

            case 'unordered':
                $html_tag = 'ul';
                break;

            default:
                throw new InvalidArgumentException('Invalid type provided for menu. Should be `ordered` or `unordered`.');
        }

        return '<' . $html_tag . '>' . PHP_EOL
            . implode(PHP_EOL, $this->getItems()) . PHP_EOL
            . '</' . $html_tag . '>';
    }
}
