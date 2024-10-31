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

namespace PGI\Module\PGWooCommerce\Services\Officers;

use PGI\Module\PGShop\Interfaces\Officers\ShopOfficerInterface;

/**
 * Class ShopOfficer
 *
 * @package PGWooCommerce\Services\Officers
 */
class ShopOfficer implements ShopOfficerInterface
{
    /**
     * @return bool
     */
    public function isMultiShopActivated()
    {
        return (function_exists('is_multisite') && is_multisite());
    }

    /**
     * @return bool
     */
    public function isShopContext()
    {
        return true;
    }

    /**
     * @return bool
     */
    public function isBackOffice()
    {
        return is_admin();
    }
}