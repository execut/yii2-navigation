<?php
/**
 * @link https://github.com/execut
 * @copyright Copyright (c) 2020 Yuriy Mamaev (eXeCUT)
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace execut\navigation\configurator;

use execut\navigation\Component;
use execut\navigation\Configurator;
use execut\navigation\page\Home;

/**
 * Home page configurator
 *
 * @package execut\navigation
 * @author Yuriy Mamaev (eXeCUT)
 */
class HomePage implements Configurator
{
    public function configure(Component $navigation)
    {
        $controller = \yii::$app->controller;
        $action = $controller->action;
        if ($action->id === 'error' && ($exception = \Yii::$app->getErrorHandler()->exception) !== null) {
            return;
        }

        $navigation->addPage([
            'class' => Home::class,
        ]);
    }
}