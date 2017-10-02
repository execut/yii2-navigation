<?php
/**
 * Created by PhpStorm.
 * User: execut
 * Date: 14.01.16
 * Time: 14:33
 */

namespace execut\navigation\widgets;

use yii\base\Widget;

class Header extends Widget
{
    public $header = null;
    public function run() {
        if ($this->header === null) {
            $this->header = \yii::$app->navigation->getHeader();
        }

        if (!empty($this->header)) {
            return '<h1>' . $this->header . '</h1>';
        }
    }
}