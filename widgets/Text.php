<?php
/**
 * Created by PhpStorm.
 * User: execut
 * Date: 14.01.16
 * Time: 14:33
 */

namespace execut\navigation\widgets;


use execut\navigation\Page;
use execut\yii\jui\Widget;

class Text extends Widget
{
    public $text = null;
    public function run() {
        if ($this->text === null) {
            $this->text = \yii::$app->navigation->getText();
        }

        $result = $this->_beginContainer();
        $result .= $this->text;
        $result .= $this->_endContainer();

        return $result;
    }
}