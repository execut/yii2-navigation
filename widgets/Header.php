<?php
/**
 * @link https://github.com/execut
 * @copyright Copyright (c) 2020 Yuriy Mamaev (eXeCUT)
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace execut\navigation\widgets;

use yii\base\Widget;

/**
 * Widget for render a h1 header of active page
 *
 * @package execut\navigation
 * @author Yuriy Mamaev (eXeCUT)
 */
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