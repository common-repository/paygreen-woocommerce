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

namespace PGI\Module\PGWordPress\Services\Upgrades;

use PGI\Module\PGModule\Components\UpgradeStage as UpgradeComponent;
use PGI\Module\PGModule\Interfaces\UpgradeInterface;
use PGI\Module\PGLog\Interfaces\LoggerInterface;
use PGI\Module\PGModule\Services\Settings;
use Exception;

class RestoreSettingsUpgrade implements UpgradeInterface
{
    const CONFIG_KEY_SETTINGS = 'woocommerce_wcpaygreen_settings';
    const CONFIG_KEY_SHIPPING = 'wcpaygreen_shipping_deactivated_payment_modes';

    public static $CONFIG_KEYS_STRING = array(
        'paygreen_accepted_payment' => 'validate_state',
        'private_key' => 'private_key',
        'unique_token' => 'public_key',
        'shopId' => 'shop_identifier'
    );

    public static $CONFIG_KEYS_BOOLEAN = array(
        'test_mode' => 'admin_only_visibility',
        'paygreen_refund' => 'behavior_payment_refund',
        'paygreen_security' => 'footer_display'
    );

    /** @var Settings */
    private $settings;

    /** @var LoggerInterface */
    private $logger;

    /**
     * PGModuleServicesListenersRestoreSettingsListener constructor.
     * @param Settings $settings
     * @param LoggerInterface $logger
     */
    public function __construct(
        Settings $settings,
        LoggerInterface $logger
    ) {
        $this->settings = $settings;
        $this->logger = $logger;
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function apply(UpgradeComponent $upgradeStage)
    {
        $oldSettings = get_option(self::CONFIG_KEY_SETTINGS);
        if (!empty($oldSettings) && is_array($oldSettings)) {
            $this->logger->notice("Old settings finded.");
            $this->restoreSettings($oldSettings);
        }

        $oldShippingModes = get_option(self::CONFIG_KEY_SHIPPING);
        if (!empty($oldShippingModes) && is_array($oldShippingModes)) {
            $this->logger->notice("Old shipping modes configuration finded.");
            $this->restoreShippingModes($oldShippingModes);
        }

        return true;
    }

    /**
     * @param array $oldSettings
     * @throws Exception
     */
    private function restoreSettings(array $oldSettings)
    {
        foreach (self::$CONFIG_KEYS_STRING as $source => $target) {
            if (array_key_exists($source, $oldSettings) && !empty($oldSettings[$source])) {
                $this->settings->set($target, $oldSettings[$source]);

                $this->logger->notice("Old settings '$target' successfully restored.");
            }
        }

        foreach (self::$CONFIG_KEYS_BOOLEAN as $source => $target) {
            if (array_key_exists($source, $oldSettings) && ($oldSettings[$source] === 'yes')) {
                $this->settings->set($target, true);

                $this->logger->notice("Old settings '$target' successfully restored.");
            }
        }

        delete_option(self::CONFIG_KEY_SETTINGS);
    }

    /**
     * @param array $oldShippingModes
     * @throws Exception
     */
    private function restoreShippingModes(array $oldShippingModes)
    {
        $this->settings->set('shipping_deactivated_payment_modes', $oldShippingModes);

        delete_option(self::CONFIG_KEY_SHIPPING);

        $this->logger->notice("Old shipping modes configuration successfully restored.");
    }
}