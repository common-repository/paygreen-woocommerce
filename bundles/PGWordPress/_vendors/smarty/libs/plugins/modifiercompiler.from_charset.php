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
 * @subpackage PluginsModifierCompiler
 */
/**
 * Smarty from_charset modifier plugin
 * Type:     modifier
 * Name:     from_charset
 * Purpose:  convert character encoding from $charset to internal encoding
 *
 * @author Rodney Rehm
 *
 * @param array $params parameters
 *
 * @return string with compiled code
 */
function smarty_modifiercompiler_from_charset($params)
{
    if (!Smarty::$_MBSTRING) {
        // FIXME: (rodneyrehm) shouldn't this throw an error?
        return $params[ 0 ];
    }
    if (!isset($params[ 1 ])) {
        $params[ 1 ] = '"ISO-8859-1"';
    }
    return 'mb_convert_encoding(' . $params[ 0 ] . ', "' . addslashes(Smarty::$_CHARSET) . '", ' . $params[ 1 ] . ')';
}
