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
 * Smarty Method GetRegisteredObject
 *
 * Smarty::getRegisteredObject() method
 *
 * @package    Smarty
 * @subpackage PluginsInternal
 * @author     Uwe Tews
 */
class Smarty_Internal_Method_GetRegisteredObject
{
    /**
     * Valid for Smarty and template object
     *
     * @var int
     */
    public $objMap = 3;

    /**
     * return a reference to a registered object
     *
     * @api  Smarty::getRegisteredObject()
     * @link http://www.smarty.net/docs/en/api.get.registered.object.tpl
     *
     * @param \Smarty_Internal_TemplateBase|\Smarty_Internal_Template|\Smarty $obj
     * @param string                                                          $object_name object name
     *
     * @return object
     * @throws \SmartyException if no such object is found
     */
    public function getRegisteredObject(Smarty_Internal_TemplateBase $obj, $object_name)
    {
        $smarty = $obj->_getSmartyObj();
        if (!isset($smarty->registered_objects[ $object_name ])) {
            throw new SmartyException("'$object_name' is not a registered object");
        }
        if (!is_object($smarty->registered_objects[ $object_name ][ 0 ])) {
            throw new SmartyException("registered '$object_name' is not an object");
        }
        return $smarty->registered_objects[ $object_name ][ 0 ];
    }
}
