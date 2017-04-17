<?php
/**
 */

namespace execut\navigation;


class PageTest extends TestCase
{
    public function testSetName() {
        $name = 'test';
        $page = new Page([
            'name' => $name,
        ]);
        $this->assertEquals($name, $page->title);
        $this->assertEquals($name, $page->header);
    }
}