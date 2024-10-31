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
 * Smarty plugin
 *
 * @package    Smarty
 * @subpackage PluginsShared
 */
/**
 * evaluate compiler parameter
 *
 * @param array   $params  parameter array as given to the compiler function
 * @param integer $index   array index of the parameter to convert
 * @param mixed   $default value to be returned if the parameter is not present
 *
 * @return mixed evaluated value of parameter or $default
 * @throws SmartyException if parameter is not a literal (but an expression, variable, …)
 * @author Rodney Rehm
 */
function smarty_literal_compiler_param($params, $index, $default = null)
{
    // not set, go default
    if (!isset($params[ $index ])) {
        return $default;
    }
    // test if param is a literal
    if (!preg_match('/^([\'"]?)[a-zA-Z0-9-]+(\\1)$/', $params[ $index ])) {
        throw new SmartyException(
            '$param[' . $index .
            '] is not a literal and is thus not evaluatable at compile time'
        );
    }
    $t = null;
    eval("\$t = " . $params[ $index ] . ";");
    return $t;
}
