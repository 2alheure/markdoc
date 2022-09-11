<?php

namespace Dealheure\Markdoc\Descriptors;

use hkod\frontmatter\Parser;
use InvalidArgumentException;
use hkod\frontmatter\YamlParser;
use hkod\frontmatter\MarkdownParser;

class File {
    protected string $filename = '';
    protected array|string $meta = [];
    protected string $html = '';

    public function __construct(string $filename) {
        $this->filename = $filename;
        $this->parse();
    }

    public function parse() {
        if (
            !is_file($this->filename)
            || !is_readable($this->filename)
        )
            throw new InvalidArgumentException($this->filename . ' is not a valid directory path.');

        if (substr($this->filename, -3) !== '.md')
            throw new InvalidArgumentException($this->filename . ' is not a markdown file.');

        $parser = new Parser(
            new YamlParser,
            new MarkdownParser
        );

        $parsed = $parser->parse(file_get_contents($this->filename));

        $this->meta = $parsed->getFrontmatter();
        $this->html = $parsed->getBody();
    }

    public function getFilename(): string {
        return $this->filename;
    }

    public function getMeta(): string|array {
        return $this->meta;
    }

    public function setMeta(string|array $meta): self {
        $this->meta = $meta;

        return $this;
    }

    public function getHtml(): string {
        return $this->html;
    }

    public function setHtml(string $html): self {
        $this->html = $html;

        return $this;
    }
}
