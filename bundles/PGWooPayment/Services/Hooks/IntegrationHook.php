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

use PGI\Module\PGLog\Interfaces\LoggerInterface;

class IntegrationHook
{
    private static $EXTENDED_MAILS = array('customer_processing_order', 'new_order');

    private static $EXTENDED_MAIL_STATUS = array('pg-auth', 'pg-waiting', 'pg-suspicious');

    /** @var LoggerInterface */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;

        if (!function_exists('is_plugin_active') || !function_exists('is_plugin_active_for_network')) {
            require_once(ABSPATH . '/wp-admin/includes/plugin.php');
        }
    }

    protected function isWooCommerceEnabled()
    {
        $isGatewayClassExists = class_exists('WC_Payment_Gateway');
        $isWooCommercePluginExists = is_plugin_active('woocommerce/woocommerce.php') || is_plugin_active_for_network('woocommerce/woocommerce.php');

        if (!$isGatewayClassExists) {
            $this->logger->error("Payment gateway class not found.");
        }

        if (!$isWooCommercePluginExists) {
            $this->logger->error("WooCommerce plugin not found.");
        }

        return $isGatewayClassExists && $isWooCommercePluginExists;
    }

    public function init()
    {
        if ($this->isWooCommerceEnabled()) {
            add_filter('woocommerce_payment_gateways', array($this, 'addGateway'));
            $this->extendsMailConfiguration();
        } else {
            $this->logger->critical("WooCommerce not found.");
        }
    }

    public function addGateway(array $gateways)
    {
        $gateways[] = 'PGI\Module\PGWooPayment\Bridges\WooCommerceBridge';

        return $gateways;
    }

    protected function extendsMailConfiguration()
    {
        $mailer = WC()->mailer();
        $mails = $mailer->get_emails();

        if (!empty($mails)) {
            $this->logger->debug("Extends WooCommerce mail transitions.");

            foreach ($mails as $mail) {
                if (in_array($mail->id, self::$EXTENDED_MAILS)) {
                    foreach(self::$EXTENDED_MAIL_STATUS as $status) {
                        $transition = "woocommerce_order_status_{$status}_to_processing";
                        $this->logger->debug("Add order transition '$transition' for mail '{$mail->id}'.");
                        add_action($transition, array($mail, 'trigger'), 10, 2);
                    }
                }
            }
        } else {
            $this->logger->warning("WooCommerce mail list is empty.");
        }
    }
}
