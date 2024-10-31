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

namespace PGI\Module\PGFramework\Foundations;

use PGI\Module\PGFramework\Interfaces\SuperglobalInterface;

/**
 * Class AbstractSuperglobal
 * @package PGFramework\Foundations
 */
abstract class AbstractSuperglobal implements SuperglobalInterface
{
    protected $data = array();

    public function __construct(&$superGlobal)
    {
        if (is_array($superGlobal)) {
            $this->data = &$superGlobal;
        }
    }

    public function toArray()
    {
        return $this->data;
    }

    // ###################################################################
    // ###       table access functions
    // ###################################################################

    #[\ReturnTypeWillChange]
    public function offsetGet($name)
    {
        return isset($this[$name]) ? $this->data[$name] : null;
    }

    #[\ReturnTypeWillChange]
    public function offsetExists($name)
    {
        return array_key_exists($name, $this->data);
    }

    #[\ReturnTypeWillChange]
    public function offsetSet($name, $value)
    {
        $this->data[$name] = $value;
    }

    #[\ReturnTypeWillChange]
    public function offsetUnset($name)
    {
        if (isset($this[$name])) {
            unset($this->data[$name]);
        }
    }

    // ###################################################################
    // ###       iterator functions
    // ###################################################################

    #[\ReturnTypeWillChange]
    public function rewind()
    {
        reset($this->data);
    }

    #[\ReturnTypeWillChange]
    public function current()
    {
        return current($this->data);
    }

    #[\ReturnTypeWillChange]
    public function key()
    {
        return key($this->data);
    }

    #[\ReturnTypeWillChange]
    public function next()
    {
        next($this->data);
    }

    #[\ReturnTypeWillChange]
    public function valid()
    {
        return key($this->data) !== null;
    }
}
