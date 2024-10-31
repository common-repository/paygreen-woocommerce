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

namespace PGI\Module\PGForm\Services\Views;

use PGI\Module\PGForm\Components\Form as FormComponent;
use PGI\Module\PGForm\Foundations\Fields\AbstractBasicField;
use PGI\Module\PGForm\Interfaces\Views\FormViewInterface;
use PGI\Module\PGView\Components\Box as BoxComponent;
use PGI\Module\PGView\Services\View;

/**
 * Class FormView
 * @package PGForm\Services\Views
 */
class FormView extends View implements FormViewInterface
{
    /** @var FormComponent */
    private $form;

    private $action;

    /**
     * @return FormComponent
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * @param FormComponent $form
     * @return self
     */
    public function setForm(FormComponent $form)
    {
        $this->form = $form;

        return $this;
    }

    public function setAction($action)
    {
        $this->action = $action;

        return $this;
    }

    public function getData()
    {
        $data = parent::getData();

        $attr = $this->completeFieldAttributes($data);

        $data['attr'] = $attr;
        $data['errors'] = $this->form->getRootErrors();

        $fieldViews = array();

        /**
         * @var string $key
         * @var AbstractBasicField $field
         */
        foreach ($this->form->getFields() as $key => $field) {
            $fieldViews[$key] = new BoxComponent($field->buildView());
        }

        $data['fields'] = $fieldViews;

        return $data;
    }

    protected function completeFieldAttributes(array $data)
    {
        $attr = array_key_exists('attr', $data) ? $data['attr'] : array();

        $attr['action'] = $this->action;
        $attr['id'] = 'pg_form_' . $this->form->getName();

        return $attr;
    }
}
