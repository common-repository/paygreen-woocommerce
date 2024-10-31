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
 * Smarty Method GetGlobal
 *
 * Smarty::getGlobal() method
 *
 * @package    Smarty
 * @subpackage PluginsInternal
 * @author     Uwe Tews
 */
class Smarty_Internal_Method_GetGlobal
{
    /**
     * Valid for all objects
     *
     * @var int
     */
    public $objMap = 7;

    /**
     * Returns a single or all global  variables
     *
     * @api Smarty::getGlobal()
     *
     * @param \Smarty_Internal_Data $data
     * @param string                $varName variable name or null
     *
     * @return string|array variable value or or array of variables
     */
    public function getGlobal(Smarty_Internal_Data $data, $varName = null)
    {
        if (isset($varName)) {
            if (isset(Smarty::$global_tpl_vars[ $varName ])) {
                return Smarty::$global_tpl_vars[ $varName ]->value;
            } else {
                return '';
            }
        } else {
            $_result = array();
            foreach (Smarty::$global_tpl_vars as $key => $var) {
                $_result[ $key ] = $var->value;
            }
            return $_result;
        }
    }
}
