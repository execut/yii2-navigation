<?php
/**
 * Created by PhpStorm.
 * User: execut
 * Date: 13.10.14
 * Time: 13:54
 */

namespace execut\navigation\widgets;

use execut\navigation\Page;
use yii\helpers\Url;

class Breadcrumbs extends \yii\widgets\Breadcrumbs {
    public $itemTemplate = '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">{link}<meta itemprop="position" content="{position}" /></li>';
    /**
     * @var string the template used to render each active item in the breadcrumbs. The token `{link}`
     * will be replaced with the actual HTML link for each active item.
     */
    public $activeItemTemplate = '<li class="active" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">{link}<meta itemprop="position" content="{position}" /></li>';
    public $encodeLabels = false;
    public $options = [
        'class' => 'breadcrumb pull-right',
        'itemtype' => 'http://schema.org/BreadcrumbList',
        'itemscope' => '',
    ];
    public $homeLink = false;
    public function init() {
        parent::init();
        $position = 1;
        $links = \yii::$app->navigation->getBreadcrumbsLinks();
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
        return strtr($template, ['{position}' => $this->position++]);
    }
}