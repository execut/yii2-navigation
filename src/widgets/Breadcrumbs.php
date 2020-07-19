<?php
/**
 * @link https://github.com/execut
 * @copyright Copyright (c) 2020 Mamaev Yuriy (eXeCUT)
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace execut\navigation\widgets;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * Breadcrumbs widget with support of microdata http://schema.org/BreadcrumbList for search engines
 *
 * @package execut\navigation
 * @author Mamaev Yuriy (eXeCUT)
 */
class Breadcrumbs extends \yii\widgets\Breadcrumbs {
    /**
     * @inheritDoc
     */
    public $itemTemplate = '<{itemTag} itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">{link}<meta itemprop="position" content="{position}" /></{itemTag}>{delimiter}';
    /**
     * @inheritDoc
     */
    public $activeItemTemplate = '<{itemTag} class="active" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">{link}<meta itemprop="position" content="{position}" /></{itemTag}>';
    /**
     * @inheritDoc
     */
    public $encodeLabels = false;
    /**
     * @inheritDoc
     */
    public $options = [
        'class' => 'breadcrumb pull-right',
    ];
    /**
     * @var array Microdata options
     */
    public $microdataOptions = [
        'itemtype' => 'http://schema.org/BreadcrumbList',
        'itemscope' => '',
    ];
    /**
     * @var string Breadcrumb item html tag
     */
    public $itemTag = 'li';
    /**
     * @var string Between breadcrumbs delimiter
     */
    public $delimiter = '';
    /**
     * @var bool Is render home link
     */
    public $homeLink = false;
    /**
     * @var bool Is render breadcrumbs when they has only alone link
     */
    public $isRenderAlone = false;
    /**
     * @var int Item position counter
     */
    protected $position = 1;

    /**
     * @inheritDoc
     */
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
            if (!empty($link['url'])) {
                $link['id'] = Url::to($link['url'], true);
            }

            $links[$key] = $link;
        }

        unset($links[$key]['url']);
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
            if ($isActive) {
                unset($link['url']);
            }

            unset($link['active']);
            $links[] = $this->renderItem($link, !$isActive ? $this->itemTemplate : $this->activeItemTemplate);
        }
        echo Html::tag($this->tag, implode('', $links), array_merge($this->options, $this->microdataOptions));
    }

    /**
     * @inheritDoc
     */
    protected function renderItem($link, $template)
    {
        $encodeLabel = ArrayHelper::remove($link, 'encode', $this->encodeLabels);
        if (array_key_exists('label', $link)) {
            $label = $encodeLabel ? Html::encode($link['label']) : $link['label'];
        } else {
            throw new InvalidConfigException('The "label" element is required for each link.');
        }
        if (isset($link['template'])) {
            $template = $link['template'];
        }

        $options = $link;
        unset($options['template'], $options['label']);
        if (isset($link['url'])) {
            $link = Html::a($label, $link['url'], $options);
        } else {
            $link = Html::tag('span', $label, $options);
        }

        return strtr($template, ['{link}' => $link, '{position}' => $this->position++, '{delimiter}' => $this->delimiter, '{itemTag}' => $this->itemTag]);
    }
}