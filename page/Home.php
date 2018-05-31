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
        $this->setName(\yii::t('execut/navigation/', 'Home'));
        $this->setUrl('/');
    }
}