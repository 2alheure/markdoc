<?php

namespace Dealheure\Markdoc\Tests\Descriptors;

// use Dealheure\Markdoc\Tests\Traits\OptionsTest;
use Exception;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Dealheure\Markdoc\Descriptors\File;

class FileTest extends TestCase {
    // use OptionsTest;

    protected $file;
    // protected string $testableProperty = 'file';

    public function setUp(): void {
        $this->file = new File(__DIR__ . '/../files/about.md');
    }

    public function testNotExistingFileThrowsException() {
        $this->expectException(InvalidArgumentException::class);
        new File('not-existing-directory-file');
    }

    public function testNotCorrectExtensionThrowsException() {
        $this->expectException(InvalidArgumentException::class);
        new File(__DIR__ . '/../files/wrong-extension.txt');
    }

    public function testParsingDoProvideAllInformation() {
        $this->assertIsArray($this->file->getMeta());
        $this->assertArrayHasKey('test', $this->file->getMeta());
        $this->assertArrayHasKey('title', $this->file->getMeta());
        $this->assertArrayHasKey('description', $this->file->getMeta());
        $this->assertIsString($this->file->getHtml());
    }

    public function testGettersSetters() {
        $this->assertIsString($this->file->getFilename());
        $this->assertTrue($this->file->hasMeta('description'));
        $this->assertFalse($this->file->hasMeta('not-existing'));
        $this->assertIsString($this->file->getMeta('title'));
        $this->assertEquals($this->file->getMeta('test'), 'test');

        $this->assertInstanceOf(File::class, $this->file->setHtml('test'));
        $this->assertEquals($this->file->getHtml(), 'test');
    }

    public function testAlternativeMetaContent() {
        $index = new File(__DIR__ . '/../files/index.md');
        $doc_plus = new File(__DIR__ . '/../files/doc_plus.md');

        $this->assertIsString($doc_plus->getMeta());
        $this->assertEmpty($index->getMeta());
    }

    public function testToString() {
        try {
            (string) $this->file; // This should not throw any Exception
            $this->assertTrue(true); // Just not to mark it as "risky"
        } catch (Exception $e) {
            $this->assertTrue(false, 'Failed transtyping to string.');
        }
    }
}
