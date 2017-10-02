<?php
/**
 * Created by PhpStorm.
 * User: execut
 * Date: 9/29/17
 * Time: 3:48 PM
 */

namespace execut\navigation\configurator;

use execut\navigation\Component;
use execut\navigation\Configurator;
use execut\navigation\page\Home;

class HomePage implements Configurator
{
    public function configure(Component $navigation)
    {
        $navigation->addPage([
            'class' => Home::class,
        ]);
    }
}