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
    protected $_activePage = null;
    public $menuItems = [];
    protected $configurators = [];
    /**
     * @var Page[]
     */
    public $pages = [];

    public function getActivePage() {
        $this->configure();

        return $this->_activePage;
    }

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
        if ($page = $this->getActivePage()) {
            return $page->getTitle();
        }
    }

    public function getHeader() {
        if ($page = $this->getActivePage()) {
            return $page->getHeader();
        }
    }

    public function getText() {
        if ($page = $this->getActivePage()) {
            return $page->getText();
        }
    }

    public function getTime() {
        if ($page = $this->getActivePage()) {
            return $page->getTime();
        }
    }

    public function addPage($page) {
        if (is_array($page)) {
            if (empty($page['class'])) {
                $page['class'] = Page::class;
            }

            $page = \yii::createObject($page);
        }

        $this->_activePage = $page;
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

        $breadcrumbsLinks[count($breadcrumbsLinks) - 1]['active'] = true;

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
        $page = $this->getActivePage();
        if (!$page) {
            return;
        }

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
}