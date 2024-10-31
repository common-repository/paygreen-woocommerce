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
 * Smarty Internal Plugin Templateparser Parsetree
 * These are classes to build parsetree in the template parser
 *
 * @package    Smarty
 * @subpackage Compiler
 * @author     Thue Kristensen
 * @author     Uwe Tews
 */

/**
 * @package    Smarty
 * @subpackage Compiler
 * @ignore
 */
abstract class Smarty_Internal_ParseTree
{
    /**
     * Buffer content
     *
     * @var mixed
     */
    public $data;

    /**
     * Subtree array
     *
     * @var array
     */
    public $subtrees = array();

    /**
     * Return buffer
     *
     * @param \Smarty_Internal_Templateparser $parser
     *
     * @return string buffer content
     */
    abstract public function to_smarty_php(Smarty_Internal_Templateparser $parser);

    /**
     * Template data object destructor
     */
    public function __destruct()
    {
        $this->data = null;
        $this->subtrees = null;
    }
}
