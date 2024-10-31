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

namespace PGI\Module\PGWooCommerce\Services\Repositories;

use WC_Order as LocalWC_Order;
use PGI\Module\PGDatabase\Foundations\AbstractRepositoryWrapped;
use PGI\Module\PGLog\Interfaces\LoggerInterface;
use PGI\Module\PGShop\Interfaces\Entities\OrderEntityInterface;
use PGI\Module\PGShop\Interfaces\Repositories\OrderRepositoryInterface;
use PGI\Module\PGWooCommerce\Entities\Order;
use Exception;

class OrderRepository extends AbstractRepositoryWrapped implements OrderRepositoryInterface
{
    public function findByPrimary($id)
    {
        $localOrder = wc_get_order($id);

        return $localOrder ? $this->wrapEntity($localOrder) : null;
    }

    /**
     * @param string $ref
     */
    public function findByReference($ref)
    {
        $localOrderId = wc_get_order_id_by_order_key($ref);

        return $this->findByPrimary($localOrderId);
    }

    public function wrapEntity($localEntity)
    {
        return new Order($localEntity);
    }

    public function findRefundedAmount(OrderEntityInterface $order)
    {
        /** @var LocalWC_Order $localEntity */
        $localEntity = $order->getLocalEntity();

        return $localEntity->get_total_refunded();
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function updateOrderState(OrderEntityInterface $order, array $localState)
    {
        /** @var LoggerInterface $logger */
        $logger = $this->getService('logger');

        /** @var LocalWC_Order $localEntity */
        $localEntity = $order->getLocalEntity();

        if ($localState['state'] === 'wc-processing') {
            $logger->info("Validate payment for order #{$order->id()}");

            $result = $localEntity->payment_complete();

            $localCart = WC()->cart;

            if ($result && !empty($localCart)) {
                $localCart->empty_cart(true);
            }
        } else {
            $result = $localEntity->update_status($localState['state']);
        }

        return $result;
    }
}
