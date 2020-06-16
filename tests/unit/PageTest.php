<?php
/**
 */

namespace execut\navigation;


class PageTest extends TestCase
{
    public function testSetName() {
        $name = 'test';
        $page = new Page();
        $page->setName('test');
        $this->assertEquals($name, $page->getTitle());
        $this->assertEquals($name, $page->getHeader());
    }

    public function testGetNoIndexDefault() {
        $page = new Page();
        $this->assertFalse($page->getNoIndex());
    }

    public function testSetNoIndex() {
        $page = new Page();
        $this->assertEquals($page, $page->setNoIndex(true));
        $this->assertTrue($page->getNoIndex());
    }
}