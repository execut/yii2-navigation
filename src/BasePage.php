<?php
/**
 * @link https://github.com/execut
 * @copyright Copyright (c) 2020 Mamaev Yuriy (eXeCUT)
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace execut\navigation;

/**
 * Interface BasePage for pages of navigation
 *
 * @package execut\navigation
 * @author Mamaev Yuriy (eXeCUT)
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
     * @see Url::to()
     */
    public function getUrl();

    /**
     * Returned name for menu item
     * @return string|null
     */
    public function getName();

    /**
     * Returns header h1
     * @return string|null
     */
    public function getHeader();

    /**
     * Returns page text html content
     * @return string|null
     */
    public function getText();

    /**
     * Returns description tag content
     * @return string|null
     */
    public function getDescription();

    /**
     * Returns title tag content
     * @return string|null
     */
    public function getTitle();

    /**
     * Returns parent page if it exists
     * @return self
     */
    public function getParentPage();

    /**
     * Set parent page
     * @param self|array $page Parent page
     */
    public function setParentPage($page);

    /**
     * Returns true if the page does not need to be indexed by search engines, otherwise false
     * @return boolean
     */
    public function getNoIndex();

    /**
     * @return string|null Page modification time in format Y-m-d H:i:s
     */
    public function getTime();
}