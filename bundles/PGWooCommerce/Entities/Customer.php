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

use WC_Customer as LocalWC_Customer;
use PGI\Module\PGDatabase\Foundations\AbstractEntityWrapped;
use PGI\Module\PGShop\Interfaces\Entities\CustomerEntityInterface;
use Exception;

/**
 * Class Customer
 *
 * @package PGWooCommerce\Entities
 * @method LocalWC_Customer getLocalEntity()
 */
class Customer extends AbstractEntityWrapped implements CustomerEntityInterface
{
    public function getLastname()
    {
        return $this->getLocalEntity()->get_last_name();
    }

    public function getFirstname()
    {
        return $this->getLocalEntity()->get_first_name();
    }

    public function getEmail()
    {
        return $this->getLocalEntity()->get_email();
    }

    /**
     * @throws Exception
     */
    public function getShippingAddress()
    {
        $data = $this->getLocalEntity()->get_shipping();

        if (!$data) {
            throw new Exception('Shipping address data missing.');
        }
        
        $shipping_address = new Address($data);

        return $shipping_address;
    }

    /**
     * @throws Exception
     */
    public function getBillingAddress()
    {
        if (!$this->getLocalEntity()->get_billing()) {
            throw new Exception('Billing address data missing.');
        }
        
        $data = $this->getLocalEntity()->get_billing();
        $billing_address = new Address($data);

        return $billing_address;
    }
}
