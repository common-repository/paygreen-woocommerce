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

namespace PGI\Module\PGWooPayment\Services\Hooks;

use PGI\Module\APIPayment\Exceptions\Payment as PaymentException;
use PGI\Module\PGClient\Components\Response as ResponseComponent;
use PGI\Module\PGClient\Exceptions\Response as ResponseException;
use PGI\Module\PGModule\Services\Handlers\BehaviorHandler;
use PGI\Module\PGLog\Interfaces\LoggerInterface;
use PGI\Module\PGPayment\Interfaces\Entities\ButtonEntityInterface;
use PGI\Module\PGPayment\Services\Facades\PaygreenFacade;
use PGI\Module\PGPayment\Services\Handlers\PaymentCreationHandler;
use PGI\Module\PGPayment\Services\Managers\ButtonManager;
use PGI\Module\PGServer\Services\Handlers\LinkHandler;
use PGI\Module\PGShop\Interfaces\Provisioners\PrePaymentProvisionerInterface;
use PGI\Module\PGWooCommerce\Components\Provisioners\PrePayment as PrePaymentProvisionerComponent;
use Exception;

class PaymentCreateHook
{
    /** @var PaygreenFacade */
    private $paygreenFacade;

    /** @var PaymentCreationHandler */
    private $paymentCreationHandler;

    /** @var ButtonManager */
    private $buttonManager;

    /** @var LinkHandler */
    private $linkHandler;

    /** @var LoggerInterface */
    private $logger;

    /** @var BehaviorHandler */
    private $behaviorHandler;

    public function __construct(
        PaygreenFacade $paygreenFacade,
        PaymentCreationHandler $paymentCreationHandler,
        ButtonManager $buttonManager,
        LinkHandler $linkHandler,
        LoggerInterface $logger,
        BehaviorHandler $behaviorHandler
    ) {
        $this->paygreenFacade = $paygreenFacade;
        $this->paymentCreationHandler = $paymentCreationHandler;
        $this->buttonManager = $buttonManager;
        $this->linkHandler = $linkHandler;
        $this->logger = $logger;
        $this->behaviorHandler = $behaviorHandler;
    }

    public function process($id_order, $id_button = null)
    {
        try {
            /** @var ButtonEntityInterface $button */
            $button = $this->getButton($id_button);

            $this->logger->info("Begin payment with button #{$button->id()} in mode {$button->getPaymentMode()} and type {$button->getPaymentType()}.");

            $insite = ($this->behaviorHandler->get('behavior_payment_insite') && $this->paygreenFacade->verifyInsiteValidity());

            if ($insite) {
                $url = $this->linkHandler->buildFrontOfficeUrl('front.payment.display.insite.local', array(
                    'id' => $button->id(),
                    'id_order' => $id_order
                ));
                $this->logger->notice("Redirect to insite payment form page.");
            } else {
                $url = $this->buildPaymentUrl($id_order, $button);
                $this->logger->notice("Redirect to PayGreen payment form.");
                $this->logger->debug("Payment URL generated : " . $url);
            }

            $result = array(
                'result' => 'success',
                'redirect' => $url,
            );
        } catch (Exception $exception) {
            $this->logger->error("Validation payment error : " . $exception->getMessage(), $exception);

            $result = array(
                'result' => 'failure',
                'message' => $exception->getMessage()
            );
        }

        return $result;
    }

    /**
     * @return ButtonEntityInterface
     * @throws Exception
     */
    protected function getButton($id_button)
    {
        if (!$id_button) {
            throw new Exception("Payment action require button primary parameter.");
        }

        /** @var ButtonEntityInterface $button */
        $button = $this->buttonManager->getByPrimary($id_button);

        if ($button === null) {
            throw new Exception("Payment button not found.");
        }

        return $button;
    }

    /**
     * @param ButtonEntityInterface $button
     * @return string
     * @throws PaymentException
     * @throws ResponseException
     * @throws Exception
     */
    public function buildPaymentUrl($id_order, ButtonEntityInterface $button)
    {
        /** @var PrePaymentProvisionerInterface $prePaymentProvisioner */
        $prePaymentProvisioner = new PrePaymentProvisionerComponent($id_order);

        /** @var ResponseComponent $response */
        $response = $this->paymentCreationHandler->createPayment($prePaymentProvisioner, $button);

        if (!$response->isSuccess()) {
            throw new Exception("Unable to create payment data.");
        }

        return $response->data->url;
    }
}
