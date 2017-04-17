<?php
/**
 */

namespace execut\navigation;


class BehaviorTest extends TestCase
{
    public function testSetPages() {
        $pages = [
            [
                'name' => 'test',
            ],
        ];
        $navigation = new Behavior([
            'pages' => $pages,
        ]);
        $this->assertArrayHasKey(0, $navigation->pages);
        $this->assertInstanceOf(Page::class, $navigation->pages[0]);
    }
}