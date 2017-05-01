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

class Title extends Widget
{
    public $title = null;
    public function run() {
        if ($this->title === null) {
            $this->title = \yii::$app->navigation->getTitle();
        }

        if (!empty($this->title)) {
            return '<title>' . $this->title . '</title>';
        }
    }
}