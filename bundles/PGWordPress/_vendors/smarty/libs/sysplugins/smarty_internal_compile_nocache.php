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
 * Smarty Internal Plugin Compile Nocache
 * Compiles the {nocache} {/nocache} tags.
 *
 * @package    Smarty
 * @subpackage Compiler
 * @author     Uwe Tews
 */

/**
 * Smarty Internal Plugin Compile Nocache Class
 *
 * @package    Smarty
 * @subpackage Compiler
 */
class Smarty_Internal_Compile_Nocache extends Smarty_Internal_CompileBase
{
    /**
     * Array of names of valid option flags
     *
     * @var array
     */
    public $option_flags = array();

    /**
     * Compiles code for the {nocache} tag
     * This tag does not generate compiled output. It only sets a compiler flag.
     *
     * @param array                                 $args     array with attributes from parser
     * @param \Smarty_Internal_TemplateCompilerBase $compiler compiler object
     *
     * @return bool
     */
    public function compile($args, Smarty_Internal_TemplateCompilerBase $compiler)
    {
        $_attr = $this->getAttributes($compiler, $args);
        $this->openTag($compiler, 'nocache', array($compiler->nocache));
        // enter nocache mode
        $compiler->nocache = true;
        // this tag does not return compiled code
        $compiler->has_code = false;
        return true;
    }
}

/**
 * Smarty Internal Plugin Compile Nocacheclose Class
 *
 * @package    Smarty
 * @subpackage Compiler
 */
class Smarty_Internal_Compile_Nocacheclose extends Smarty_Internal_CompileBase
{
    /**
     * Compiles code for the {/nocache} tag
     * This tag does not generate compiled output. It only sets a compiler flag.
     *
     * @param array                                 $args     array with attributes from parser
     * @param \Smarty_Internal_TemplateCompilerBase $compiler compiler object
     *
     * @return bool
     */
    public function compile($args, Smarty_Internal_TemplateCompilerBase $compiler)
    {
        $_attr = $this->getAttributes($compiler, $args);
        // leave nocache mode
        list($compiler->nocache) = $this->closeTag($compiler, array('nocache'));
        // this tag does not return compiled code
        $compiler->has_code = false;
        return true;
    }
}
