<?php
/**
 */

namespace execut\navigation\page;

use execut\navigation\Page;

class Home extends Page
{
    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->setName('Home');
        $this->setUrl('/');
        $this->setUrl('/');
    }
}