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

namespace PGI\Module\PGSystem\Foundations;

use PGI\Module\PGSystem\Interfaces\StorageInterface;

/**
 * Class AbstractStorage
 * @package PGSystem\Foundations
 */
abstract class AbstractStorage implements StorageInterface
{
    /** @var array */
    private $data = array();

    /**
     * @inheritDoc
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @inheritDoc
     */
    public function setData(array $data)
    {
        $this->data = $data;

        return $this;
    }

    #[\ReturnTypeWillChange]
    public function offsetGet($offset)
    {
        return isset($this[$offset]) ? $this->data[$offset] : null;
    }

    #[\ReturnTypeWillChange]
    public function offsetSet($offset, $value)
    {
        $this->data[$offset] = $value;

        $this->saveData();
    }

    #[\ReturnTypeWillChange]
    public function offsetUnset($offset)
    {
        unset($this->data[$offset]);

        $this->saveData();
    }

    #[\ReturnTypeWillChange]
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->data);
    }

    #[\ReturnTypeWillChange]
    function rewind() {
        return reset($this->data);
    }

    #[\ReturnTypeWillChange]
    function current() {
        return current($this->data);
    }

    #[\ReturnTypeWillChange]
    function key() {
        return key($this->data);
    }

    #[\ReturnTypeWillChange]
    function next() {
        return next($this->data);
    }

    #[\ReturnTypeWillChange]
    function valid() {
        return !is_null(key($this->data));
    }

    abstract protected function loadData();

    abstract protected function saveData();
}
