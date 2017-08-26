<?php
/**
 */

namespace execut\navigation;

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