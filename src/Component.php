<?php
/**
 * @link https://github.com/execut
 * @copyright Copyright (c) 2020 Mamaev Yuriy (eXeCUT)
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace execut\navigation;

use \yii\base\Component as BaseComponent;

/**
 * Component for configure navigation pages and menu items
 *
 * @package execut\navigation
 * @author Mamaev Yuriy (eXeCUT)
 */
class Component extends BaseComponent
{
    /**
     * @var array Added to navigation menu items
     */
    public $menuItems = [];
    /**
     * @var BasePage|null Active page
     */
    protected $_activePage = null;
    /**
     * @var array Added to navigation configurators
     */
    protected $configurators = [];
    /**
     * @var bool Flag, indicated that existed navigation configurators is already applied
     */
    protected $isConfigured = false;
    /**
     * @var bool Flag, indicated that meta tags is already initialized
     */
    protected $metaTagsIsInited = false;

    /**
     * Setting active navigation page
     * @param $page
     * @return $this
     */
    public function setActivePage($page) {
        $this->configure();
        $page = $this->createPage($page);

        $this->_activePage = $page;
        return $this;
    }

    /**
     * Add to navigation many pages at once
     *
     * @param BasePage[]|array $pages
     */
    public function addPages($pages) {
        foreach ($pages as $page) {
            $this->addPage($page);
        }
    }

    /**
     * Add to navigation single page and set they current active page as parent
     *
     * @param array|BasePage $page
     */
    public function addPage($page) {
        $page = $this->createPage($page);
        $activePage = $this->getActivePage();
        if ($activePage) {
            $page->setParentPage($activePage);
        }

        $this->setActivePage($page);
    }

    /**
     * Get current active navigation page
     *
     * @return BasePage|null
     */
    public function getActivePage() {
        $this->configure();

        return $this->_activePage;
    }

    /**
     * Set navigation configurators
     *
     * @param Configurator|array $configurators
     * @throws \yii\base\InvalidConfigException
     */
    public function setConfigurators($configurators) {
        foreach ($configurators as $configurator) {
            $this->addConfigurator($configurator);
        }
    }

    /**
     * Add single configurator
     *
     * @param Configurator|array $configurator
     * @throws \yii\base\InvalidConfigException
     */
    public function addConfigurator($configurator) {
        if (is_array($configurator)) {
            $configurator = \yii::createObject($configurator);
        }

        $this->configurators[] = $configurator;
    }

    /**
     * Configure component via navigation configurators
     */
    protected function configure() {
        if ($this->isConfigured) {
            return;
        }

        $this->isConfigured = true;
        foreach ($this->configurators as $configurator) {
            $configurator->configure($this);
        }
    }

    /**
     * Reset all component params
     */
    public function reset() {
        $this->_activePage = null;
        $this->isConfigured = false;
    }

    /**
     * Getting title of active page
     *
     * @return string|null
     */
    public function getTitle() {
        if ($page = $this->getActivePage()) {
            return $page->getTitle();
        }
    }

    /**
     * Getting header of active page
     *
     * @return string|null
     */
    public function getHeader() {
        if ($page = $this->getActivePage()) {
            return $page->getHeader();
        }
    }

    /**
     * Getting text of active page
     *
     * @return string|null
     */
    public function getText() {
        if ($page = $this->getActivePage()) {
            return $page->getText();
        }
    }

    /**
     * Getting modification time of active page
     *
     * @return string|null
     */
    public function getTime() {
        if ($page = $this->getActivePage()) {
            return $page->getTime();
        }
    }

    /**
     * Getting a breadcrumbs links of active page for Breadcrumbs widget
     *
     * @return array
     */
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

    /**
     * Add menu item
     *
     * @return self
     */
    public function addMenuItem($item) {
        foreach ($this->menuItems as &$currentItem) {
            if (is_array($currentItem) && is_array($item) && $item['label'] === $currentItem['label']) {
                if (empty($currentItem['items'])) {
                    $currentItem['items'] = [];
                }

                if (!empty($item['items'])) {
                    $currentItem['items'] = array_merge($currentItem['items'], $item['items']);
                }

                return $this;
            }
        }

        $this->menuItems[] = $item;

        return $this;
    }

    /**
     * Get all menu items for Nav widget
     *
     * @return array
     */
    public function getMenuItems() {
        $this->configure();
        return $this->menuItems;
    }

    /**
     * Register meta tags of active page to view object
     */
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
     * Pages factory
     *
     * @param BasePage|array $page
     * @return BasePage
     * @throws \yii\base\InvalidConfigException
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