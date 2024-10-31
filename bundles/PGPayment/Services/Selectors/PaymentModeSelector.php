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

namespace PGI\Module\PGPayment\Services\Selectors;

use PGI\Module\PGFramework\Foundations\AbstractSelector;
use PGI\Module\PGPayment\Services\Facades\PaygreenFacade;

/**
 * Class PaymentModeSelector
 * @package PGPayment\Services\Selectors
 */
class PaymentModeSelector extends AbstractSelector
{
    /** @var PaygreenFacade */
    private $paygreenFacade;

    /**
     * @param PaygreenFacade $paygreenFacade
     */
    public function setPaygreenFacade(PaygreenFacade $paygreenFacade)
    {
        $this->paygreenFacade = $paygreenFacade;
    }

    /**
     * @return array
     */
    protected function buildChoices()
    {
        $choices = array();

        $codes = $this->paygreenFacade->getAvailablePaymentModes();

        foreach ($codes as $code) {
            $choices[$code] = $this->translate($code);
        }

        return $choices;
    }

    protected function getTranslationRoot()
    {
        return 'data.payment.payment_modes';
    }
}
