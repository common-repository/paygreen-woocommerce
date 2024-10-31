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

namespace PGI\Module\PGWordPress\Services\Facades;

use PGI\Module\PGModule\Interfaces\ModuleFacadeInterface;
use PGI\Module\PGSystem\Foundations\AbstractObject;
use PGI\Module\PGSystem\Services\Container;
use PGI\Module\PGWooPayment\Bridges\WooCommerceBridge as WooCommerceBridgeBridge;

/**
 * Class ModuleFacade
 * @package PGWordPress\Services\Facades
 */
class ModuleFacade extends AbstractObject implements ModuleFacadeInterface
{
    public function isActive()
    {
        /** @var Container $container */
        $container = $this->getService('container');

        if (!function_exists('is_plugin_active')) {
            require_once(ABSPATH . 'wp-admin/includes/plugin.php');
        }

        $isEnabled = (bool) is_plugin_active(PAYGREEN_MODULE_NAME);

        if ($isEnabled && $container->has('bridge.woocommerce')) {
            /** @var WooCommerceBridgeBridge $woocommerceBridge */
            $woocommerceBridge = $this->getService('bridge.woocommerce');

            $isEnabled = $woocommerceBridge->isEnabled();
        }

        return $isEnabled;
    }
}
