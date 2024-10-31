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

namespace PGI\Module\PGForm\Services\Builders;

use PGI\Module\PGForm\Components\Form as FormComponent;
use PGI\Module\PGForm\Interfaces\Fields\BasicFieldInterface;
use PGI\Module\PGForm\Interfaces\FormInterface;
use PGI\Module\PGForm\Services\Builders\FieldBuilder;
use PGI\Module\PGFramework\Components\Aggregator as AggregatorComponent;
use PGI\Module\PGLog\Interfaces\LoggerInterface;
use PGI\Module\PGSystem\Tools\Collection as CollectionTool;
use Exception;

/**
 * Class FormBuilder
 * @package PGForm\Services\Builders
 */
class FormBuilder
{
    /** @var FieldBuilder */
    private $fieldBuilder;

    /** @var LoggerInterface */
    private $logger;

    /** @var AggregatorComponent */
    private $viewAggregator;

    private $config;

    public function __construct(
        FieldBuilder $fieldBuilder,
        LoggerInterface $logger,
        AggregatorComponent $viewAggregator,
        array $config
    ) {
        $this->fieldBuilder = $fieldBuilder;
        $this->logger = $logger;
        $this->viewAggregator = $viewAggregator;
        $this->config = $config;
    }

    /**
     * @param string $name
     * @param array $values
     * @return FormInterface
     * @throws Exception
     */
    public function build($name, array $values = array())
    {
        $form = $this->buildForm($name);

        $form->setValues($values);

        return $form;
    }

    /**
     * @param string $name
     * @return FormInterface
     * @throws Exception
     */
    public function buildForm($name)
    {
        $this->logger->debug("Build form : '$name'.");

        $formConfig = $this->buildFormDefinition($name);

        /** @var BasicFieldInterface[] $fields */
        $fields = $this->buildFields($formConfig);

        $form = new FormComponent($name, $formConfig, $fields);

        $form->setViewAggregator($this->viewAggregator);

        return $form;
    }

    protected function buildFormDefinition($name)
    {
        if (!array_key_exists($name, $this->config['definitions'])) {
            throw new Exception("Unknown form name : '$name'.");
        }

        $config = $this->config['definitions'][$name];

        $formConfig = $this->config['default'];

        if (array_key_exists('extends', $config)) {
            $parent = $config['extends'];
            $parentConfig = $this->buildFormDefinition($parent);

            CollectionTool::merge($formConfig, $parentConfig);
        } elseif (array_key_exists('model', $config)) {
            $model = $config['model'];

            if (!array_key_exists($model, $this->config['models'])) {
                throw new Exception("Form model '$model' not found.");
            }

            CollectionTool::merge($formConfig, $this->config['models'][$model]);
        }

        CollectionTool::merge($formConfig, $config);

        return $formConfig;
    }

    protected function buildFields(array $formDefinition)
    {
        if (!array_key_exists('fields', $formDefinition)) {
            throw new Exception("Field list not found in form definition.");
        }

        /** @var BasicFieldInterface[] $fields */
        $fields = array();

        foreach ($formDefinition['fields'] as $fieldName => $fieldConfig) {
            $field = $this->fieldBuilder->build($fieldName, $fieldConfig);

            if ($field !== null) {
                $fields[$fieldName] = $field;
            }
        }

        return $fields;
    }
}
