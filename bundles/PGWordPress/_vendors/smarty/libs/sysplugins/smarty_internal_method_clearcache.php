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
 * Smarty Method ClearCache
 *
 * Smarty::clearCache() method
 *
 * @package    Smarty
 * @subpackage PluginsInternal
 * @author     Uwe Tews
 */
class Smarty_Internal_Method_ClearCache
{
    /**
     * Valid for Smarty object
     *
     * @var int
     */
    public $objMap = 1;

    /**
     * Empty cache for a specific template
     *
     * @api  Smarty::clearCache()
     * @link http://www.smarty.net/docs/en/api.clear.cache.tpl
     *
     * @param \Smarty $smarty
     * @param string  $template_name template name
     * @param string  $cache_id      cache id
     * @param string  $compile_id    compile id
     * @param integer $exp_time      expiration time
     * @param string  $type          resource type
     *
     * @return int number of cache files deleted
     * @throws \SmartyException
     */
    public function clearCache(
        Smarty $smarty,
        $template_name,
        $cache_id = null,
        $compile_id = null,
        $exp_time = null,
        $type = null
    ) {
        $smarty->_clearTemplateCache();
        // load cache resource and call clear
        $_cache_resource = Smarty_CacheResource::load($smarty, $type);
        return $_cache_resource->clear($smarty, $template_name, $cache_id, $compile_id, $exp_time);
    }
}
