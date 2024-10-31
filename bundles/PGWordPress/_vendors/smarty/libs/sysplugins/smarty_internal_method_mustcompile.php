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
 * Smarty Method MustCompile
 *
 * Smarty_Internal_Template::mustCompile() method
 *
 * @package    Smarty
 * @subpackage PluginsInternal
 * @author     Uwe Tews
 */
class Smarty_Internal_Method_MustCompile
{
    /**
     * Valid for template object
     *
     * @var int
     */
    public $objMap = 2;

    /**
     * Returns if the current template must be compiled by the Smarty compiler
     * It does compare the timestamps of template source and the compiled templates and checks the force compile
     * configuration
     *
     * @param \Smarty_Internal_Template $_template
     *
     * @return bool
     * @throws \SmartyException
     */
    public function mustCompile(Smarty_Internal_Template $_template)
    {
        if (!$_template->source->exists) {
            if ($_template->_isSubTpl()) {
                $parent_resource = " in '$_template->parent->template_resource}'";
            } else {
                $parent_resource = '';
            }
            throw new SmartyException("Unable to load template {$_template->source->type} '{$_template->source->name}'{$parent_resource}");
        }
        if ($_template->mustCompile === null) {
            $_template->mustCompile = (!$_template->source->handler->uncompiled &&
                                       ($_template->smarty->force_compile || $_template->source->handler->recompiled ||
                                        !$_template->compiled->exists || ($_template->compile_check &&
                                                                          $_template->compiled->getTimeStamp() <
                                                                          $_template->source->getTimeStamp())));
        }
        return $_template->mustCompile;
    }
}
