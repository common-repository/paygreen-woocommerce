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
use WC_Order as LocalWC_Order;
use PGI\Module\PGLog\Interfaces\LoggerInterface;
use PGI\Module\PGShop\Interfaces\Entities\CarrierEntityInterface;
use PGI\Module\PGShop\Interfaces\Entities\CustomerEntityInterface;
use PGI\Module\PGShop\Interfaces\Entities\ShopableItemEntityInterface;
use PGI\Module\PGShop\Interfaces\Provisioners\PrePaymentProvisionerInterface;
use PGI\Module\PGShop\Tools\Price as PriceTool;
use PGI\Module\PGSystem\Foundations\AbstractObject;
use PGI\Module\PGWooCommerce\Entities\Address;
use PGI\Module\PGWooCommerce\Entities\Carrier;
use PGI\Module\PGWooCommerce\Entities\Cart;
use PGI\Module\PGWooCommerce\Entities\Order;
use PGI\Module\PGWooCommerce\Entities\OrderItem;
use Exception;

/**
 * Class PrePayment
 * @package PGWooCommerce\Components\Provisioners
 */
class PrePayment extends AbstractObject implements PrePaymentProvisionerInterface
{
    private static $REQUIRED_ADDRESS_FIELDS = array(
        'first_name',
        'last_name',
        'address_1',
        'country',
        'city'
    );

    /** @var LocalWC_Order */
    private $localOrder;

    /**
     * PrePayment constructor.
     * @param int $id_order
     * @throws Exception
     */
    public function __construct($id_order)
    {
        $this->localOrder = wc_get_order($id_order);
        
        if (!$this->localOrder) {
            throw new Exception("Order #$id_order not found.");
        }
    }

    public function getReference()
    {
        return $this->localOrder->get_id();
    }

    public function getCurrency()
    {
        return $this->localOrder->get_currency();
    }

    public function getTotalAmount()
    {
        $price = $this->localOrder->get_total();

        return PriceTool::toInteger($price);
    }

    public function getShippingAmount()
    {
        $price = (float) $this->localOrder->get_shipping_total('edit') + (float) $this->localOrder->get_shipping_tax('edit');

        return PriceTool::toInteger($price);
    }

    public function getShippingName()
    {
        return $this->localOrder->get_shipping_method();
    }

    public function getShippingWeight()
    {
        $weight = 0;

        /** @var ShopableItemEntityInterface $item */
        foreach ($this->getItems() as $item) {
            $weight += ($item->getProduct()->getWeight() * $item->getQuantity());
        }

        return $weight;
    }

    public function getMail()
    {
        return $this->localOrder->get_billing_email();
    }

    public function getCountry()
    {
        return $this->localOrder->get_shipping_country();
    }

    public function getAddressLineOne()
    {
        return $this->localOrder->get_shipping_address_1();
    }

    public function getAddressLineTwo()
    {
        return $this->localOrder->get_shipping_address_2();
    }

    public function getCity()
    {
        return $this->localOrder->get_shipping_city();
    }

    public function getZipCode()
    {
        return $this->localOrder->get_shipping_postcode();
    }

    public function getCustomerId()
    {
        return $this->localOrder->get_customer_id();
    }

    public function getFirstName()
    {
        $firstName = $this->localOrder->get_billing_first_name();

        if (empty($firstName)) {
            $firstName = $this->localOrder->get_shipping_first_name();
        }

        return $firstName;
    }

    public function getLastName()
    {
        $lastName = $this->localOrder->get_billing_last_name();

        if (empty($lastName)) {
            $lastName = $this->localOrder->get_shipping_last_name();
        }

        return $lastName;
    }

    /**
     * @return ShopableItemEntityInterface[]
     */
    public function getItems()
    {
        $items = array();

        foreach($this->localOrder->get_items() as $item) {
            $items[] = new OrderItem($item);
        }

        return $items;
    }

    /**
     * @inheritDoc
     */
    public function getMetadata()
    {
        return array(
            'order_id' => $this->localOrder->get_id()
        );
    }

    public function getCart()
    {
        /** @var LocalWC_Cart $localCart */
        $localCart = WC()->cart;
        $cart = new Cart($localCart);
        return $cart;
    }

    /**
     * @return CustomerEntityInterface
     */
    public function getCustomer()
    {
        $order = new Order($this->localOrder);

        return $order->getCustomer();
    }

    /**
     * @return CarrierEntityInterface
     */
    public function getCarrier()
    {
        $data = array();
        
        $data['name'] = $this->localOrder->get_shipping_method();

        $carrier = new Carrier($data);

        return $carrier;
    }

    /**
     * @inheritdoc
     * @throws Exception
     */
    public function getShippingAddress()
    {
        /** @var LoggerInterface $logger */
        $logger = $this->getService('logger');

        $addressData = array(
            'first_name' => $this->localOrder->get_shipping_first_name(),
            'last_name' => $this->localOrder->get_shipping_last_name(),
            'address_1' => $this->localOrder->get_shipping_address_1(),
            'address_2' => $this->localOrder->get_shipping_address_2(),
            'country' => $this->localOrder->get_shipping_country(),
            'city' => $this->localOrder->get_shipping_city(),
            'postcode' => $this->localOrder->get_shipping_postcode(),
        );

        if (!$this->localOrder->needs_shipping_address()) {
            $logger->debug('No shipping address needed, send billing address data to the API.');
            return $this->getBillingAddress();
        }

        foreach ($addressData as $key => $value) {
            if (in_array($key, self::$REQUIRED_ADDRESS_FIELDS) && (empty($value))) {
                throw new Exception('Shipping address data missing.');
            }
        }

        return new Address($addressData);
    }

    /**
     * @inheritdoc
     * @throws Exception
     */
    public function getBillingAddress()
    {
        $addressData = array(
            'first_name' => $this->localOrder->get_billing_first_name(),
            'last_name' => $this->localOrder->get_billing_last_name(),
            'address_1' => $this->localOrder->get_billing_address_1(),
            'address_2' => $this->localOrder->get_billing_address_2(),
            'country' => $this->localOrder->get_billing_country(),
            'city' => $this->localOrder->get_billing_city(),
            'postcode' => $this->localOrder->get_billing_postcode(),
        );

        foreach ($addressData as $key => $value) {
            if (in_array($key, self::$REQUIRED_ADDRESS_FIELDS) && ($value === null)) {
                throw new Exception('Billing address data missing.');
            }
        }

        return new Address($addressData);
    }
}
