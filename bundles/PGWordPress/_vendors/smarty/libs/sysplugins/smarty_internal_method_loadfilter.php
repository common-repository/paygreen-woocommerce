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
 * Smarty Method LoadFilter
 *
 * Smarty::loadFilter() method
 *
 * @package    Smarty
 * @subpackage PluginsInternal
 * @author     Uwe Tews
 */
class Smarty_Internal_Method_LoadFilter
{
    /**
     * Valid for Smarty and template object
     *
     * @var int
     */
    public $objMap = 3;

    /**
     * Valid filter types
     *
     * @var array
     */
    private $filterTypes = array('pre' => true, 'post' => true, 'output' => true, 'variable' => true);

    /**
     * load a filter of specified type and name
     *
     * @api  Smarty::loadFilter()
     *
     * @link http://www.smarty.net/docs/en/api.load.filter.tpl
     *
     * @param \Smarty_Internal_TemplateBase|\Smarty_Internal_Template|\Smarty $obj
     * @param string                                                          $type filter type
     * @param string                                                          $name filter name
     *
     * @return bool
     * @throws SmartyException if filter could not be loaded
     */
    public function loadFilter(Smarty_Internal_TemplateBase $obj, $type, $name)
    {
        $smarty = $obj->_getSmartyObj();
        $this->_checkFilterType($type);
        $_plugin = "smarty_{$type}filter_{$name}";
        $_filter_name = $_plugin;
        if (is_callable($_plugin)) {
            $smarty->registered_filters[ $type ][ $_filter_name ] = $_plugin;
            return true;
        }
        if ($smarty->loadPlugin($_plugin)) {
            if (class_exists($_plugin, false)) {
                $_plugin = array($_plugin, 'execute');
            }
            if (is_callable($_plugin)) {
                $smarty->registered_filters[ $type ][ $_filter_name ] = $_plugin;
                return true;
            }
        }
        throw new SmartyException("{$type}filter '{$name}' not found or callable");
    }

    /**
     * Check if filter type is valid
     *
     * @param string $type
     *
     * @throws \SmartyException
     */
    public function _checkFilterType($type)
    {
        if (!isset($this->filterTypes[ $type ])) {
            throw new SmartyException("Illegal filter type '{$type}'");
        }
    }
}
