<?php

namespace Dealheure\Markdoc\Tests\Descriptors;

use InvalidArgumentException;
// use Dealheure\Markdoc\Tests\Traits\OptionsTest;
use PHPUnit\Framework\TestCase;
use Dealheure\Markdoc\Descriptors\File;
use Dealheure\Markdoc\Descriptors\Menu;
use Dealheure\Markdoc\Descriptors\Directory;

class DirectoryTest extends TestCase {
    // use OptionsTest;

    protected $directory;
    // protected string $testableProperty = 'directory';

    protected function setUp(): void {
        $this->directory = new Directory(__DIR__ . '/../files');
    }

    public function testNotExistingDirectoryThrowsException() {
        $this->expectException(InvalidArgumentException::class);
        new Directory('not-existing-directory');
    }

    public function testExistingDirectoryDoProvideAllFiles() {

        $this->assertCount(3, $this->directory->getFiles());

        $this->assertArrayHasKey('about', $this->directory->getFiles());
        $this->assertArrayHasKey('index', $this->directory->getFiles());
        $this->assertArrayHasKey('doc_plus', $this->directory->getFiles());

        $this->assertContainsOnlyInstancesOf(File::class, $this->directory->getFiles());
    }

    public function testGettersSetters() {
        $this->assertIsString($this->directory->getDirectory());
        $this->assertIsArray($this->directory->getFiles());
        $this->assertContainsOnlyInstancesOf(File::class, $this->directory->getFiles());
        $this->isInstanceOf(File::class, $this->directory->getFile('about'));
        $this->isInstanceOf(Menu::class, $this->directory->getMenu());
    }
}
