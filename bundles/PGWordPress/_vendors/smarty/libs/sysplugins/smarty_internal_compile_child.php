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
 * This file is part of Smarty.
 *
 * (c) 2015 Uwe Tews
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Smarty Internal Plugin Compile Child Class
 *
 * @author Uwe Tews <uwe.tews@googlemail.com>
 */
class Smarty_Internal_Compile_Child extends Smarty_Internal_CompileBase
{
    /**
     * Attribute definition: Overwrites base class.
     *
     * @var array
     * @see Smarty_Internal_CompileBase
     */
    public $optional_attributes = array('assign');

    /**
     * Tag name
     *
     * @var string
     */
    public $tag = 'child';

    /**
     * Block type
     *
     * @var string
     */
    public $blockType = 'Child';

    /**
     * Compiles code for the {child} tag
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
        // check and get attributes
        $_attr = $this->getAttributes($compiler, $args);
        $tag = isset($parameter[ 0 ]) ? "'{$parameter[0]}'" : "'{{$this->tag}}'";
        if (!isset($compiler->_cache[ 'blockNesting' ])) {
            $compiler->trigger_template_error(
                "{$tag} used outside {block} tags ",
                $compiler->parser->lex->taglineno
            );
        }
        $compiler->has_code = true;
        $compiler->suppressNocacheProcessing = true;
        if ($this->blockType === 'Child') {
            $compiler->_cache[ 'blockParams' ][ $compiler->_cache[ 'blockNesting' ] ][ 'callsChild' ] = 'true';
        }
        $_assign = isset($_attr[ 'assign' ]) ? $_attr[ 'assign' ] : null;
        $output = "<?php \n";
        if (isset($_assign)) {
            $output .= "ob_start();\n";
        }
        $output .= '$_smarty_tpl->inheritance->call' . $this->blockType . '($_smarty_tpl, $this' .
                   ($this->blockType === 'Child' ? '' : ", {$tag}") . ");\n";
        if (isset($_assign)) {
            $output .= "\$_smarty_tpl->assign({$_assign}, ob_get_clean());\n";
        }
        $output .= "?>\n";
        return $output;
    }
}
