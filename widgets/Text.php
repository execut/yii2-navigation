<?php
/**
 * @link https://github.com/execut
 * @copyright Copyright (c) 2020 Yuriy Mamaev (eXeCUT)
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */
namespace execut\navigation\widgets;


use execut\navigation\Page;
use execut\yii\jui\Widget;

/**
 * Widget for render a html content of active page
 *
 * @package execut\navigation
 * @author Yuriy Mamaev (eXeCUT)
 */
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