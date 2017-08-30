<?php
/**
 * Created by PhpStorm.
 * User: execut
 * Date: 13.10.14
 * Time: 13:54
 */

namespace execut\navigation\widgets;

use execut\navigation\Page;
use Yii;
use yii\helpers\Html;

class Breadcrumbs extends \yii\widgets\Breadcrumbs {
    public $itemTemplate = '<{itemTag} itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">{link}<meta itemprop="position" content="{position}" /></{itemTag}>{delimiter}';
    /**
     * @var string the template used to render each active item in the breadcrumbs. The token `{link}`
     * will be replaced with the actual HTML link for each active item.
     */
    public $activeItemTemplate = '<{itemTag} class="active" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">{link}<meta itemprop="position" content="{position}" /></{itemTag}>';
    public $encodeLabels = false;
    public $options = [
        'class' => 'breadcrumb pull-right',
    ];

    public $microdataOptions = [
        'itemtype' => 'http://schema.org/BreadcrumbList',
        'itemscope' => '',
    ];

    public $itemTag = 'li';
    public $delimiter = '';
    public $homeLink = false;
    public $isRenderAlone = false;
    public function init() {
        parent::init();
        $position = 1;
        $links = \yii::$app->navigation->getBreadcrumbsLinks();
        if (count($links) <= 1 && !$this->isRenderAlone) {
            return;
        }

        foreach ($links as $key => $link) {
            $link = array_merge([
                'itemscope' => '',
                'itemtype' => 'http://schema.org/Thing',
                'itemprop' => 'item',
            ], $link);

            if (!empty($link['label'])) {
                $link['label'] = '<span  itemprop="name">' . $link['label'] . '</span>';
            }

            $position++;
            $links[$key] = $link;
        }

        $this->links = $links;
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        if (empty($this->links)) {
            return;
        }
        $links = [];
        if ($this->homeLink === null) {
            $links[] = $this->renderItem([
                'label' => Yii::t('yii', 'Home'),
                'url' => Yii::$app->homeUrl,
            ], $this->itemTemplate);
        } elseif ($this->homeLink !== false) {
            $links[] = $this->renderItem($this->homeLink, $this->itemTemplate);
        }
        foreach ($this->links as $link) {
            if (!is_array($link)) {
                $link = ['label' => $link];
            }

            $isActive = isset($link['active']);
            unset($link['active']);
            $links[] = $this->renderItem($link, !$isActive ? $this->itemTemplate : $this->activeItemTemplate);
        }
        echo Html::tag($this->tag, implode('', $links), array_merge($this->options, $this->microdataOptions));
    }

    /**
     * @return mixed
     */
    protected function getActivePage()
    {
        /**
         * @var Page
         */
        $page = \yii::$app->navigation->getActivePage();
        return $page;
    }

    protected $position = 1;
    public function renderItem($link, $template)
    {
        $template = parent::renderItem($link, $template);
        return strtr($template, ['{position}' => $this->position++, '{delimiter}' => $this->delimiter, '{itemTag}' => $this->itemTag]);
    }
}