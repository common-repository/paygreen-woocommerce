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
 * Smarty Method AssignGlobal
 *
 * Smarty::assignGlobal() method
 *
 * @package    Smarty
 * @subpackage PluginsInternal
 * @author     Uwe Tews
 */
class Smarty_Internal_Method_AssignGlobal
{
    /**
     * Valid for all objects
     *
     * @var int
     */
    public $objMap = 7;

    /**
     * assigns a global Smarty variable
     *
     * @param \Smarty_Internal_Data|\Smarty_Internal_Template|\Smarty $data
     * @param string                                                  $varName the global variable name
     * @param mixed                                                   $value   the value to assign
     * @param boolean                                                 $nocache if true any output of this variable will
     *                                                                         be not cached
     *
     * @return \Smarty_Internal_Data|\Smarty_Internal_Template|\Smarty
     */
    public function assignGlobal(Smarty_Internal_Data $data, $varName, $value = null, $nocache = false)
    {
        if ($varName !== '') {
            Smarty::$global_tpl_vars[ $varName ] = new Smarty_Variable($value, $nocache);
            $ptr = $data;
            while ($ptr->_isTplObj()) {
                $ptr->tpl_vars[ $varName ] = clone Smarty::$global_tpl_vars[ $varName ];
                $ptr = $ptr->parent;
            }
        }
        return $data;
    }
}
