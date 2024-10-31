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

namespace PGI\Module\PGPayment\Services\ChainLinks;

use PGI\Module\PGPayment\Components\PaymentProject as PaymentProjectComponent;
use PGI\Module\PGPayment\Foundations\AbstractPaymentCreationChainLink;
use Exception;

/**
 * Class AddCustomerDataChainLink
 * @package PGPayment\Services\ChainLinks
 */
class AddCustomerDataChainLink extends AbstractPaymentCreationChainLink
{
    /**
     * @inheritDoc
     * @throws Exception
     */
    protected function process(PaymentProjectComponent $paymentProject)
    {
        $id_user = $paymentProject->getPrePaymentProvisionner()->getCustomerId();
        $lastname = $paymentProject->getPrePaymentProvisionner()->getLastName();
        $firstname = $paymentProject->getPrePaymentProvisionner()->getFirstName();

        $paymentProject['buyer'] = array(
            'id' => $id_user ? $id_user : hash('md5', microtime()),
            'lastName' => substr($lastname, 0, 50),
            'firstName' => substr($firstname, 0, 50),
            'email' => $paymentProject->getPrePaymentProvisionner()->getMail(),
            'country' => $paymentProject->getPrePaymentProvisionner()->getCountry()
        );

        $mail = $paymentProject->getPrePaymentProvisionner()->getMail();

        $this->getLogger()->notice("Generating customer data with mail : '$mail'.");
    }
}
