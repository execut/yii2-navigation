<?php
/**
 */

namespace execut\navigation\page;


use execut\navigation\Page;

class NotFound extends Page
{
    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->setName('Page not found');
        $this->setText('Sorry page does\'t exist');
    }
}