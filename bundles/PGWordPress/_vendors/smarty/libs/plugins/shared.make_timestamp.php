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
 * Smarty shared plugin
 *
 * @package    Smarty
 * @subpackage PluginsShared
 */
/**
 * Function: smarty_make_timestamp
 * Purpose:  used by other smarty functions to make a timestamp from a string.
 *
 * @author Monte Ohrt <monte at ohrt dot com>
 *
 * @param DateTime|int|string $string date object, timestamp or string that can be converted using strtotime()
 *
 * @return int
 */
function smarty_make_timestamp($string)
{
    if (empty($string)) {
        // use "now":
        return time();
    } elseif ($string instanceof DateTime
              || (interface_exists('DateTimeInterface', false) && $string instanceof DateTimeInterface)
    ) {
        return (int)$string->format('U'); // PHP 5.2 BC
    } elseif (strlen($string) === 14 && ctype_digit($string)) {
        // it is mysql timestamp format of YYYYMMDDHHMMSS?
        return mktime(
            substr($string, 8, 2),
            substr($string, 10, 2),
            substr($string, 12, 2),
            substr($string, 4, 2),
            substr($string, 6, 2),
            substr($string, 0, 4)
        );
    } elseif (is_numeric($string)) {
        // it is a numeric string, we handle it as timestamp
        return (int)$string;
    } else {
        // strtotime should handle it
        $time = strtotime($string);
        if ($time === -1 || $time === false) {
            // strtotime() was not able to parse $string, use "now":
            return time();
        }
        return $time;
    }
}
