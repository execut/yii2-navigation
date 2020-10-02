<?php
/**
 * @link https://github.com/execut
 * @copyright Copyright (c) 2020 Mamaev Yuriy (eXeCUT)
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace execut\navigation\widgets;

use yii\base\Widget;

/**
 * Widget for output a tag of publish time of active page
 *
 * @package execut\navigation
 * @author Mamaev Yuriy (eXeCUT)
 */
class Time extends Widget
{
    /**
     * @var string Time value in format Y-m-d H:i:s
     */
    public $time = null;

    /**
     * Renders widget
     *
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
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