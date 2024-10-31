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
require_once 'cacheresource.pdo.php';

/**
 * PDO Cache Handler with GZIP support
 * Example usage :
 *      $cnx    =   new PDO("mysql:host=localhost;dbname=mydb", "username", "password");
 *      $smarty->setCachingType('pdo_gzip');
 *      $smarty->loadPlugin('Smarty_CacheResource_Pdo_Gzip');
 *      $smarty->registerCacheResource('pdo_gzip', new Smarty_CacheResource_Pdo_Gzip($cnx, 'smarty_cache'));
 *
 * @require Smarty_CacheResource_Pdo class
 * @author  Beno!t POLASZEK - 2014
 */
class Smarty_CacheResource_Pdo_Gzip extends Smarty_CacheResource_Pdo
{
    /**
     * Encodes the content before saving to database
     *
     * @param string $content
     *
     * @return string $content
     * @access protected
     */
    protected function inputContent($content)
    {
        return gzdeflate($content);
    }

    /**
     * Decodes the content before saving to database
     *
     * @param string $content
     *
     * @return string $content
     * @access protected
     */
    protected function outputContent($content)
    {
        return gzinflate($content);
    }
}
