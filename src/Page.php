<?php
/**
 * @link https://github.com/execut
 * @copyright Copyright (c) 2020 Mamaev Yuriy (eXeCUT)
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace execut\navigation;

use yii\base\Component;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * Simple implementation of navigation page
 *
 * @package execut\navigation
 * @author Mamaev Yuriy (eXeCUT)
 */
class Page extends Component implements BasePage
{
    /**
     * @var null|string Title
     */
    protected $title = null;
    /**
     * @var string|array Array or string of keywords separated by commas
     */
    protected $keywords = [];
    /**
     * @var null|string Description
     */
    protected $description = null;
    /**
     * @var null|string Text
     */
    protected $text = null;
    /**
     * @var null|string Header
     */
    protected $header = null;
    /**
     * @var null|string Page name for menus and breadcrumbs
     */
    protected $name = null;
    /**
     * @var null|string|array Url for \yii\helpers\Url::to()
     * @see Url::to()
     */
    protected $url = null;
    /**
     * @var null|string Page modification time in format Y-m-d H:i:s
     */
    protected $time = null;
    /**
     * @var null|BasePage Parent page instance
     */
    protected $parentPage = null;
    /**
     * @var bool True if the page does not need to be indexed by search engines, otherwise false
     */
    protected $noIndex = false;

    /**
     * @inheritDoc
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
     * @inheritDoc
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set page url for \yii\helpers\Url::to()
     * @param array|string|null $url
     */
    public function setUrl($url)
    {
        if (is_array($url)) {
            $url = Url::to($url);
        }

        $this->url = $url;
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return $this->replaceTemplate($this->name);
    }

    /**
     * Set page name
     * @param $name
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
     * @inheritDoc
     */
    public function getHeader()
    {
        return $this->replaceTemplate($this->header);
    }

    /**
     * Set page header
     * @param $header
     */
    public function setHeader($header)
    {
        $this->header = $header;
    }

    /**
     * @inheritDoc
     */
    public function getText()
    {
        return $this->replaceTemplate($this->text);
    }

    /**
     * Set page text
     * @param $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * @inheritDoc
     */
    public function getDescription()
    {
        return $this->replaceTemplate($this->description);
    }

    /**
     * Set page description value
     * @param $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Set keywords
     * @param array|string $keywords Array or string of keywords separated by commas
     */
    public function setKeywords($keywords)
    {
        if (is_string($keywords)) {
            $keywords = array_map(function ($v) {return trim($v);}, explode(',', $keywords));
        }

        $this->keywords = $keywords;
    }

    /**
     * @inheritDoc
     */
    public function getTitle()
    {
        return $this->replaceTemplate($this->title);
    }

    /**
     * Set page title string
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @inheritDoc
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set page modification time
     * @param string|null $time Time in format Y-m-d H:i:s
     */
    public function setTime($time)
    {
        $this->time = $time;
    }

    /**
     * @inheritDoc
     */
    public function getParentPage()
    {
        return $this->parentPage;
    }

    /**
     * Set parent page
     * @param BasePage|array $page Parent page instance
     * @throws \Exception
     */
    public function setParentPage($page)
    {
        if (is_array($page)) {
            $class = ArrayHelper::getValue($page, 'class', Page::class);
            unset($page['class']);

            $page = new $class($page);
        }
        $this->parentPage = $page;
    }

    /**
     * @inheritDoc
     */
    public function getNoIndex() {
        return $this->noIndex;
    }

    /**
     * Sets whether pages should be indexed
     * @return self
     */
    public function setNoIndex(bool $noIndex) {
        $this->noIndex = $noIndex;
        return $this;
    }

    /**
     * Replaced templates values inside string
     * @param string $template
     * @return string
     */
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

    /**
     * Extracting page param by it name
     * @param $attribute
     * @return mixed|string|null
     */
    protected function extractAttributeValue($attribute) {
        try {
            return ArrayHelper::getValue($this, $attribute);
        } catch (\Exception $e) {
            return '';
        }
    }
}