<?php

namespace Dealheure\Markdoc\Tests\Descriptors;

use Exception;
use PHPUnit\Framework\TestCase;
use Dealheure\Markdoc\Descriptors\MenuItem;
// use Dealheure\Markdoc\Tests\Traits\OptionsTest;

class MenuItemTest extends TestCase {
    // use OptionsTest;

    protected $menu;
    // protected string $testableProperty = 'menu';

    public function setUp(): void {
        $this->menuItem = new MenuItem;
    }

    public function testGettersAndSetters() {
        $this->menuItem->setOrder(4);
        $this->assertEquals(4, $this->menuItem->getOrder());

        $this->menuItem->setTitle('test_title');
        $this->assertEquals('test_title', $this->menuItem->getTitle());

        $this->menuItem->setDescription('test_description');
        $this->assertEquals('test_description', $this->menuItem->getDescription());

        $this->menuItem->setFilename('test_filename');
        $this->assertEquals('test_filename', $this->menuItem->getFilename());

        (string) $this->menuItem; // This should not throw any Exception
    }

    public function testToString() {
        try {
            (string) $this->menuItem; // This should not throw any Exception
            $this->assertTrue(true); // Just not to mark it as "risky"
        } catch (Exception $e) {
            $this->assertTrue(false, 'Failed transtyping to string.');
        }
    }
}
