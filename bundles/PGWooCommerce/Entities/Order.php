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

namespace PGI\Module\PGWooCommerce\Entities;

use WC_Order as LocalWC_Order;
use WC_Customer as LocalWC_Customer;
use PGI\Module\PGDatabase\Foundations\AbstractEntityWrapped;
use PGI\Module\PGLog\Interfaces\LoggerInterface;
use PGI\Module\PGShop\Interfaces\Entities\OrderEntityInterface;
use PGI\Module\PGShop\Services\Mappers\OrderStateMapper;
use PGI\Module\PGShop\Tools\Price as PriceTool;
use Exception;

/**
 * Class Order
 *
 * @package PGWooCommerce\Entities
 * @method LocalWC_Order getLocalEntity()
 */
class Order extends AbstractEntityWrapped implements OrderEntityInterface
{
    /**
     * @inheritdoc
     */
    public function id()
    {
        return $this->getLocalEntity()->get_id();
    }

    /**
     * @inheritdoc
     */
    public function getReference()
    {
        return $this->getLocalEntity()->get_order_key();
    }

    public function getShippingAddress()
    {
        $data = array(
            'first_name' => $this->getLocalEntity()->get_shipping_first_name(),
            'last_name' => $this->getLocalEntity()->get_shipping_last_name(),
            'address_1' => $this->getLocalEntity()->get_shipping_address_1(),
            'address_2' => $this->getLocalEntity()->get_shipping_address_2(),
            'country' => $this->getLocalEntity()->get_shipping_country(),
            'city' => $this->getLocalEntity()->get_shipping_city(),
            'postcode' => $this->getLocalEntity()->get_shipping_postcode(),
        );

        if (!$data) {
            throw new Exception('Shipping address data missing.');
        }

        $shipping_address = new Address($data);

        return $shipping_address;
    }

    /**
     * @inheritdoc
     */
    public function getTotalAmount()
    {
        return PriceTool::toInteger($this->getLocalEntity()->get_total());
    }

    /**
     * @inheritdoc
     */
    public function getTotalUserAmount()
    {
        return PriceTool::fixFloat($this->getLocalEntity()->get_total());
    }

    /**
     * @inheritdoc
     */
    public function getCustomerId()
    {
        return $this->getLocalEntity()->get_customer_id();
    }

    /**
     * @inheritdoc
     * @throws Exception
     */
    public function getCustomer()
    {
        $customer_id = $this->getCustomerId();

        if (!$customer_id) {
            throw new Exception('Customer not found.');
        }

        $local_customer = new LocalWC_Customer($customer_id);

        return new Customer($local_customer);
    }

    /**
     * @inheritdoc
     * @throws Exception
     */
    public function getBillingAddress()
    {
        $data = array(
            'first_name' => $this->getLocalEntity()->get_billing_first_name(),
            'last_name' => $this->getLocalEntity()->get_billing_last_name(),
            'address_1' => $this->getLocalEntity()->get_billing_address_1(),
            'address_2' => $this->getLocalEntity()->get_billing_address_2(),
            'country' => $this->getLocalEntity()->get_billing_country(),
            'city' => $this->getLocalEntity()->get_billing_city(),
            'postcode' => $this->getLocalEntity()->get_billing_postcode(),
        );

        if (!$data) {
            throw new Exception('Billing address data missing.');
        }
        
        $billing_address = new Address($data);

        return $billing_address;
    }

    public function getCustomerMail()
    {
        return $this->getLocalEntity()->get_billing_email();
    }

    public function getCurrency()
    {
        return $this->getLocalEntity()->get_currency();
    }

    public function getState()
    {
        /** @var OrderStateMapper $orderStateMapper */
        $orderStateMapper = $this->getService('mapper.order_state');

        return $orderStateMapper->getOrderState(array('state' => $this->getLocalEntity()->get_status()));
    }

    public function getShippingWeight()
    {
        $weight = 0;

        foreach($this->getItems() as $item) {
            $item_quantity = $item->getQuantity();
            $item_weight = $item->getProduct()->getWeight();
            if (!$item_weight) {
                $weight += (1 * $item_quantity);
            } else {
                $weight += ($item->getProduct()->getWeight() * $item_quantity);
            }
        }

        return $weight;

    }

    public function getItems()
    {
        $items = array();
        
        foreach ($this->getLocalEntity()->get_items() as $item) {
            $items[] = new OrderItem($item);
        }
        
        return $items;
    }

    /**
     * @inheridoc
     */
    public function getCarrier()
    {
        // not used
         return null;
    }

    /**
     * @inheritdoc
     */
    public function paidWithPaygreen()
    {
        $paymentMethod = $this->getLocalEntity()->get_payment_method();

        return (strtolower($paymentMethod) === 'wcpaygreen');
    }

    /**
     * @inheritdoc
     */
    public function getCartId()
    {
        return $this->getLocalEntity()->get_cart_hash();
    }
}