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
 * Smarty Internal Plugin Compile Setfilter
 * Compiles code for setfilter tag
 *
 * @package    Smarty
 * @subpackage Compiler
 * @author     Uwe Tews
 */

/**
 * Smarty Internal Plugin Compile Setfilter Class
 *
 * @package    Smarty
 * @subpackage Compiler
 */
class Smarty_Internal_Compile_Setfilter extends Smarty_Internal_CompileBase
{
    /**
     * Compiles code for setfilter tag
     *
     * @param array                                 $args      array with attributes from parser
     * @param \Smarty_Internal_TemplateCompilerBase $compiler  compiler object
     * @param array                                 $parameter array with compilation parameter
     *
     * @return string compiled code
     */
    public function compile($args, Smarty_Internal_TemplateCompilerBase $compiler, $parameter)
    {
        $compiler->variable_filter_stack[] = $compiler->variable_filters;
        $compiler->variable_filters = $parameter[ 'modifier_list' ];
        // this tag does not return compiled code
        $compiler->has_code = false;
        return true;
    }
}

/**
 * Smarty Internal Plugin Compile Setfilterclose Class
 *
 * @package    Smarty
 * @subpackage Compiler
 */
class Smarty_Internal_Compile_Setfilterclose extends Smarty_Internal_CompileBase
{
    /**
     * Compiles code for the {/setfilter} tag
     * This tag does not generate compiled output. It resets variable filter.
     *
     * @param array                                 $args     array with attributes from parser
     * @param \Smarty_Internal_TemplateCompilerBase $compiler compiler object
     *
     * @return string compiled code
     */
    public function compile($args, Smarty_Internal_TemplateCompilerBase $compiler)
    {
        $_attr = $this->getAttributes($compiler, $args);
        // reset variable filter to previous state
        if (count($compiler->variable_filter_stack)) {
            $compiler->variable_filters = array_pop($compiler->variable_filter_stack);
        } else {
            $compiler->variable_filters = array();
        }
        // this tag does not return compiled code
        $compiler->has_code = false;
        return true;
    }
}
