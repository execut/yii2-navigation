<?php
/**
 * @link https://github.com/execut
 * @copyright Copyright (c) 2020 Mamaev Yuriy (eXeCUT)
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace execut\navigation\widgets;

use yii\base\Widget;
use yii\helpers\Html;

/**
 * Widget for output a title tag of active page
 *
 * @package execut\navigation
 * @author Mamaev Yuriy (eXeCUT)
 */
class Title extends Widget
{
    /**
     * @var string Title value string
     */
    public $title = null;

    /**
     * Renders widget
     *
     * @return string
     */
    public function run() {
        if ($this->title === null) {
            $this->title = \yii::$app->navigation->getTitle();
        }

        if (!empty($this->title)) {
            return '<title>' . Html::encode($this->title) . '</title>';
        }
    }
}