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

namespace PGI\Module\PGForm\Services\Views\Fields;

use PGI\Module\PGForm\Foundations\Fields\AbstractChoiceField;
use Exception;

/**
 * Class ChoiceExpandedFieldView
 * @package PGForm\Services\Views\Fields
 */
class ChoiceExpandedFieldView extends AbstractChoiceField
{
    public function getData()
    {
        $data = parent::getData();

        if (!array_key_exists('choices', $data)) {
            throw new Exception("FieldChoiceExpandedView require 'choices' configuration key.");
        } elseif (is_string($data['choices'])) {
            $data['choices'] = $this->getSelectHandler()->getChoices($data['choices']);
        }

        if ($data['translate']) {
            array_walk($data['choices'], array($this, 'translate'));
            $data['translate'] = false;
        }

        return $data;
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    protected function completeFieldAttributes(array $data)
    {
        $attr = array_key_exists('attr', $data) ? $data['attr'] : array();

        if ($data['multiple']) {
            $attr['name'] = $this->getField()->getFormName() . '[]';
            $attr['type'] = 'checkbox';
        } else {
            $attr['name'] = $this->getField()->getFormName();
            $attr['type'] = 'radio';
        }

        if ($this->getField()->isRequired()) {
            $attr['required'] = 'required';
        }

        return $attr;
    }
}
