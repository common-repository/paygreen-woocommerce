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
 * Smarty Method CreateData
 *
 * Smarty::createData() method
 *
 * @package    Smarty
 * @subpackage PluginsInternal
 * @author     Uwe Tews
 */
class Smarty_Internal_Method_CreateData
{
    /**
     * Valid for Smarty and template object
     *
     * @var int
     */
    public $objMap = 3;

    /**
     * creates a data object
     *
     * @api  Smarty::createData()
     * @link http://www.smarty.net/docs/en/api.create.data.tpl
     *
     * @param \Smarty_Internal_TemplateBase|\Smarty_Internal_Template|\Smarty      $obj
     * @param \Smarty_Internal_Template|\Smarty_Internal_Data|\Smarty_Data|\Smarty $parent next higher level of Smarty
     *                                                                                     variables
     * @param string                                                               $name   optional data block name
     *
     * @return \Smarty_Data data object
     */
    public function createData(Smarty_Internal_TemplateBase $obj, Smarty_Internal_Data $parent = null, $name = null)
    {
        /* @var Smarty $smarty */
        $smarty = $obj->_getSmartyObj();
        $dataObj = new Smarty_Data($parent, $smarty, $name);
        if ($smarty->debugging) {
            Smarty_Internal_Debug::register_data($dataObj);
        }
        return $dataObj;
    }
}
