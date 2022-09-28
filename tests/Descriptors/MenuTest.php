<?php

namespace Dealheure\Markdoc\Tests\Descriptors;

use Exception;
use PHPUnit\Framework\TestCase;
use Dealheure\Markdoc\Descriptors\Menu;
use Dealheure\Markdoc\Descriptors\MenuItem;
// use Dealheure\Markdoc\Tests\Traits\OptionsTest;

class MenuTest extends TestCase {
    // use OptionsTest;

    protected $menu;
    // protected string $testableProperty = 'menu';

    public function setUp(): void {
        $this->menu = new Menu;

        for ($i = 0; $i < 10; $i++) {
            $this->menu->addItem(
                new MenuItem(md5(uniqid()), md5(uniqid()), md5(uniqid()))
            );
        }
    }

    public function testOptions() {
        $this->assertEquals('unordered', $this->menu->getOptions('type'));
    }

    public function testMenuItems() {
        $this->assertIsArray($this->menu->getItems());
        $this->assertCount(10, $this->menu->getItems());

        $this->menu->addItem(
            (new MenuItem('', 'test'))
                ->setOrder(1)
        );

        $this->assertEquals('test', $this->menu->getItems()[0]->getTitle());
    }

    public function testToString() {
        try {
            (string) $this->menu; // This should not throw any Exception
            $this->assertTrue(true); // Just not to mark it as "risky"
        } catch (Exception $e) {
            $this->assertTrue(false, 'Failed transtyping to string.');
        }
    }
}
