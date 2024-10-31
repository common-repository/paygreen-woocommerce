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
 * Smarty Method GetAutoloadFilters
 *
 * Smarty::getAutoloadFilters() method
 *
 * @package    Smarty
 * @subpackage PluginsInternal
 * @author     Uwe Tews
 */
class Smarty_Internal_Method_GetAutoloadFilters extends Smarty_Internal_Method_SetAutoloadFilters
{
    /**
     * Get autoload filters
     *
     * @api Smarty::getAutoloadFilters()
     *
     * @param \Smarty_Internal_TemplateBase|\Smarty_Internal_Template|\Smarty $obj
     * @param string                                                          $type type of filter to get auto loads
     *                                                                              for. Defaults to all autoload
     *                                                                              filters
     *
     * @return array array( 'type1' => array( 'filter1', 'filter2', … ) ) or array( 'filter1', 'filter2', …) if $type
     *                was specified
     * @throws \SmartyException
     */
    public function getAutoloadFilters(Smarty_Internal_TemplateBase $obj, $type = null)
    {
        $smarty = $obj->_getSmartyObj();
        if ($type !== null) {
            $this->_checkFilterType($type);
            return isset($smarty->autoload_filters[ $type ]) ? $smarty->autoload_filters[ $type ] : array();
        }
        return $smarty->autoload_filters;
    }
}
