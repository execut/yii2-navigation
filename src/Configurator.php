<?php
/**
 * @link https://github.com/execut
 * @copyright Copyright (c) 2020 Mamaev Yuriy (eXeCUT)
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace execut\navigation;


/**
 * Configurator interface for navigation
 *
 * To make navigation configurator define configure method and add all pages operations inside it:
 * ```php
 * public function configure(Component $navigation) {
 *     $page = new Page();
 *     $navigation->addPage($page);
 * }
 * ```
 *
 * @package execut\navigation
 * @author Mamaev Yuriy (eXeCUT)
 * @see https://github.com/execut/yii2-navigation/blob/master/docs/guide/README.md#Configurators
 */
interface Configurator
{
    /**
     * Call for configure passed navigation component
     * @param Component $navigation Navigation component
     */
    public function configure(Component $navigation);
}