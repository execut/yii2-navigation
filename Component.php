<?php
/**
 */

namespace execut\navigation;

use \yii\base\Component as BaseComponent;
use yii\helpers\Html;

class Component extends BaseComponent
{
    /**
     * @var Page|null
     */
    public $activePage = null;
    public $menuItems = [];
    protected $configurators = [];
    /**
     * @var Page[]
     */
    public $pages = [];

    public function addConfigurator($configurator) {
        if (is_array($configurator)) {
            $configurator = \yii::createObject($configurator);
        }

        $this->configurators[] = $configurator;
    }

    protected $isConfigured = false;
    protected function configure() {
        if ($this->isConfigured) {
            return;
        }

        $this->isConfigured = true;
        foreach ($this->configurators as $configurator) {
            $configurator->configure($this);
        }
    }

    public function getTitle() {
        if ($page = $this->activePage) {
            return $page->getTitle();
        }
    }

    public function getHeader() {
        if ($page = $this->activePage) {
            return $page->getHeader();
        }
    }

    public function getText() {
        if ($page = $this->activePage) {
            return $page->getText();
        }
    }

    public function addPage($page) {
        if (is_array($page)) {
            if (empty($page['class'])) {
                $page['class'] = Page::class;
            }

            $page = \yii::createObject($page);
        }

        $this->activePage = $page;
        $this->pages[] = $page;

        return $this;
    }

    public function getBreadcrumbsLinks() {
        $this->configure();
        $breadcrumbsLinks = [];
        foreach ($this->pages as $page) {
            $breadcrumbsLinks[] = [
                'label' => $page->getName(),
                'url' => $page->getUrl(),
            ];
        }

        return $breadcrumbsLinks;
    }

    public function addMenuItem($item) {
        foreach ($this->menuItems as &$currentItem) {
            if (is_array($currentItem) && is_array($item) && $item['label'] === $currentItem['label']) {
                if (empty($currentItem['items'])) {
                    $currentItem['items'] = [];
                }

                $currentItem['items'] = array_merge($currentItem['items'], $item['items']);
                return;
            }
        }

        $this->menuItems[] = $item;

        return $this;
    }

    public function getMenuItems() {
        $this->configure();
        return $this->menuItems;
    }

    public function initMetatags() {
        $this->configure();
        $page = $this->activePage;
        $keywords = $page->getKeywords();
        if (!empty($keywords)) {
            \yii::$app->view->registerMetaTag([
                'name' => 'keywords',
                'content' => implode(', ', $keywords)
            ]);
        }

        $description = $page->getDescription();
        if (!empty($description)) {
            \yii::$app->view->registerMetaTag(['name' => 'description', 'content' => $description]);
        }
    }

//    public function getMenuItems() {
//        return [
//            ['label' => 'Home', 'url' => '/'],
//
//            ['label' => 'Pages', 'url' => ['/pages/backend']],
//
//            ['label' => 'Menus', 'url' => ['/menus/backend']],
//        ];
//
//        $menuItems = [
//            ['label' => 'Home', 'url' => ['/site/index']],
//        ];
//        if (\Yii::$app->user->isGuest) {
//            $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
//        } else {
//            $menuItems[] = '<li>'
//                . Html::beginForm(['/site/logout'], 'post')
//                . Html::submitButton(
//                    'Logout (' . \Yii::$app->user->identity->username . ')',
//                    ['class' => 'btn btn-link logout']
//                )
//                . Html::endForm()
//                . '</li>';
//        }
//
//        return $menuItems;
//    }
}