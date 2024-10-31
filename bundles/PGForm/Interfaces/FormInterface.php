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

namespace PGI\Module\PGForm\Interfaces;

use PGI\Module\PGForm\Interfaces\ElementInterface;
use PGI\Module\PGForm\Interfaces\Fields\BasicFieldInterface;

/**
 * Interface FormInterface
 * @package PGForm\Interfaces
 */
interface FormInterface extends ElementInterface
{
    /**
     * @return string[]
     */
    public function getKeys();

    /**
     * @return BasicFieldInterface[]
     */
    public function getFields();

    /**
     * @param string $name
     * @param BasicFieldInterface $field
     * @return mixed
     */
    public function addField($name, BasicFieldInterface $field);

    /**
     * @param string $name
     * @return BasicFieldInterface
     */
    public function getField($name);

    /**
     * @param string $name
     * @return mixed
     */
    public function getValue($name);

    /**
     * @param string $name
     * @param mixed $value
     * @return self
     */
    public function setValue($name, $value);

    /**
     * @param array $values
     * @return self
     */
    public function setValues(array $values);

    /**
     * @return mixed[]
     */
    public function getValues();

    /**
     * @param string $name
     * @return bool
     */
    public function hasField($name);
}
