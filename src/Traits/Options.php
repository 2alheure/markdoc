<?php

namespace Dealheure\Markdoc\Traits;

use InvalidArgumentException;

trait Options {
    protected array $options = [];

    public function getOptions(): array {
        return $this->options;
    }

    public function setOptions(array $options): self {
        if ($this->checkOptions($options))
            $this->options = array_merge($options, $this->defaultOptions());
        else throw new InvalidArgumentException('Invalid options provided.');
        return $this;
    }

    public function setOption(string $key, $value): self {
        $this->options[$key] = $value;
        return $this;
    }

    protected function checkOptions(array $options = []): bool {
        return true;
    }

    protected function defaultOptions(): array {
        return [];
    }
}
