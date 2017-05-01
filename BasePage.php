<?php
/**
 * Created by PhpStorm.
 * User: execut
 * Date: 26.05.16
 * Time: 11:42
 */

namespace execut\navigation;

use yii\base\Component;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

interface BasePage
{
    /**
     * @return null
     */
    public function getKeywords();

    /**
     * @return null
     */
    public function getUrl();

    /**
     * @return null
     */
    public function getName();

    /**
     * @return null
     */
    public function getHeader();

    /**
     * @return null
     */
    public function getText();

    /**
     * @return null
     */
    public function getDescription();

    /**
     * @return null
     */
    public function getTitle();

    /**
     * @return self
     */
    public function getParentPage();
}