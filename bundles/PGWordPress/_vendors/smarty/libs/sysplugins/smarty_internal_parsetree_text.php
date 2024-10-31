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
 * Smarty Internal Plugin Templateparser Parse Tree
 * These are classes to build parse tree in the template parser
 *
 * @package    Smarty
 * @subpackage Compiler
 * @author     Thue Kristensen
 * @author     Uwe Tews
 *             *
 *             template text
 * @package    Smarty
 * @subpackage Compiler
 * @ignore
 */
class Smarty_Internal_ParseTree_Text extends Smarty_Internal_ParseTree
{

	/**
	 * Wether this section should be stripped on output to smarty php
	 * @var bool
	 */
	private $toBeStripped = false;

	/**
	 * Create template text buffer
	 *
	 * @param string $data text
	 * @param bool $toBeStripped wether this section should be stripped on output to smarty php
	 */
    public function __construct($data, $toBeStripped = false)
    {
        $this->data = $data;
        $this->toBeStripped = $toBeStripped;
    }

	/**
	 * Wether this section should be stripped on output to smarty php
	 * @return bool
	 */
	public function isToBeStripped() {
    	return $this->toBeStripped;
    }

    /**
     * Return buffer content
     *
     * @param \Smarty_Internal_Templateparser $parser
     *
     * @return string text
     */
    public function to_smarty_php(Smarty_Internal_Templateparser $parser)
    {
        return $this->data;
    }
}
