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

use PGI\Module\PGDatabase\Foundations\AbstractEntityArray;

/**
 * Class Address
 *
 * @package PGWooCommerce\Entities
 */
class Address extends AbstractEntityArray
{
    public function getLastname()
    {
        return $this->get('last_name');
    }

    public function getFirstname()
    {
        return $this->get('first_name');
    }

    public function getCountry()
    {
        return $this->get('country');
    }

    public function getAddressLineOne()
    {
        return $this->get('address_1');
    }

    public function getAddressLineTwo()
    {
        return $this->get('address_2');
    }

    public function getFullAddressLine() {
        $address_2 = $this->get('address_2');

        if (!empty($address_2)) {
            return $this->get('address_1') . ' ' . $address_2;
        }

        return $this->get('address_1');
    }

    public function getCity()
    {
        return $this->get('city');
    }

    public function getZipCode()
    {
        return $this->get('postcode');
    }
}
