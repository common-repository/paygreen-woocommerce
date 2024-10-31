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
 * Smarty Method AssignByRef
 *
 * Smarty::assignByRef() method
 *
 * @package    Smarty
 * @subpackage PluginsInternal
 * @author     Uwe Tews
 */
class Smarty_Internal_Method_AssignByRef
{
    /**
     * assigns values to template variables by reference
     *
     * @param \Smarty_Internal_Data|\Smarty_Internal_Template|\Smarty $data
     * @param string                                                  $tpl_var the template variable name
     * @param                                                         $value
     * @param boolean                                                 $nocache if true any output of this variable will
     *                                                                         be not cached
     *
     * @return \Smarty_Internal_Data|\Smarty_Internal_Template|\Smarty
     */
    public function assignByRef(Smarty_Internal_Data $data, $tpl_var, &$value, $nocache)
    {
        if ($tpl_var !== '') {
            $data->tpl_vars[ $tpl_var ] = new Smarty_Variable(null, $nocache);
            $data->tpl_vars[ $tpl_var ]->value = &$value;
            if ($data->_isTplObj() && $data->scope) {
                $data->ext->_updateScope->_updateScope($data, $tpl_var);
            }
        }
        return $data;
    }
}
