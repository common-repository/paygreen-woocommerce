<?php
/**
 * 2014 - 2023 Watt Is It
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT License X11
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/mit-license.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to contact@paygreen.fr so we can send you a copy immediately.
 *
 * @author    PayGreen <contact@paygreen.fr>
 * @copyright 2014 - 2023 Watt Is It
 * @license   https://opensource.org/licenses/mit-license.php MIT License X11
 * @version   4.10.2
 *
 */

/**
 * Smarty Method ClearAllCache
 *
 * Smarty::clearAllCache() method
 *
 * @package    Smarty
 * @subpackage PluginsInternal
 * @author     Uwe Tews
 */
class Smarty_Internal_Method_ClearAllCache
{
    /**
     * Valid for Smarty object
     *
     * @var int
     */
    public $objMap = 1;

    /**
     * Empty cache folder
     *
     * @api  Smarty::clearAllCache()
     * @link http://www.smarty.net/docs/en/api.clear.all.cache.tpl
     *
     * @param \Smarty $smarty
     * @param integer $exp_time expiration time
     * @param string  $type     resource type
     *
     * @return int number of cache files deleted
     * @throws \SmartyException
     */
    public function clearAllCache(Smarty $smarty, $exp_time = null, $type = null)
    {
        $smarty->_clearTemplateCache();
        // load cache resource and call clearAll
        $_cache_resource = Smarty_CacheResource::load($smarty, $type);
        return $_cache_resource->clearAll($smarty, $exp_time);
    }
}
