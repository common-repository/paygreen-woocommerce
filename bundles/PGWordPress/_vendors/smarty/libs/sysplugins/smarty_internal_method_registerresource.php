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
 * Smarty Method RegisterResource
 *
 * Smarty::registerResource() method
 *
 * @package    Smarty
 * @subpackage PluginsInternal
 * @author     Uwe Tews
 */
class Smarty_Internal_Method_RegisterResource
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
     * @api  Smarty::registerResource()
     * @link http://www.smarty.net/docs/en/api.register.resource.tpl
     *
     * @param \Smarty_Internal_TemplateBase|\Smarty_Internal_Template|\Smarty $obj
     * @param string                                                          $name             name of resource type
     * @param Smarty_Resource|array                                           $resource_handler or instance of
     *                                                                                          Smarty_Resource,
     *                                                                                          or array of
     *                                                                                          callbacks to
     *                                                                                          handle
     *                                                                                          resource
     *                                                                                          (deprecated)
     *
     * @return \Smarty|\Smarty_Internal_Template
     */
    public function registerResource(Smarty_Internal_TemplateBase $obj, $name, $resource_handler)
    {
        $smarty = $obj->_getSmartyObj();
        $smarty->registered_resources[ $name ] =
            $resource_handler instanceof Smarty_Resource ? $resource_handler : array($resource_handler, false);
        return $obj;
    }
}
