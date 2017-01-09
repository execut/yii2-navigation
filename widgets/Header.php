<?php
/**
 * Created by PhpStorm.
 * User: execut
 * Date: 14.01.16
 * Time: 14:33
 */

namespace execut\yii\navigation\widgets;

use yii\base\Widget;

class Header extends Widget
{
    protected static $isRendered = false;
    public function run() {
        if (self::$isRendered) {
            return;
        }

        self::$isRendered = true;
        if (isset(\yii::$app->params['header'])) {
            echo '<h1>' . \yii::$app->params['header'] . '</h1>';
        }
    }
}