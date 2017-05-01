<?php
/**
 */

namespace execut\navigation\page;


use execut\navigation\TestCase;

class HomeTest extends TestCase
{
    public function testSetName() {
        $homePage = new Home();
        $this->assertEquals('Home', $homePage->getTitle());
        $this->assertEquals('/', $homePage->getUrl());
    }
}