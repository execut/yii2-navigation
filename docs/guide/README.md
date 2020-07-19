# eXeCUT Yii2 navigation

The package provides capabilities for controlling the navigation of your project. Package allows you to do this through a single component
and provides options for displaying data of the active page from the side of your modules:
* [Breadcrumbs with schema.org markup support](#breadcrumbs)
* [Header h1](#header-h1)
* [Page text](#page-text)
* [Time of last page modification](#time-of-last-page-modification)
* [Browser tab title](#browser-tab-title)
* Meta tags robots, description и keywords
* [Menu](#menu-setting)

## Install


The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require execut/yii2-navigation
```

or add

```
"execut/yii2-navigation": "dev-master"
```

to the require section of your `composer.json` file.

## Configuration

Before starting to use, you need to connect the necessary widgets in the right places of your application for display
navigation.

### Menu
If you want to manage menu items via Yii2 navigation, connect getting your menu items to Yii2 navigation component:
```php
$customItems = [];// Old menu items
$menuItems = array_merge($customItems, \yii::$app->navigation->getMenuItems());
echo \yii\bootstrap\Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
```

### Breadcrumbs
The output of breadcrumbs using a component is done using a next widget
 [\execut\navigation\widgets\Breadcrumbs](https://github.com/execut/yii2-navigation/blob/master/src/widgets/Breadcrumbs.php):
```php
echo \execut\navigation\widgets\Breadcrumbs::widget();
```

### Header h1
Rendering the header h1 of current page, replace it with a widget [\execut\navigation\widgets\Header](https://github.com/execut/yii2-navigation/blob/master/src/widgets/Header.php):
```php
echo \execut\navigation\widgets\Header::widget();
```

### Page text
The text of current page [\execut\navigation\widgets\Text](https://github.com/execut/yii2-navigation/blob/master/src/widgets/Text.php):
```php
echo \execut\navigation\widgets\Text::widget();
```

### Time of last page modification
Time of last page modification with schema.org support datePublished attribute [\execut\navigation\widgets\Time](https://github.com/execut/yii2-navigation/blob/master/widgets/Time.php):
```php
echo \execut\navigation\widgets\Time::widget();
```

### Browser tab title
Tag title of active page [\execut\navigation\widgets\Title](https://github.com/execut/yii2-navigation/blob/master/src/widgets/Title.php):
```php
echo \execut\navigation\widgets\Title::widget();
```

Tags of keywords and description is attach when yii2-navigation is bootstrapped.

## Usage
### Creation of the current page and its parent
To display a page through yii2-navigation, you need to designate it anywhere in your application before displaying the page
for example in a controller:
```php
$navigation = \yii::$app->navigation;
$parentPage = new \execut\navigation\Page([
    'name' => 'Name of parent page',
    'url' => [
        '/parentPageController',
    ],
]);
$navigation->addPage($parentPage);
$page = new \execut\navigation\Page([
    'title' => 'Title page',
    'keywords' => ['Keyword 1', 'Keyword 2'],
    'description' => 'Description page',
    'text' => 'Текст page',
    'header' => 'Header page',
    'name' => 'Name page',
    'url' => [
        '/pageController',
    ],
    'time' => date('Y-m-d H:i:s'),
    'noIndex' => true
]);
$navigation->addPage($page);
```
The example will connect $parentPage as the parent of the current page and display it inside breadcrumbs.
$page is activated as the current page.

The execut\navigation\Page class has support for the simplest templates for the ability to display attribute values in
values other attributes. For example, in the text of the page it is necessary to substitute the date of its modification.
To do this, you need to set the following template for page text:

```php
$page->setText('The time of page change inside the page content is: "{time}"');
```
Then the page text output will be something like this:
```
The time of page change inside the page content is: "2020-07-18 23:03:02"
```

Можете реализовать свою реализацию страниц с помощью интерфейса
[\execut\navigation\BasePage](https://github.com/execut/yii2-navigation/blob/master/src/BasePage.php)

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
Для возможности настраивать навигацию из других модулей и инкапсуляции данного функционала в рамках одного класса, в
yii2-navigation есть поддержка конфигураторов. Пример выше для этих целей можно оформить следующим образом
[\execut\navigation\configurator\Example](https://github.com/execut/yii2-navigation/blob/master/src/configurator/Example.php)
и добавить конфигуратор в предзагрузчик своего модуля:
```php
class Bootstrap implements \yii\base\BootstrapInterface
{
    public function bootstrap($app) {
        $app->navigation->addConfigurator([
            'class' => \execut\navigation\configurator\Example::class
        ]);
    }
}
```

Пример подобного применения можно подсмотреть в модуле [yii2-pages](https://github.com/execut/yii2-pages/blob/master/navigation/Configurator.php).
Там модуль страниц добавляет активные страницы из БД в навигацию сайта. Этот конфигуратор навигации подключается в
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

Ещё можно к навигации подключить конфугуратор такой страницы в предзагрузке модуля и она будет подключаться ко всем страницам автоматически:
```php
class Bootstrap implements \yii\base\BootstrapInterface
{
    public function bootstrap($app) {
        $app->navigation->addConfigurator([
            'class' => \execut\navigation\configurator\HomePage::class
        ]);
    }
}
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