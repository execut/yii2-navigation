# execut/yii2-navigation

Компонент для управления всем, что касается навигации. Позволяет управлять навигацией проекта на Yii2 через единую
прослойку-компонент. Предоставляет возможность для вывода:
* [Хлебные крошки с поддержкой разметки schema.org](#хлебные-крошки)
* [Заголовок h1](#заголовок-h1)
* [Текст страницы](#текст-страницы)
* [Время модификации](#время-модификации)
* [Заголовок вкладки браузера](#заголовок-вкладки-браузера)
* Meta-теги robots, description и keywords
* [Меню](#настройка-меню)

## Установка

Самый простой способ установки это с помощью [composer](http://getcomposer.org/download/).

### Установка

Просто запустите

```
$ php composer.phar require execut/yii2-navigation "dev-master"
```

или добавьте

```
"execut/yii2-navigation": "dev-master"
```

в ```require``` секцию вашего `composer.json` файла.

## Конфигурация

Перед началом использования необходимо добавить в конфигурационный файл начальную загрузку:
```php
return [
    'bootstrap' => [
        'yii2-navigation' => [
            'class' => \execut\navigation\Bootstrap::class,
        ],
    ],
];
```

### Меню
Если хотите управлять элементами меню через yii2-navigation, переключите формирование элементов своих меню на компонент
yii2-navigation:
```php
$customItems = [];// Прежние элементы меню
$menuItems = array_merge($customItems, \yii::$app->navigation->getMenuItems());
echo \yii\bootstrap\Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
```

### Хлебные крошки
Вывод хлебных крошек с помощью [\execut\navigation\widgets\Breadcrumbs](https://github.com/execut/yii2-navigation/blob/master/widgets/Breadcrumbs.php):
```php
echo \execut\navigation\widgets\Breadcrumbs::widget();
```

### Заголовок h1
Вывод заголовка h1 текущей страницы переключите на виджет [\execut\navigation\widgets\Header](https://github.com/execut/yii2-navigation/blob/master/widgets/Header.php):
```php
echo \execut\navigation\widgets\Header::widget();
```

### Текст страницы
Текст текущей страницы [\execut\navigation\widgets\Text](https://github.com/execut/yii2-navigation/blob/master/widgets/Text.php):
```php
echo \execut\navigation\widgets\Text::widget();
```

### Время модификации
Время модификации активной страницы страницы [\execut\navigation\widgets\Time](https://github.com/execut/yii2-navigation/blob/master/widgets/Time.php):
```php
echo \execut\navigation\widgets\Time::widget();
```

### Заголовок вкладки браузера
Тег title активной страницы [\execut\navigation\widgets\Title](https://github.com/execut/yii2-navigation/blob/master/widgets/Title.php):
```php
echo \execut\navigation\widgets\Title::widget();
```

Теги keywords и description сформируются во время предзагрузки yii2-navigation.

## Использование
### Добавление иерархии текущей страницы
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
Пример подключит $parentPage как родитель текущей и выведет его в хлебных крошках. А $page активируется как текущая страница.

У класса execut\navigation\Page есть поддержка простейших шаблонов для возможности вывода значений атрибутов в значениях
других атрибутов. Например, необходимо указать в тексте страницы её дату изменения. Для этого нужно задать такой шаблон
тексту страницы:
```php
$page->setText('Время изменения страницы внутри содержания страницы равно: "{time}"');
```
Тогда вывод текста страницы будет примерно такой:
```
Время изменения страницы внутри содержания страницы равно: "2020-07-18 23:03:02"
```

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

### Конфигураторы
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

## Типовые страницы
Реализованы две типовые страницы для стандартных страниц:
### Домашняя страница
Используется для обозначения домашней страницы в хлебных крошках. Если вы хотите указать домашнюю страницу
как родительскую у активной страницы, то перед её добавлением укажите домашнюю:
```php
$navigation->addPage(new \execut\navigation\page\Home());
$navigation->addPage($currentPage);
```
И она появится в хлебных крошках как родитель текущей страницы.

Ещё можно к навигации подключить конфугуратор такой страницы и она будет подключаться ко всем страницам автоматически:
```php

return [
    'bootstrap' => [
        'yii2-navigation' => [
            'class' => \execut\navigation\Bootstrap::class,
            'depends' => [
                'components' => [
                    'navigation' => [
                        'configurators' => [
                            'example' => \execut\navigation\configurator\HomePage::class
                        ]
                    ]
                ]
            ]
        ],
    ],
];
```

### Страница ошибки 404
В выводе 404 ошибок вы можете указать типовую страницу NotFound, в которой уже заданы все свойства типовой 404
страницы:
```php
$errorPage = new \execut\navigation\page\NotFound([
    'text' => $exception->getMessage(),
    'code' => $exception->getCode(),
]);
\yii::$app->navigation->addPage($errorPage);
```