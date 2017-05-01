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
}