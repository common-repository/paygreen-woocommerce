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

namespace PGI\Module\PGWooCommerce\Components\Provisioners;

use WC_Cart as LocalWC_Cart;
use WC_Order_Item_Product as LocalWC_Order_Item_Product;
use PGI\Module\PGLog\Interfaces\LoggerInterface;
use PGI\Module\PGShop\Interfaces\Entities\CartEntityInterface;
use PGI\Module\PGShop\Interfaces\Provisioners\CheckoutProvisionerInterface;
use PGI\Module\PGShop\Interfaces\Repositories\CartRepositoryInterface;
use PGI\Module\PGShop\Tools\Price as PriceTool;
use PGI\Module\PGSystem\Foundations\AbstractObject;
use PGI\Module\PGWooCommerce\Entities\CartItem;
use PGI\Module\PGWooCommerce\Entities\Order;
use PGI\Module\PGWooCommerce\Services\Repositories\OrderRepository;
use PGI\Module\PGWooPayment\Exceptions\CartUnavailable as CartUnavailableException;

/**
 * Class Checkout
 * @package PGWooCommerce\Components\Provisioners
 */
class Checkout extends AbstractObject implements CheckoutProvisionerInterface
{
    /** @var CartEntityInterface|null */
    private $cart = null;

    /**
     * @inheritDoc
     * @throws CartUnavailableException
     */
    public function getTotalAmount()
    {
        return $this->getCart()->getTotalCost();
    }

    /**
     * @inheritDoc
     * @throws CartUnavailableException
     */
    public function getTotalUserAmount()
    {
        $price = $this->getCart()->getTotalCost();

        return PriceTool::toFloat($price);
    }

    /**
     * @inheritDoc
     */
    public function getItems()
    {
        /** @var LoggerInterface $logger */
        $logger = $this->getService('logger');

        /** @var OrderRepository $orderRepository */
        $orderRepository = $this->getService('repository.order');

        $items = array();

        if ($this->isOrderPaymentLink()) {
            $logger->debug('Order payment link.');

            $orderReference = $_GET['key'];

            /** @var Order $order */
            $order = $orderRepository->findByReference($orderReference);

            if ($order !== null) {
                $orderItems = $order->getLocalEntity()->get_items();

                if (!empty($orderItems)) {
                    $logger->debug("Items founded in order #{$order->id()}.");
                }

                /** @var LocalWC_Order_Item_Product $item */
                foreach ($orderItems as $item) {
                    $items[] = new CartItem($item);
                }
            } else {
                $logger->warning("No orders found with reference #$orderReference .");
            }
        } else {
            $items = $this->cart->getItems();
        }

        return $items;
    }

    /**
     * @return bool
     */
    private function isOrderPaymentLink()
    {
        if (array_key_exists('key', $_GET)) {
            return (substr($_GET['key'], 0, 8) === 'wc_order');
        }

        return false;
    }

    /**
     * @inheritDoc
     * @throws CartUnavailableException
     */
    public function getCurrency()
    {
        return $this->getCart()->getCurrency();
    }

    /**
     * @return CartEntityInterface|null
     * @throws CartUnavailableException
     */
    protected function getCart()
    {
        if ($this->cart === null) {
            if (!WC()->cart instanceof LocalWC_Cart) {
                throw new CartUnavailableException("Cart not found.");
            }

            /** @var CartRepositoryInterface $cartRepository */
            $cartRepository = $this->getService('repository.cart');

            $localCart = WC()->cart;
            $this->cart = $cartRepository->wrapEntity($localCart);
        }

        return $this->cart;
    }
}
