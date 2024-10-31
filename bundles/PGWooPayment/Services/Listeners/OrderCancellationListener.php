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

namespace PGI\Module\PGWooPayment\Services\Listeners;

use WC_Cart as LocalWC_Cart;
use PGI\Module\PGLog\Interfaces\LoggerInterface;
use PGI\Module\PGShop\Components\Events\Order as OrderEventComponent;

class OrderCancellationListener
{
    /** @var LoggerInterface */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function listen(OrderEventComponent $event)
    {
        /** @var LocalWC_Cart $cart */
        $cart = WC()->cart;

        $this->logger->info("Clean cart after order #{$event->getOrder()->id()} cancellation.");

        $cart->empty_cart();
    }
}