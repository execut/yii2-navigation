<?php
/**
 * @link https://github.com/execut
 * @copyright Copyright (c) 2020 Yuriy Mamaev (eXeCUT)
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace execut\navigation;

/**
 * Interface BasePage for pages of navigation
 *
 * @package execut\navigation
 * @author Yuriy Mamaev (eXeCUT)
 */
interface BasePage
{
    /**
     * Returns an array or string of keywords separated by commas
     *
     * @return string|array
     */
    public function getKeywords();

    /**
     * Returns url of page
     * @return array|string for \yii\helpers\Url::to()
     */
    public function getUrl();

    /**
     * Returned name for menu item
     * @return string
     */
    public function getName();

    /**
     * Returns header h1
     * @return string
     */
    public function getHeader();

    /**
     * Returns page text html content
     * @return string
     */
    public function getText();

    /**
     * Returns description tag content
     * @return string
     */
    public function getDescription();

    /**
     * Returns title tag content
     * @return null
     */
    public function getTitle();

    /**
     * Returns parent page if it exists
     * @return self
     */
    public function getParentPage();

    /**
     * Set parent page
     * @param self $page Parent page
     */
    public function setParentPage(self $page);

    /**
     * Returns true if the page does not need to be indexed by search engines, otherwise false
     * @return boolean
     */
    public function getNoIndex();

    /**
     * Sets whether pages should be indexed
     * @return boolean True if the page does not need to be indexed by search engines, otherwise false
     */
    public function setNoIndex(boolean $noIndex);
}