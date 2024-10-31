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

use PGI\Module\PGClient\Exceptions\Response as ResponseException;
use PGI\Module\PGIntl\Services\Translator;
use PGI\Module\PGLog\Interfaces\LoggerInterface;
use PGI\Module\PGPayment\Interfaces\Entities\ButtonEntityInterface;
use PGI\Module\PGPayment\Services\Handlers\CheckoutHandler;
use PGI\Module\PGPayment\Services\Handlers\PaymentButtonHandler;
use PGI\Module\PGPayment\Services\Managers\ButtonManager;
use PGI\Module\PGShop\Interfaces\Provisioners\CheckoutProvisionerInterface;
use PGI\Module\PGView\Services\Handlers\ViewHandler;
use PGI\Module\PGWooCommerce\Components\Provisioners\Checkout as CheckoutProvisionerComponent;
use PGI\Module\PGWooPayment\Exceptions\CartUnavailable as CartUnavailableException;
use Exception;
use Paygreen;

class CheckoutHook
{
    /** @var CheckoutHandler */
    private $checkoutHandler;

    /** @var ViewHandler */
    private $viewHandler;

    /** @var ButtonManager */
    private $buttonManager;

    /** @var PaymentButtonHandler */
    private $paymentButtonHandler;

    /** @var Translator */
    private $translator;

    /** @var LoggerInterface */
    private $logger;

    public function __construct(
        CheckoutHandler $checkoutHandler,
        ViewHandler $viewHandler,
        ButtonManager $buttonManager,
        PaymentButtonHandler $paymentButtonHandler,
        Translator $translator,
        LoggerInterface $logger
    ) {
        $this->checkoutHandler = $checkoutHandler;
        $this->viewHandler = $viewHandler;
        $this->buttonManager = $buttonManager;
        $this->paymentButtonHandler = $paymentButtonHandler;
        $this->translator = $translator;
        $this->logger = $logger;
    }

    public function getPaymentBlocTitle()
    {
        return $this->translator->get('~payment_bloc');
    }

    public function display()
    {
        $content = '';

        try {
            /** @var CheckoutProvisionerInterface $checkoutProvisioner */
            $checkoutProvisioner = new CheckoutProvisionerComponent();

            if ($this->checkoutHandler->isCheckoutAvailable($checkoutProvisioner)) {
                $this->logger->debug("Paygreen Checkout is available.");
    
                $paymentOptions = $this->getPaymentOptions($checkoutProvisioner);
    
                if (count($paymentOptions) === 1) {
                    $content = $this->viewHandler->renderTemplate('checkout-button', array(
                        'option' => array_pop($paymentOptions)
                    ));
                } else {
                    $content = $this->viewHandler->renderTemplate('checkout-button-list', array(
                        'options' => $paymentOptions
                    ));
                }
            } else {
                $this->logger->warning("Paygreen Checkout is not available.");
            }
    
            return $this->removeLineBreaks($content);
        } catch (Exception $exception) {
            $this->logger->error("Error exception : " . $exception->getMessage(), $exception);
        }
    }

    /**
     * @param CheckoutProvisionerInterface $checkoutProvisioner
     * @return array
     * @throws ResponseException
     * @throws Exception
     */
    private function getPaymentOptions(CheckoutProvisionerInterface $checkoutProvisioner)
    {
        $paymentOptions = array();

        /** @var ButtonEntityInterface[] $buttons */
        $buttons = $this->buttonManager->getValidButtons($checkoutProvisioner);

        foreach ($buttons as $button) {
            $paymentOptions[] = array(
                'id' => $button->id(),
                'text' => $button->getLabel(),
                'image' => $this->paymentButtonHandler->getButtonFinalUrl($button),
                'height' => $button->getImageHeight(),
                'displayType' => $button->getDisplayType()
            );
        }

        return $paymentOptions;
    }

    protected function removeLineBreaks($content)
    {
        $lines = explode(PHP_EOL, $content);

        return implode('', $lines);
    }

    /**
     * @return bool
     */
    public function isAvailable()
    {
        $isModuleAvailable = false;

        try {
            /** @var CheckoutProvisionerInterface $checkoutProvisioner */
            $checkoutProvisioner = new CheckoutProvisionerComponent();

            $isModuleAvailable = $this->checkoutHandler->isCheckoutAvailable($checkoutProvisioner);
        } catch (CartUnavailableException $exception) {
            $this->logger->warning($exception->getMessage());
        } catch (Exception $exception) {
            $this->logger->error("Error exception : " . $exception->getMessage(), $exception);
        }

        return $isModuleAvailable;
    }
}
