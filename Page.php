<?php
/**
 * Created by PhpStorm.
 * User: execut
 * Date: 26.05.16
 * Time: 11:42
 */

namespace execut\navigation;

use yii\base\Component as BaseComponent;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

class Page extends BaseComponent implements BasePage
{
    protected $title = null;
    protected $keywords = [];
    protected $description = null;
    protected $text = null;
    protected $header = null;
    protected $name = null;
    protected $url = null;
    protected $time = null;
    protected $parentPage = null;

    /**
     * @return null
     */
    public function getKeywords()
    {
        $result = [];
        foreach ($this->keywords as $keyword) {
            $result[] = $this->replaceTemplate($keyword);
        }

        return $result;
    }

    /**
     * @return null
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param null $url
     */
    public function setUrl($url)
    {
        if (is_array($url)) {
            $url = Url::to($url);
        }

        $this->url = $url;
    }

    /**
     * @return null
     */
    public function getName()
    {
        return $this->replaceTemplate($this->name);
    }

    /**
     * @param null $name
     */
    public function setName($name)
    {
        $this->name = $name;
        if ($this->title === null) {
            $this->title = $name;
        }

        if ($this->header === null) {
            $this->header = $name;
        }
    }

    /**
     * @return null
     */
    public function getHeader()
    {
        return $this->replaceTemplate($this->header);
    }

    /**
     * @param null $header
     */
    public function setHeader($header)
    {
        $this->header = $header;
    }

    /**
     * @return null
     */
    public function getText()
    {
        return $this->replaceTemplate($this->text);
    }

    /**
     * @param null $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * @return null
     */
    public function getDescription()
    {
        return $this->replaceTemplate($this->description);
    }

    /**
     * @param null $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @param null $keywords
     */
    public function setKeywords($keywords)
    {
        if (is_string($keywords)) {
            $keywords = explode(',', $keywords);
        }

        $this->keywords = $keywords;
    }

    /**
     * @return null
     */
    public function getTitle()
    {
        return $this->replaceTemplate($this->title);
    }

    /**
     * @param null $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return null
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @param null $Time
     */
    public function setTime($time)
    {
        $this->time = $time;
    }

    /**
     * @return null
     */
    public function getParentPage()
    {
        return $this->parentPage;
    }

    /**
     * @param null $title
     */
    public function setParentPage($page)
    {
        $this->parentPage = $page;
    }

    protected function replaceTemplate($template) {
        $parts = explode('{', $template);
        $result = '';
        foreach ($parts as $part) {
            if (strpos($part, '}') !== false) {
                $subPart = explode('}', $part);
                $result .= $this->extractAttributeValue($subPart[0]);
                $result .= $subPart[1];
            } else {
                $result .= $part;
            }
        }

        return $result;
    }

    protected function extractAttributeValue($attribute) {
        return ArrayHelper::getValue($this, $attribute);
    }
}