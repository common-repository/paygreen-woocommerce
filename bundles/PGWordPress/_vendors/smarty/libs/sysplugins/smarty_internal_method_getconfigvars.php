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
 * Smarty Method GetConfigVars
 *
 * Smarty::getConfigVars() method
 *
 * @package    Smarty
 * @subpackage PluginsInternal
 * @author     Uwe Tews
 */
class Smarty_Internal_Method_GetConfigVars
{
    /**
     * Valid for all objects
     *
     * @var int
     */
    public $objMap = 7;

    /**
     * Returns a single or all config variables
     *
     * @api  Smarty::getConfigVars()
     * @link http://www.smarty.net/docs/en/api.get.config.vars.tpl
     *
     * @param \Smarty_Internal_Data|\Smarty_Internal_Template|\Smarty $data
     * @param string                                                  $varname        variable name or null
     * @param bool                                                    $search_parents include parent templates?
     *
     * @return mixed variable value or or array of variables
     */
    public function getConfigVars(Smarty_Internal_Data $data, $varname = null, $search_parents = true)
    {
        $_ptr = $data;
        $var_array = array();
        while ($_ptr !== null) {
            if (isset($varname)) {
                if (isset($_ptr->config_vars[ $varname ])) {
                    return $_ptr->config_vars[ $varname ];
                }
            } else {
                $var_array = array_merge($_ptr->config_vars, $var_array);
            }
            // not found, try at parent
            if ($search_parents) {
                $_ptr = $_ptr->parent;
            } else {
                $_ptr = null;
            }
        }
        if (isset($varname)) {
            return '';
        } else {
            return $var_array;
        }
    }
}
