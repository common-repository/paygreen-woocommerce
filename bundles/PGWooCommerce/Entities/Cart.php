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

use WC_Cart as LocalWC_Cart;
use PGI\Module\PGLog\Interfaces\LoggerInterface;
use PGI\Module\PGShop\Foundations\Entities\AbstractCartEntity;
use PGI\Module\PGShop\Interfaces\Entities\CarrierEntityInterface;
use PGI\Module\PGShop\Tools\Price as PriceTool;

/**
 * Class Cart
 *
 * @package PGWooCommerce\Entities
 * @method LocalWC_Cart getLocalEntity()
 */
class Cart extends AbstractCartEntity
{
    public function __construct($localEntity)
    {
        parent::__construct($localEntity);

        $this->getCarrier();
    }

    /**
     * @inheritdoc
     */
    public function getTotalCost()
    {
        $price = $this->getLocalEntity()->get_total('edit');

        return PriceTool::toInteger($price);
    }

    /**
     * @inheritdoc
     */
    public function getShippingCost()
    {
        $price = $this->getLocalEntity()->get_shipping_total() + $this->getLocalEntity()->get_shipping_tax();

        return PriceTool::toInteger($price);
    }

    /**
     * @inheritdoc
     */
    public function getShippingWeight()
    {
        return $this->getLocalEntity()->get_cart_contents_weight();
    }

    /**
     * @inheritdoc
     */
    public function getCurrency()
    {
         return new Currency();
    }

    /**
     * @inheritdoc
     */
    protected function preloadItems()
    {
        $items = array();

        foreach ($this->getLocalEntity()->get_cart() as $item) {
            $items[] = new CartItem($item);
        }

        return $items;
    }

    public function getShippingAddress()
    {
        /** @var LoggerInterface $logger */
        $logger = $this->getService('logger');

        $shippingAddress = null;

        $customer = $this->getLocalEntity()->get_customer();

        if ($customer !== null) {
            $shippingAddress = new Address(array(
                'first_name' => $customer->get_shipping_first_name(),
                'last_name' => $customer->get_shipping_last_name(),
                'address_1' => $customer->get_shipping_address_1(),
                'address_2' => $customer->get_shipping_address_2(),
                'country' => $customer->get_shipping_country(),
                'city' => $customer->get_shipping_city(),
                'postcode' => $customer->get_shipping_postcode(),
            ));
        } else {
            $text = "Customer not found. Unable to retrieve the shipping address without the customer.";
            $logger->debug($text);
        }

        return $shippingAddress;
    }

    public function getBillingAddress()
    {
        /** @var LoggerInterface $logger */
        $logger = $this->getService('logger');

        $billingAddress = null;

        $customer = $this->getLocalEntity()->get_customer();

        if ($customer !== null) {
            $billingAddress = new Address(array(
                'first_name' => $customer->get_billing_first_name(),
                'last_name' => $customer->get_billing_last_name(),
                'address_1' => $customer->get_billing_address_1(),
                'address_2' => $customer->get_billing_address_2(),
                'country' => $customer->get_billing_country(),
                'city' => $customer->get_billing_city(),
                'postcode' => $customer->get_billing_postcode(),
            ));
        } else {
            $text = "Customer not found. Unable to retrieve the billing address without the customer.";
            $logger->debug($text);
        }

        return $billingAddress;
    }

    /**
     * @inheridoc
     */
    public function getCarrier()
    {
        /** @var LoggerInterface $logger */
        $logger = $this->getService('logger');

        /** @var CarrierEntityInterface $carrier */
        $carrier = null;

        $shippingMethod = null;

        if (WC()->session) {
            $shippingMethods = WC()->session->get('chosen_shipping_methods');

            if (!empty($shippingMethods)) {
                $shippingMethod = $shippingMethods[0];
            }
        }

        if ($shippingMethod) {
            $shippingdArguments = explode(":",$shippingMethod);

            if($shippingdArguments[0] && $shippingdArguments[1]) {
                $carrier = new Carrier(array(
                    'name' => $shippingdArguments[0],
                    'id' => $shippingdArguments[1]
                ));
            }
        } else {
            $logger->warning('Carrier data not found.');
        }

        return $carrier;
    }

    /**
     * @inheritdoc
     */
    public function id()
    {
        return $this->getLocalEntity()->get_cart_hash();
    }

}
