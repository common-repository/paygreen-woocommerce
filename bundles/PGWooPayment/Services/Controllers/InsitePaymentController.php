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

namespace PGI\Module\PGWooPayment\Services\Controllers;

use PGI\Module\APIPayment\Components\Response as ResponseComponent;
use PGI\Module\APIPayment\Exceptions\Payment as PaymentException;
use PGI\Module\FOPayment\Services\Controllers\PaymentController;
use PGI\Module\PGClient\Exceptions\Response as ResponseException;
use PGI\Module\PGPayment\Interfaces\Entities\ButtonEntityInterface;
use PGI\Module\PGServer\Components\Responses\Forward as ForwardResponseComponent;
use PGI\Module\PGServer\Components\Responses\Template as TemplateResponseComponent;
use PGI\Module\PGShop\Interfaces\Provisioners\PrePaymentProvisionerInterface;
use PGI\Module\PGWooCommerce\Components\Provisioners\PrePayment as PrePaymentProvisionerComponent;
use Exception;

class InsitePaymentController extends PaymentController
{
    /**
     * @return ForwardResponseComponent|TemplateResponseComponent
     * @throws Exception
     */
    public function displayAction()
    {
        try {
            /** @var ButtonEntityInterface $button */
            $button = $this->retrieveButtonFromRequest();

            $url = $this->buildPaymentUrl($button);

            $this->getLogger()->notice("Display insite payment form.");
            $this->getLogger()->debug("Payment URL generated : " . $url);

            return $this->buildIFramePaymentResponse($button, $url);
        } catch (Exception $exception) {
            $this->getLogger()->error("Create payment error : " . $exception->getMessage(), $exception);

            return $this->forward('displayNotification@front.notification', array(
                'title' => 'frontoffice.payment.errors.iframe.title',
                'message' => 'frontoffice.payment.errors.iframe.message',
                'exceptions' => array($exception)
            ));
        }
    }

    /**
     * @param ButtonEntityInterface $button
     * @return string
     * @throws PaymentException
     * @throws ResponseException
     * @throws Exception
     */
    public function buildPaymentUrl(ButtonEntityInterface $button)
    {
        $id_order = $this->getRequest()->get('id_order');

        /** @var PrePaymentProvisionerInterface $prePaymentProvisioner */
        $prePaymentProvisioner = new PrePaymentProvisionerComponent($id_order);

        /** @var ResponseComponent $response */
        $response = $this->paymentCreationHandler->createPayment($prePaymentProvisioner, $button, array(
            'returned_url' => $this->paymentCreationHandler->buildCustomerEntrypointURL(),
            'notified_url' => $this->paymentCreationHandler->buildIPNEntrypointURL()
        ));

        if (!$response->isSuccess()) {
            throw new Exception("Unable to create payment data.");
        }

        return $response->data->url;
    }
}
