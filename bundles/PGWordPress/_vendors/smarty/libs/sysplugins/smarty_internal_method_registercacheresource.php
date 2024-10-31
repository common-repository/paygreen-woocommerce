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
 * Smarty Method RegisterCacheResource
 *
 * Smarty::registerCacheResource() method
 *
 * @package    Smarty
 * @subpackage PluginsInternal
 * @author     Uwe Tews
 */
class Smarty_Internal_Method_RegisterCacheResource
{
    /**
     * Valid for Smarty and template object
     *
     * @var int
     */
    public $objMap = 3;

    /**
     * Registers a resource to fetch a template
     *
     * @api  Smarty::registerCacheResource()
     * @link http://www.smarty.net/docs/en/api.register.cacheresource.tpl
     *
     * @param \Smarty_Internal_TemplateBase|\Smarty_Internal_Template|\Smarty $obj
     * @param string                                                          $name name of resource type
     * @param \Smarty_CacheResource                                           $resource_handler
     *
     * @return \Smarty|\Smarty_Internal_Template
     */
    public function registerCacheResource(
        Smarty_Internal_TemplateBase $obj,
        $name,
        Smarty_CacheResource $resource_handler
    ) {
        $smarty = $obj->_getSmartyObj();
        $smarty->registered_cache_resources[ $name ] = $resource_handler;
        return $obj;
    }
}
