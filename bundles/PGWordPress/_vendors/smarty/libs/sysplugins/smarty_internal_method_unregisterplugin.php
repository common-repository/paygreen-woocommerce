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
 * Smarty Method UnregisterPlugin
 *
 * Smarty::unregisterPlugin() method
 *
 * @package    Smarty
 * @subpackage PluginsInternal
 * @author     Uwe Tews
 */
class Smarty_Internal_Method_UnregisterPlugin
{
    /**
     * Valid for Smarty and template object
     *
     * @var int
     */
    public $objMap = 3;

    /**
     * Registers plugin to be used in templates
     *
     * @api  Smarty::unregisterPlugin()
     * @link http://www.smarty.net/docs/en/api.unregister.plugin.tpl
     *
     * @param \Smarty_Internal_TemplateBase|\Smarty_Internal_Template|\Smarty $obj
     * @param string                                                          $type plugin type
     * @param string                                                          $name name of template tag
     *
     * @return \Smarty|\Smarty_Internal_Template
     */
    public function unregisterPlugin(Smarty_Internal_TemplateBase $obj, $type, $name)
    {
        $smarty = $obj->_getSmartyObj();
        if (isset($smarty->registered_plugins[ $type ][ $name ])) {
            unset($smarty->registered_plugins[ $type ][ $name ]);
        }
        return $obj;
    }
}
