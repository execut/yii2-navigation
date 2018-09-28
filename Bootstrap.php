<?php
/**
 */

namespace execut\navigation;

use yii\base\Event;
use yii\web\Controller;
use yii\web\View;

class Bootstrap extends \execut\yii\Bootstrap
{
    public $isBootstrapI18n = true;
    public $defaultDepends = [
        'components' => [
            'navigation' => [
                'class' => Component::class,
            ],
        ],
    ];

    public function bootstrap($app)
    {
        parent::bootstrap($app);
        Event::on(View::class, View::EVENT_END_BODY, function () {
            \yii::$app->navigation->initMetaTags();
        });
    }
}