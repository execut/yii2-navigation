<?php
/**
 * @link https://github.com/execut
 * @copyright Copyright (c) 2020 Mamaev Yuriy (eXeCUT)
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace execut\navigation;

use yii\base\Event;
use yii\web\View;

/**
 * Bootstrap file for navigation bootstrap
 *
 * To use Yii2 navigation, include it as a bootstrap in the application configuration like the following:
 * ```php
 * return [
 *   'bootstrap' => [
 *      'yii2-navigation' => [
 *          'class' => \execut\navigation\Bootstrap::class,
 *      ],
 *    ],
 * ];
 * ```
 *
 * @package execut\navigation
 * @author Mamaev Yuriy (eXeCUT)
 */
class Bootstrap extends \execut\yii\Bootstrap
{
    /**
     * @inheritDoc
     */
    public $isBootstrapI18n = true;
    /**
     * @inheritDoc
     */
    protected $_defaultDepends = [
        'components' => [
            'navigation' => [
                'class' => Component::class,
            ],
        ],
    ];

    /**
     * Bootstrap inits navigation meta tags
     *
     * @param \yii\base\Application $app
     */
    public function bootstrap($app)
    {
        parent::bootstrap($app);
        $this->bootstrapI18n($app);
        Event::on(View::class, View::EVENT_END_BODY, function () {
            \yii::$app->navigation->initMetaTags();
        });
    }

    protected function getModuleFolderName()
    {
        return 'yii2-navigation/src';
    }
}
