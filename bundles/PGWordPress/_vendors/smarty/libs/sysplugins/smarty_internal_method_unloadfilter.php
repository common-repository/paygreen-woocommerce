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
 * Smarty Method UnloadFilter
 *
 * Smarty::unloadFilter() method
 *
 * @package    Smarty
 * @subpackage PluginsInternal
 * @author     Uwe Tews
 */
class Smarty_Internal_Method_UnloadFilter extends Smarty_Internal_Method_LoadFilter
{
    /**
     * load a filter of specified type and name
     *
     * @api  Smarty::unloadFilter()
     *
     * @link http://www.smarty.net/docs/en/api.unload.filter.tpl
     *
     * @param \Smarty_Internal_TemplateBase|\Smarty_Internal_Template|\Smarty $obj
     * @param string                                                          $type filter type
     * @param string                                                          $name filter name
     *
     * @return Smarty_Internal_TemplateBase
     * @throws \SmartyException
     */
    public function unloadFilter(Smarty_Internal_TemplateBase $obj, $type, $name)
    {
        $smarty = $obj->_getSmartyObj();
        $this->_checkFilterType($type);
        if (isset($smarty->registered_filters[ $type ])) {
            $_filter_name = "smarty_{$type}filter_{$name}";
            if (isset($smarty->registered_filters[ $type ][ $_filter_name ])) {
                unset($smarty->registered_filters[ $type ][ $_filter_name ]);
                if (empty($smarty->registered_filters[ $type ])) {
                    unset($smarty->registered_filters[ $type ]);
                }
            }
        }
        return $obj;
    }
}
