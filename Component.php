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

    public function setActivePage($page) {
        $this->configure();
        $page = $this->createPage($page);

        $this->_activePage = $page;
        return $this;
    }

    public function addPages($pages) {
        foreach ($pages as $page) {
            $this->addPage($page);
        }
    }

    public function addPage($page) {
        $page = $this->createPage($page);
        $activePage = $this->getActivePage();
        if ($activePage) {
            $page->setParentPage($activePage);
        }

        $this->setActivePage($page);
    }

    public function getActivePage() {
        $this->configure();

        return $this->_activePage;
    }

    public function setConfigurators($configurators) {
        foreach ($configurators as $configurator) {
            $this->addConfigurator($configurator);
        }
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

    public function reset() {
        $this->_activePage = null;
        $this->isConfigured = false;
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

    public function getBreadcrumbsLinks() {
        $this->configure();
        $breadcrumbsLinks = [];
        $page = $this->getActivePage();
        while ($page) {
            $breadcrumbsLinks[] = [
                'label' => $page->getName(),
                'url' => $page->getUrl(),
            ];

            $page = $page->getParentPage();
        }

        $breadcrumbsLinks = array_reverse($breadcrumbsLinks);

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

    protected $metaTagsIsInited = false;
    public function initMetaTags() {
        if ($this->metaTagsIsInited) {
            return;
        }

        $this->metaTagsIsInited = true;
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

        $title = $page->getTitle();
        if (!empty($title)) {
            \yii::$app->view->title = $title;
        }

        $description = $page->getDescription();
        if (!empty($description)) {
            \yii::$app->view->registerMetaTag(['name' => 'description', 'content' => $description]);
        }

        if ($page->getNoIndex()) {
            \yii::$app->view->registerMetaTag([
                'name' => 'robots',
                'content' => 'noindex,nofollow'
            ]);
        }
    }

    /**
     * @param $page
     * @return array|object
     */
    protected function createPage($page)
    {
        if (is_array($page)) {
            if (empty($page['class'])) {
                $page['class'] = Page::class;
            }

            $page = \yii::createObject($page);
        }
        return $page;
    }
}