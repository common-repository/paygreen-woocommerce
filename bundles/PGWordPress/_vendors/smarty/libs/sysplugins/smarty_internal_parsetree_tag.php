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
 */

/**
 * A complete smarty tag.
 *
 * @package    Smarty
 * @subpackage Compiler
 * @ignore
 */
class Smarty_Internal_ParseTree_Tag extends Smarty_Internal_ParseTree
{
    /**
     * Saved block nesting level
     *
     * @var int
     */
    public $saved_block_nesting;

    /**
     * Create parse tree buffer for Smarty tag
     *
     * @param \Smarty_Internal_Templateparser $parser parser object
     * @param string                          $data   content
     */
    public function __construct(Smarty_Internal_Templateparser $parser, $data)
    {
        $this->data = $data;
        $this->saved_block_nesting = $parser->block_nesting_level;
    }

    /**
     * Return buffer content
     *
     * @param \Smarty_Internal_Templateparser $parser
     *
     * @return string content
     */
    public function to_smarty_php(Smarty_Internal_Templateparser $parser)
    {
        return $this->data;
    }

    /**
     * Return complied code that loads the evaluated output of buffer content into a temporary variable
     *
     * @param \Smarty_Internal_Templateparser $parser
     *
     * @return string template code
     */
    public function assign_to_var(Smarty_Internal_Templateparser $parser)
    {
        $var = $parser->compiler->getNewPrefixVariable();
        $tmp = $parser->compiler->appendCode('<?php ob_start();?>', $this->data);
        $tmp = $parser->compiler->appendCode($tmp, "<?php {$var}=ob_get_clean();?>");
        $parser->compiler->prefix_code[] = sprintf('%s', $tmp);
        return $var;
    }
}
