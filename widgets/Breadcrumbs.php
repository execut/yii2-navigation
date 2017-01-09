<?php
/**
 * Created by PhpStorm.
 * User: execut
 * Date: 13.10.14
 * Time: 13:54
 */

namespace execut\yii\navigation\widgets;


use execut\yii\helpers\ArrayHelper;
use execut\yii\helpers\Html;
use yii\base\InvalidConfigException;
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
//        var_dump($this->options);
//        exit;
        if (!isset(\yii::$app->params['breadcrumbs']['Home page']) && !isset(\yii::$app->params['breadcrumbs']['Главная'])) {
            $breadcrumbs = ['Главная' => '/'];
        } else {
            $breadcrumbs = [];
        }

        if (!empty(\yii::$app->params['breadcrumbs'])) {
            $breadcrumbs = array_merge($breadcrumbs, \yii::$app->params['breadcrumbs']);
        }
//        else {
//            $breadcrumbs = \YiiOld::app()->controller->getBreadcrumbs();
//        }

        $links = [];
        $position = 1;
        foreach ($breadcrumbs as $url => $name) {
            $link = [
                'itemscope' => '',
                'itemtype' => 'http://schema.org/Thing',
                'itemprop' => 'item',
            ];
            if (is_string($url)) {
                $label = $url;
                $link['url'] = Url::to(trim($name), true);
            } else {
                $label = trim($name);
            }

            $label = trim($label);

            $link['label'] = '<span  itemprop="name">' . $label . '</span>';
            $position++;
            $links[] = $link;
        }

//        unset($links[count($links) - 1]['url']);

        $this->links = $links;
    }

    public function run() {
        \yii::$app->params['disableBreadcrumbs'] = true;
//        BreadcrumbsAsset::register($this->view);

        return parent::run();
    }

    protected $position = 1;
    public function renderItem($link, $template)
    {
        $template = parent::renderItem($link, $template);
        return strtr($template, ['{position}' => $this->position++]);
    }
}