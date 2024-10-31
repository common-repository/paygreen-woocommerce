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
 * Smarty Method CompileAllConfig
 *
 * Smarty::compileAllConfig() method
 *
 * @package    Smarty
 * @subpackage PluginsInternal
 * @author     Uwe Tews
 */
class Smarty_Internal_Method_CompileAllConfig extends Smarty_Internal_Method_CompileAllTemplates
{
    /**
     * Compile all config files
     *
     * @api Smarty::compileAllConfig()
     *
     * @param \Smarty $smarty        passed smarty object
     * @param string  $extension     file extension
     * @param bool    $force_compile force all to recompile
     * @param int     $time_limit
     * @param int     $max_errors
     *
     * @return int number of template files recompiled
     */
    public function compileAllConfig(
        Smarty $smarty,
        $extension = '.conf',
        $force_compile = false,
        $time_limit = 0,
        $max_errors = null
    ) {
        return $this->compileAll($smarty, $extension, $force_compile, $time_limit, $max_errors, true);
    }
}
