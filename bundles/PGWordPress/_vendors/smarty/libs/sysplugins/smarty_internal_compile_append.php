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
 * Smarty Internal Plugin Compile Append
 * Compiles the {append} tag
 *
 * @package    Smarty
 * @subpackage Compiler
 * @author     Uwe Tews
 */

/**
 * Smarty Internal Plugin Compile Append Class
 *
 * @package    Smarty
 * @subpackage Compiler
 */
class Smarty_Internal_Compile_Append extends Smarty_Internal_Compile_Assign
{
    /**
     * Compiles code for the {append} tag
     *
     * @param array                                 $args      array with attributes from parser
     * @param \Smarty_Internal_TemplateCompilerBase $compiler  compiler object
     * @param array                                 $parameter array with compilation parameter
     *
     * @return string compiled code
     * @throws \SmartyCompilerException
     */
    public function compile($args, Smarty_Internal_TemplateCompilerBase $compiler, $parameter)
    {
        // the following must be assigned at runtime because it will be overwritten in parent class
        $this->required_attributes = array('var', 'value');
        $this->shorttag_order = array('var', 'value');
        $this->optional_attributes = array('scope', 'index');
        $this->mapCache = array();
        // check and get attributes
        $_attr = $this->getAttributes($compiler, $args);
        // map to compile assign attributes
        if (isset($_attr[ 'index' ])) {
            $_params[ 'smarty_internal_index' ] = '[' . $_attr[ 'index' ] . ']';
            unset($_attr[ 'index' ]);
        } else {
            $_params[ 'smarty_internal_index' ] = '[]';
        }
        $_new_attr = array();
        foreach ($_attr as $key => $value) {
            $_new_attr[] = array($key => $value);
        }
        // call compile assign
        return parent::compile($_new_attr, $compiler, $_params);
    }
}
