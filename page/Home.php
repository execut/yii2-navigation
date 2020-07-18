<?php
/**
 * @link https://github.com/execut
 * @copyright Copyright (c) 2020 Yuriy Mamaev (eXeCUT)
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace execut\navigation\page;

use execut\navigation\Page;

/**
 * Home page class
 *
 * @package execut\navigation
 * @author Yuriy Mamaev (eXeCUT)
 */
class Home extends Page
{
    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->setName(\yii::t('execut/navigation', 'Home'));
        $this->setUrl('/');
    }
}