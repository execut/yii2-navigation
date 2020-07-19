<?php
/**
 * @link https://github.com/execut
 * @copyright Copyright (c) 2020 Mamaev Yuriy (eXeCUT)
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace execut\navigation\page;

use execut\navigation\Page;

/**
 * Home page class
 *
 * @package execut\navigation
 * @author Mamaev Yuriy (eXeCUT)
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