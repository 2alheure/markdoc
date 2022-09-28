<?php

namespace Dealheure\Markdoc\Tests\Traits;

trait OptionsTest {
    protected string $testableProperty;

    public function testOptions() {
        $this->assertIsArray($this->{$this->testableProperty}->getOptions());
        $this->assertIsArray($this->{$this->testableProperty}->defaultOptions());
        $this->assertTrue($this->{$this->testableProperty}->checkOptions());

        $this->assertInstanceOf(
            $this->{$this->testableProperty}::class,
            $this->{$this->testableProperty}->setOptions('test', 'test')
        );
        $this->assertEquals('test', $this->{$this->testableProperty}->getOptions('test'));
        $this->assertNull($this->{$this->testableProperty}->getOptions('not_existing'));
    }
}
