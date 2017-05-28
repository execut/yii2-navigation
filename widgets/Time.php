<?php
/**
 * Created by PhpStorm.
 * User: execut
 * Date: 14.01.16
 * Time: 14:33
 */

namespace execut\navigation\widgets;

use execut\pages\models\Page;
use yii\base\Widget;
use yii\helpers\Html;

class Time extends Widget
{
    public $time = null;
    public function run() {
        if ($this->time === null) {
            $this->time = \yii::$app->navigation->getTime();
        }

        if (!empty($this->time)) {
            return '<time datetime="' . date('Y-m-dTH:I:S', $this->time) . '" pubdate>' . date('d F Y', $this->time) . '</time>';
        }
    }
}