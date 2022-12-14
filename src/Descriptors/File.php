<?php

namespace Dealheure\Markdoc\Descriptors;

use InvalidArgumentException;
use Dealheure\Markdoc\Traits\Options;
use League\CommonMark\MarkdownConverter;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Output\RenderedContentInterface;
use League\CommonMark\Extension\FrontMatter\FrontMatterExtension;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\TableOfContents\TableOfContentsExtension;
use League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkExtension;
use League\CommonMark\Extension\FrontMatter\Output\RenderedContentWithFrontMatter;

class File {
    use Options;

    protected string $filename = '';
    protected array|string $meta = [];
    protected string $html = '';
    protected RenderedContentInterface $renderedContent;

    public function __construct(string $filename, array $options = []) {
        $this->filename = $filename;
        $this->setOptions($options);
        $this->parse();
    }

    protected function checkOptions() {
        if (array_key_exists('environment', $this->options) && !$this->options['environment'] instanceof Environment)
            throw new InvalidArgumentException('`environment` option must be of type ' . Environment::class);

        return true;
    }

    public function parse() {
        if (
            !is_file($this->filename)
            || !is_readable($this->filename)
        )
            throw new InvalidArgumentException($this->filename . ' is not a valid directory path.');

        if (substr($this->filename, -3) !== '.md')
            throw new InvalidArgumentException($this->filename . ' is not a markdown file.');

        $environment = $this->getOptions('environment') ??
            (new Environment([
                'table_of_contents' => [
                    'position' => 'before-headings',
                    'min_heading_level' => 2,
                ],
            ]))
            ->addExtension(new CommonMarkCoreExtension)
            ->addExtension(new FrontMatterExtension)
            ->addExtension(new HeadingPermalinkExtension)
            ->addExtension(new TableOfContentsExtension);

        $this->renderedContent = (new MarkdownConverter($environment))
            ->convert(file_get_contents($this->filename));

        if ($this->renderedContent instanceof RenderedContentWithFrontMatter) {
            $this->meta = $this->renderedContent->getFrontMatter();
        }

        $this->html = $this->renderedContent->getContent();
    }

    public function getFilename(): string {
        return $this->filename;
    }

    public function hasMeta(string $key): bool {
        return isset($this->meta[$key]);
    }

    public function getMeta(string $key = ''): string|array {
        return $key ? $this->meta[$key] : $this->meta;
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
    
    public function __toString() {
        return $this->html;
    }
}
