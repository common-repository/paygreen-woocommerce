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

namespace PGI\Module\PGForm\Foundations;

use PGI\Module\PGForm\Foundations\AbstractElement;
use PGI\Module\PGForm\Interfaces\Fields\BasicFieldInterface;
use PGI\Module\PGForm\Interfaces\FormInterface;
use PGI\Module\PGForm\Interfaces\Views\FormViewInterface;
use PGI\Module\PGView\Interfaces\ViewInterface;
use ArrayAccess;
use Exception;

/**
 * Class AbstractForm
 * @package PGForm\Foundations
 */
abstract class AbstractForm extends AbstractElement implements ArrayAccess, FormInterface
{
    /** @var BasicFieldInterface[] */
    private $fields = array();

    private $bin;

    public function __construct($name, array $config, array $fields)
    {
        parent::__construct($name, $config);

        $this->fields = $fields;
    }

    /**
     * @inheritDoc
     */
    public function getKeys()
    {
        return array_keys($this->fields);
    }

    /**
     * @inheritDoc
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @inheritDoc
     */
    public function addField($name, BasicFieldInterface $field)
    {
        $this->fields[$name] = $field;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getField($name)
    {
        if (!$this->hasField($name)) {
            throw new Exception("Unknown form field : $name.");
        }

        return $this->fields[$name];
    }

    /**
     * @inheritDoc
     */
    public function getValue($name)
    {
        if (!$this->hasField($name)) {
            throw new Exception("Unknown form field : $name.");
        }

        return $this->fields[$name]->getValue();
    }

    /**
     * @inheritDoc
     */
    public function setValue($name, $value)
    {
        if (!$this->hasField($name)) {
            throw new Exception("Unknown form field : $name.");
        }

        $this->fields[$name]->setValue($value);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setValues(array $values)
    {
        foreach ($values as $name => $value) {
            if ($this->hasField($name)) {
                $this->setValue($name, $value);
            }
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getValues()
    {
        $values = array();

        foreach ($this->fields as $name => $field) {
            $values[$name] = $field->getValue();
        }

        return $values;
    }

    /**
     * @inheritDoc
     */
    public function isValid()
    {
        foreach ($this->fields as $field) {
            if (!$field->isValid()) {
                return false;
            }
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function getErrors()
    {
        $errors = $this->getRootErrors();

        foreach ($this->fields as $field) {
            $errors = array_merge($errors, $field->getErrors());
        }

        return $errors;
    }

    /**
     * @inheritDoc
     * @todo Gérer les erreurs au niveau formulaire.
     */
    public function getRootErrors()
    {
        return array();
    }

    /**
     * @inheritDoc
     */
    public function hasField($name)
    {
        return array_key_exists($name, $this->fields);
    }

    /**
     * @return ViewInterface
     * @throws Exception
     */
    public function buildView()
    {
        /** @var FormViewInterface $view */
        $view = parent::buildView();

        if (!$view instanceof FormViewInterface) {
            $details = "View must implements FormViewInterface.";
            throw new Exception(
                "Invalid view for current form : '{$this->getName()}'. $details"
            );
        }

        return $view->setForm($this);
    }

    #[\ReturnTypeWillChange]
    public function offsetGet($offset)
    {
        return $this->getValue($offset);
    }

    #[\ReturnTypeWillChange]
    public function offsetSet($offset, $value)
    {
        $this->setValue($offset, $value);
    }

    #[\ReturnTypeWillChange]
    public function offsetUnset($offset)
    {
        // Thrashing unused arguments
        $this->bin = $offset;

        throw new Exception("Unable to remove form field.");
    }

    #[\ReturnTypeWillChange]
    public function offsetExists($offset)
    {
        return $this->hasField($offset);
    }
}
