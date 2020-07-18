<?php
/**
 * @link https://github.com/execut
 * @copyright Copyright (c) 2020 Yuriy Mamaev (eXeCUT)
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace execut\navigation;


/**
 * Test of simple page
 *
 * @package execut\navigation
 * @author Yuriy Mamaev (eXeCUT)
 */
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