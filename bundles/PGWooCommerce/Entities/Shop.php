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

use WP_Site as LocalWP_Site;
use PGI\Module\PGDatabase\Foundations\AbstractEntityWrapped;
use PGI\Module\PGShop\Interfaces\Entities\ShopEntityInterface;

/**
 * Class Shop
 *
 * @package PGWooCommerce\Entities
 * @method LocalWP_Site getLocalEntity()
 */
class Shop extends AbstractEntityWrapped implements ShopEntityInterface
{
    public function id()
    {
        return $this->getLocalEntity()->blog_id;
    }

    public function getName()
    {
        return $this->getLocalEntity()->blogname;
    }

    public function getMail()
    {
        return get_bloginfo('admin_email');
    }
}
