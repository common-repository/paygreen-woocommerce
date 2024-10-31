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
 * Smarty Method GetConfigVariable
 *
 * Smarty::getConfigVariable() method
 *
 * @package    Smarty
 * @subpackage PluginsInternal
 * @author     Uwe Tews
 */
class Smarty_Internal_Method_GetConfigVariable
{
    /**
     * Valid for all objects
     *
     * @var int
     */
    public $objMap = 7;

    /**
     * gets  a config variable value
     *
     * @param \Smarty|\Smarty_Internal_Data|\Smarty_Internal_Template $data
     * @param string                                                  $varName the name of the config variable
     * @param bool                                                    $errorEnable
     *
     * @return null|string  the value of the config variable
     */
    public function getConfigVariable(Smarty_Internal_Data $data, $varName = null, $errorEnable = true)
    {
        return $data->ext->configLoad->_getConfigVariable($data, $varName, $errorEnable);
    }
}
