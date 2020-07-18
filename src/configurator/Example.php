<?php
/**
 * @link https://github.com/execut
 * @copyright Copyright (c) 2020 Mamaev Yuriy (eXeCUT)
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace execut\navigation\configurator;


use execut\navigation\Component;
use execut\navigation\Configurator;
use execut\navigation\Page;

/**
 * Example of configurator interpretation for guide
 *
 * @package execut\navigation
 * @author Mamaev Yuriy (eXeCUT)
 */
class Example implements Configurator
{
    public function configure(Component $navigation)
    {
        $parentPage = new Page([
            'name' => 'Name of parent page',
            'url' => [
                '/parentPageController',
            ],
        ]);
        $navigation->addPage($parentPage);
        $page = new Page([
            'title' => 'Title of page',
            'keywords' => ['Keyword 1', 'Keyword 2'],
            'description' => 'Description of page',
            'text' => 'Text of page',
            'header' => 'Header of page',
            'name' => 'Name of page',
            'url' => [
                '/pageController',
            ],
            'time' => date('Y-m-d H:i:s'),
            'noIndex' => true
        ]);
        $navigation->addPage($page);

        $navigation->addMenuItem([
            'label' => 'Name of menu position',
            'url' => [
                '/menu-item',
            ],
            'items' => [
                [
                    'label' => 'Name of nested menu position',
                    'url' => [
                        '/menu-sub-item',
                    ],
                ],
            ]
        ]);
    }
}