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
 * Smarty Method GetTags
 *
 * Smarty::getTags() method
 *
 * @package    Smarty
 * @subpackage PluginsInternal
 * @author     Uwe Tews
 */
class Smarty_Internal_Method_GetTags
{
    /**
     * Valid for Smarty and template object
     *
     * @var int
     */
    public $objMap = 3;

    /**
     * Return array of tag/attributes of all tags used by an template
     *
     * @api  Smarty::getTags()
     * @link http://www.smarty.net/docs/en/api.get.tags.tpl
     *
     * @param \Smarty_Internal_TemplateBase|\Smarty_Internal_Template|\Smarty $obj
     * @param null|string|Smarty_Internal_Template                            $template
     *
     * @return array of tag/attributes
     * @throws \Exception
     * @throws \SmartyException
     */
    public function getTags(Smarty_Internal_TemplateBase $obj, $template = null)
    {
        /* @var Smarty $smarty */
        $smarty = $obj->_getSmartyObj();
        if ($obj->_isTplObj() && !isset($template)) {
            $tpl = clone $obj;
        } elseif (isset($template) && $template->_isTplObj()) {
            $tpl = clone $template;
        } elseif (isset($template) && is_string($template)) {
            /* @var Smarty_Internal_Template $tpl */
            $tpl = new $smarty->template_class($template, $smarty);
            // checks if template exists
            if (!$tpl->source->exists) {
                throw new SmartyException("Unable to load template {$tpl->source->type} '{$tpl->source->name}'");
            }
        }
        if (isset($tpl)) {
            $tpl->smarty = clone $tpl->smarty;
            $tpl->smarty->_cache[ 'get_used_tags' ] = true;
            $tpl->_cache[ 'used_tags' ] = array();
            $tpl->smarty->merge_compiled_includes = false;
            $tpl->smarty->disableSecurity();
            $tpl->caching = Smarty::CACHING_OFF;
            $tpl->loadCompiler();
            $tpl->compiler->compileTemplate($tpl);
            return $tpl->_cache[ 'used_tags' ];
        }
        throw new SmartyException('Missing template specification');
    }
}
