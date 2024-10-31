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
 * Smarty unescape modifier plugin
 * Type:     modifier
 * Name:     unescape
 * Purpose:  unescape html entities
 *
 * @author Rodney Rehm
 *
 * @param array $params parameters
 *
 * @return string with compiled code
 */
function smarty_modifiercompiler_unescape($params)
{
    if (!isset($params[ 1 ])) {
        $params[ 1 ] = 'html';
    }
    if (!isset($params[ 2 ])) {
        $params[ 2 ] = '\'' . addslashes(Smarty::$_CHARSET) . '\'';
    } else {
        $params[ 2 ] = "'{$params[ 2 ]}'";
    }
    switch (trim($params[ 1 ], '"\'')) {
        case 'entity':
        case 'htmlall':
            if (Smarty::$_MBSTRING) {
                return 'mb_convert_encoding(' . $params[ 0 ] . ', ' . $params[ 2 ] . ', \'HTML-ENTITIES\')';
            }
            return 'html_entity_decode(' . $params[ 0 ] . ', ENT_NOQUOTES, ' . $params[ 2 ] . ')';
        case 'html':
            return 'htmlspecialchars_decode(' . $params[ 0 ] . ', ENT_QUOTES)';
        case 'url':
            return 'rawurldecode(' . $params[ 0 ] . ')';
        default:
            return $params[ 0 ];
    }
}
