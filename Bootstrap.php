<?php
/**
 */

namespace execut\navigation;

use yii\base\Event;
use yii\web\Controller;
use yii\web\View;

class Bootstrap extends \execut\yii\Bootstrap
{
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
        $this->registerTranslations($app);
        Event::on(View::class, View::EVENT_END_BODY, function () {
            \yii::$app->navigation->initMetaTags();
        });
    }

    public function registerTranslations($app) {
        $app->i18n->translations['execut/navigation/'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@vendor/execut/yii2-navigation/messages',
            'fileMap' => [
                'execut/navigation/' => 'navigation.php',
            ],
        ];
    }
}