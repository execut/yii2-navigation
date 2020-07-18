# execut/yii2-navigation

Please, select language:
[ :uk: **English**](README.md) |
[ :ru: Русский](../guide-ru/README-ru.md)

Компонент для управления всем, что касается навигации. Позволяет выводить хлебные крошки, SEO теги, меню,
заголовок и текст активной страницы согласно заданной иерархии. Позволяет отвязать друг от друга все модули, которым это
 необходимо за счёт возможности динамичной настройки.

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

### Install

Either run

```
$ php composer.phar require execut/yii2-navigation "dev-master"
```

or add

```
"execut/yii2-navigation": "dev-master"
```

to the ```require``` section of your `composer.json` file.

## Configuration

Чтобы использовать его, необходимо добавить в конфигурационный файл начальную загрузку:
```php
return [
    'bootstrap' => [
        'yii2-navigation' => [
            'class' => \execut\navigation\Bootstrap::class,
        ],
    ],
];
```

Если хотите управлять элементами меню через yii2-navigation, переключите формирование элементов своих меню на компонент yii2-navigation:
```php
$customItems = [];// Прежние элементы меню
$menuItems = array_merge($customItems, \yii::$app->navigation->getMenuItems());
echo \yii\bootstrap\Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
```

Вывод хлебных крошек с помощью [\execut\navigation\widgets\Breadcrumbs](https://github.com/execut/yii2-navigation/blob/master/widgets/Breadcrumbs.php):
```php
echo \execut\navigation\widgets\Breadcrumbs::widget();
```

Вывод заголовка h1 текущей страницы переключите на виджет [\execut\navigation\widgets\Header](https://github.com/execut/yii2-navigation/blob/master/widgets/Header.php):
```php
echo \execut\navigation\widgets\Header::widget();
```

Текст текущей страницы [\execut\navigation\widgets\Text](https://github.com/execut/yii2-navigation/blob/master/widgets/Text.php):
```php
echo \execut\navigation\widgets\Text::widget();
```

Время модификации активной страницы страницы [\execut\navigation\widgets\Time](https://github.com/execut/yii2-navigation/blob/master/widgets/Time.php):
```php
echo \execut\navigation\widgets\Time::widget();
```

Тег title активной страницы [\execut\navigation\widgets\Title](https://github.com/execut/yii2-navigation/blob/master/widgets/Title.php):
```php
echo \execut\navigation\widgets\Title::widget();
```

Теги keywords и description сформируются во время предзагрузки yii2-navigation.

## Использование
### Добавление текущей страницы и её родителя
Чтобы вывести через yii2-navigation страницу, необходимо её обозначить в любом месте вашего приложения перед выводом страницы
например, в контроллере:
```php
$navigation = \yii::$app->navigation;
$parentPage = new \execut\navigation\Page([
    'name' => 'Name родителя',
    'url' => [
        '/parentPageController',
    ],
]);
$navigation->addPage($parentPage);
$page = new \execut\navigation\Page([
    'title' => 'Title страницы',
    'keywords' => ['Keyword 1', 'Keyword 2'],
    'description' => 'Description страницы',
    'text' => 'Текст страницы',
    'header' => 'Header страницы',
    'name' => 'Name страницы',
    'url' => [
        '/pageController',
    ],
    'time' => date('Y-m-d H:i:s'),
    'noIndex' => true
]);
$navigation->addPage($page);
```
Пример подключит $parentPage как родитель текущей и выведет его в хлебных крошках. А $page покажется как текущая страница.


### Настройка меню

При желании можно настраивать меню через yii2-navigation путём добавления элементов в них и вывода через виджет меню:
```php
$navigation = \yii::$app->navigation;
$navigation->addMenuItem([
    'label' => 'Название позиции меню',
    'url' => [
        '/menu-item',
    ],
    'items' => [
        [
            'label' => 'Вложенная позиция меню',
            'url' => [
                '/menu-sub-item',
            ],
        ],
    ]
]);
echo \yii\bootstrap\Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => \yii::$app->navigation->getMenuItems(),
]);
```

### Configurators
Для возможности настраивать навигацию из других модулей и инкапсуляции данного функционала в классах, в yii2-navigation есть поддержка
конфигураторов. Пример выше для этих целей можно оформить следующим образом
[\execut\navigation\configurator\Example](https://github.com/execut/yii2-navigation/blob/master/configurator/Example.php)
и добавить его в настройку приложения компонента navigation:
```php
return [
    'bootstrap' => [
        'yii2-navigation' => [
            'class' => \execut\navigation\Bootstrap::class,
            'depends' => [
                'components' => [
                    'navigation' => [
                        'configurators' => [
                            'example' => \execut\navigation\configurator\Example::class
                        ]
                    ]
                ]
            ]
        ],
    ],
];
```
или добавить конфигуратор в предзагрузчик своего модуля на лету:
```php
\yii::$app->navigation->addConfigurator([
    'class' => \execut\navigation\configurator\Example::class
]);
```

Пример подобного применения можно подсмотреть в модуле [yii2-pages](https://github.com/execut/yii2-pages/blob/master/navigation/Configurator.php).
Там модуль страниц добавляет активные страницы из БД в навигацию сайта. Конфигуратор навигации подключается в
[предзагрузчике модуля Frontend](https://github.com/execut/yii2-pages/blob/master/bootstrap/Frontend.php).