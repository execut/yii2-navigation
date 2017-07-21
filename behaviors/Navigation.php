<?php
/**
 * User: execut
 * Date: 20.05.15
 * Time: 15:56
 */

namespace execut\navigation\behaviors;

use yii\base\Behavior;

class Navigation extends Behavior {
    public $params = [];
    protected $pages = null;
    public function init() {
        if ($this->pages === null) {
//            $this->setPages([
//                [
//                    'class' => DbPage::class,
//                ]
//            ]);
        } else {
            self::initParams($this->params);
        }

        parent::init();
    }

    public function getPage($id) {
        return $this->pages[$id];
    }

    public function addPage($params) {
        $pages = $this->pages;
        $pages[] = $params;
        $this->setPages($pages);
    }
    
    public function getPages() {
        return $this->pages;
    }

    public function setPages($pages) {
        foreach ($pages as $key => $page) {
            if (is_array($page)) {
                $pages[$key] = \yii::createObject($page);
            }
        }

        $breadcrumbs = [];
        foreach ($pages as $page) {
            $breadcrumbs[$page->name] = $page->url;
        }

        $params = $page->getParams();
        $params['breadcrumbs'] = $breadcrumbs;
        $this->pages = $pages;

        self::initParams($params);
    }

    public static function initParams($params) {
        if (empty($params)) {
            return;
        }

        \yii::$app->view->metaTags = [];
        \yii::$app->view->title = null;
        unset(\yii::$app->params['header']);
        unset(\yii::$app->params['text']);

        if (!empty($params['breadcrumbs'])) {
            \yii::$app->params['breadcrumbs'] = $params['breadcrumbs'];
        }

        if (!empty($params['title'])) {
            \yii::$app->view->title = $params['title'];
        }

        if (!empty($params['keywords'])) {
            \yii::$app->view->registerMetaTag(['name' => 'keywords', 'content' => implode(', ', $params['keywords'])]);
        }

        if (!empty($params['description'])) {
            \yii::$app->view->registerMetaTag(['name' => 'description', 'content' => $params['description']]);
        }

        if (!empty($params['header'])) {
            \yii::$app->params['header'] = $params['header'];
        }

        if (!empty($params['text'])) {
            \yii::$app->params['text'] = $params['text'];
        }
    }
}