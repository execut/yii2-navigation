<?php
/**
 * @link https://github.com/execut
 * @copyright Copyright (c) 2020 Yuriy Mamaev (eXeCUT)
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace execut\navigation\widgets;

use yii\base\Widget;

/**
 * Widget for output a tag of publish time of active page
 *
 * @package execut\navigation
 * @author Yuriy Mamaev (eXeCUT)
 */
class Time extends Widget
{
    public $time = null;
    public function run() {
        if ($this->time === null) {
            $this->time = \yii::$app->navigation->getTime();
        }

        if (!empty($this->time)) {
            $date = date('Y-m-d\TH:i:s', $this->time);
            return '<time datetime="' . $date . '" itemprop="datePublished">' . \yii::$app->formatter->asDate($this->time, 'long') . '</time>';
        }
    }
}