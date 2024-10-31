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

namespace PGI\Module\BOModule\Services\Actions;

use PGI\Module\PGForm\Components\Form as FormComponent;
use PGI\Module\PGForm\Services\Builders\FormBuilder;
use PGI\Module\PGFramework\Services\Notifier;
use PGI\Module\PGModule\Services\Settings;
use PGI\Module\PGServer\Foundations\AbstractAction;
use Exception;

/**
 * Class StandardizedSaveSettingsAction
 * @package BOModule\Services\Actions
 */
class StandardizedSaveSettingsAction extends AbstractAction
{
    /** @var FormBuilder */
    protected $formBuilder;

    /** @var Settings */
    protected $settings;

    protected $default = array(
        'success_message' => 'actions.default.save.result.success'
    );

    public function __construct(
        FormBuilder $formBuilder,
        Settings $settings
    ) {
        parent::__construct();

        $this->formBuilder = $formBuilder;
        $this->settings = $settings;
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function process()
    {
        /** @var FormComponent $form */
        $form = $this->formBuilder->build(
            $this->getConfig('form_name'),
            $this->getRequest()->getAll()
        );

        if ($form->isValid()) {
            $this->saveSettings($form);
            $this->setSuccess();
        } else {
            $this->notifyFailure($form);
        }

        $redirectionURI = $this->getLinkHandler()->buildBackOfficeUrl($this->getConfig('redirection'));

        return $this->redirect($redirectionURI);
    }

    /**
     * @param FormComponent $form
     * @throws Exception
     */
    protected function saveSettings(FormComponent $form)
    {
        foreach ($form->getValues() as $key => $value) {
            if ($this->settings->isDefined($key)) {
                $value = trim($value);

                if ($value === null) {
                    $this->getLogger()->debug("Remove setting '$key'.", $value);
                    $this->settings->remove($key);
                } else {
                    $this->getLogger()->debug("Define setting '$key'.", $value);
                    $this->settings->set($key, $value);
                }
            }
        }
    }

    protected function notifyFailure(FormComponent $form)
    {
        foreach ($form->getErrors() as $error) {
            $this->getNotifier()->add(Notifier::STATE_FAILURE, $error);
        }
    }
}
