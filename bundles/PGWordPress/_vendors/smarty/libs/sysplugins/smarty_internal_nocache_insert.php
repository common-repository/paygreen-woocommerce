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
 * Smarty Internal Plugin Nocache Insert
 * Compiles the {insert} tag into the cache file
 *
 * @package    Smarty
 * @subpackage Compiler
 * @author     Uwe Tews
 */

/**
 * Smarty Internal Plugin Compile Insert Class
 *
 * @package    Smarty
 * @subpackage Compiler
 */
class Smarty_Internal_Nocache_Insert
{
    /**
     * Compiles code for the {insert} tag into cache file
     *
     * @param string                   $_function insert function name
     * @param array                    $_attr     array with parameter
     * @param Smarty_Internal_Template $_template template object
     * @param string                   $_script   script name to load or 'null'
     * @param string                   $_assign   optional variable name
     *
     * @return string                   compiled code
     */
    public static function compile($_function, $_attr, $_template, $_script, $_assign = null)
    {
        $_output = '<?php ';
        if ($_script !== 'null') {
            // script which must be included
            // code for script file loading
            $_output .= "require_once '{$_script}';";
        }
        // call insert
        if (isset($_assign)) {
            $_output .= "\$_smarty_tpl->assign('{$_assign}' , {$_function} (" . var_export($_attr, true) .
                        ',\$_smarty_tpl), true);?>';
        } else {
            $_output .= "echo {$_function}(" . var_export($_attr, true) . ',$_smarty_tpl);?>';
        }
        $_tpl = $_template;
        while ($_tpl->_isSubTpl()) {
            $_tpl = $_tpl->parent;
        }
        return "/*%%SmartyNocache:{$_tpl->compiled->nocache_hash}%%*/{$_output}/*/%%SmartyNocache:{$_tpl->compiled->nocache_hash}%%*/";
    }
}
