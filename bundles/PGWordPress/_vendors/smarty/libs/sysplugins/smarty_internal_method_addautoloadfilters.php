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
 * Smarty Method AddAutoloadFilters
 *
 * Smarty::addAutoloadFilters() method
 *
 * @package    Smarty
 * @subpackage PluginsInternal
 * @author     Uwe Tews
 */
class Smarty_Internal_Method_AddAutoloadFilters extends Smarty_Internal_Method_SetAutoloadFilters
{
    /**
     * Add autoload filters
     *
     * @api Smarty::setAutoloadFilters()
     *
     * @param \Smarty_Internal_TemplateBase|\Smarty_Internal_Template|\Smarty $obj
     * @param array                                                           $filters filters to load automatically
     * @param string                                                          $type    "pre", "output", … specify
     *                                                                                 the filter type to set.
     *                                                                                 Defaults to none treating
     *                                                                                 $filters' keys as the
     *                                                                                 appropriate types
     *
     * @return \Smarty|\Smarty_Internal_Template
     * @throws \SmartyException
     */
    public function addAutoloadFilters(Smarty_Internal_TemplateBase $obj, $filters, $type = null)
    {
        $smarty = $obj->_getSmartyObj();
        if ($type !== null) {
            $this->_checkFilterType($type);
            if (!empty($smarty->autoload_filters[ $type ])) {
                $smarty->autoload_filters[ $type ] = array_merge($smarty->autoload_filters[ $type ], (array)$filters);
            } else {
                $smarty->autoload_filters[ $type ] = (array)$filters;
            }
        } else {
            foreach ((array)$filters as $type => $value) {
                $this->_checkFilterType($type);
                if (!empty($smarty->autoload_filters[ $type ])) {
                    $smarty->autoload_filters[ $type ] =
                        array_merge($smarty->autoload_filters[ $type ], (array)$value);
                } else {
                    $smarty->autoload_filters[ $type ] = (array)$value;
                }
            }
        }
        return $obj;
    }
}
