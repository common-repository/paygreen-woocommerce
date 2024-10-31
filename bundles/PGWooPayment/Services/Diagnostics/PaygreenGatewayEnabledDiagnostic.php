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

namespace PGI\Module\PGWooPayment\Services\Diagnostics;

use WC_Payment_Gateway as LocalWC_Payment_Gateway;
use PGI\Module\PGFramework\Foundations\AbstractDiagnostic;
use PGI\Module\PGLog\Interfaces\LoggerInterface;
use Exception;

/**
 * Class PaygreenGatewayEnabledDiagnostic
 * @package PGWooPayment\Services\Diagnostics
 */
class PaygreenGatewayEnabledDiagnostic extends AbstractDiagnostic
{
    const PAYGREEN_GATEWAY_ID = 'wcpaygreen';

    /** @var LoggerInterface */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function isValid()
    {
        if (!$this->isDiagnosticAvailable()) {
            $this->logger->warning("PaygreenGatewayEnabled diagnostic is not available.");
            return true;
        } elseif (!$this->isWooCommerceInstalled()) {
            $this->logger->warning("WooCommerce is not installed.");
            return false;
        } elseif (!$this->isPaygreenGatewayInstalled()) {
            $this->logger->warning("PayGreen gateway is not installed.");
            return false;
        }

        $paygreen_gateway = $this->getPaygreenGateway();

        return ($paygreen_gateway->enabled === 'yes');
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function resolve()
    {
        if (!$this->isDiagnosticAvailable()) {
            $this->logger->warning("PaygreenGatewayEnabled diagnostic is not available.");
            return true;
        } elseif (!$this->isWooCommerceInstalled()) {
            $this->logger->warning("WooCommerce is not installed.");
            return false;
        } elseif (!$this->isPaygreenGatewayInstalled()) {
            $this->logger->warning("PayGreen gateway is not installed.");
            return false;
        }

        $paygreen_gateway = $this->getPaygreenGateway();

        return $paygreen_gateway->update_option('enabled', 'yes');
    }

    /**
     * @return bool
     */
    private function isDiagnosticAvailable()
    {
        $isAdminContext = (function_exists('is_plugin_active') && function_exists('is_plugin_active_for_network'));

        if (!$isAdminContext) {
            $this->logger->debug("Unable to verify plugin activation in non-admin context.");
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    private function isWooCommerceInstalled()
    {
        if (!class_exists('WooCommerce', false)) {
            $this->logger->debug("WooCommerce class not found.");
            return false;
        }

        if (!class_exists('WC_Payment_Gateway', false)) {
            $this->logger->debug("Payment gateway class not found.");
            return false;
        }

        $isWooCommercePluginExists = is_plugin_active('woocommerce/woocommerce.php') || is_plugin_active_for_network('woocommerce/woocommerce.php');

        if (!$isWooCommercePluginExists) {
            $this->logger->debug("WooCommerce plugin not found.");
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    private function isPaygreenGatewayInstalled()
    {
        $available_gateways = $this->getPaymentGateways();

        return array_key_exists(self::PAYGREEN_GATEWAY_ID, $available_gateways);
    }

    /**
     * @return array
     */
    private function getPaymentGateways()
    {
        $payment_gateways = array();

        if ($this->isWooCommerceInstalled()) {
            $payment_gateways = WC()->payment_gateways->payment_gateways();
        }

        return $payment_gateways;
    }

    /**
     * @return LocalWC_Payment_Gateway
     * @throws Exception
     */
    private function getPaygreenGateway()
    {
        $available_gateways = $this->getPaymentGateways();

        if ($this->isPaygreenGatewayInstalled()) {
            return $available_gateways[self::PAYGREEN_GATEWAY_ID];
        } else {
            throw new Exception("PayGreen gateway not found.");
        }
    }
}
