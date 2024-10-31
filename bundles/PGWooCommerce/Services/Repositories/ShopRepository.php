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

use WP_Site as LocalWP_Site;
use PGI\Module\PGDatabase\Foundations\AbstractRepositoryWrapped;
use PGI\Module\PGShop\Interfaces\Repositories\ShopRepositoryInterface;
use PGI\Module\PGShop\Services\Handlers\ShopHandler;
use PGI\Module\PGWooCommerce\Entities\Shop;
use stdClass;

/**
 * Class ShopRepository
 * @package PGWooCommerce\Services\Repositories
 */
class ShopRepository extends AbstractRepositoryWrapped implements ShopRepositoryInterface
{
    /** @var ShopHandler */
    private $shopHandler;

    public function __construct(ShopHandler $shopHandler)
    {
        $this->shopHandler = $shopHandler;
    }

    public function wrapEntity($localEntity)
    {
        return new Shop($localEntity);
    }

    public function findByPrimary($id)
    {
        if ($this->shopHandler->isMultiShopActivated()) {
            $localEntity = LocalWP_Site::get_instance($id);
        } elseif (((int) $id) === get_current_blog_id()) {
            $localEntity = $this->buildFakePrimaryShop();
        } else {
            $localEntity = null;
        }

        return $localEntity ? $this->wrapEntity($localEntity) : null;
    }

    public function findCurrent()
    {
        if ($this->shopHandler->isMultiShopActivated()) {
            $id = get_current_blog_id();

            /** @var LocalWP_Site $localEntity */
            $localEntity = LocalWP_Site::get_instance($id);
        } else {
            $localEntity = $this->buildFakePrimaryShop();
        }

        return $this->wrapEntity($localEntity);
    }

    public function findAll()
    {
        if ($this->shopHandler->isMultiShopActivated()) {
            $localEntities = get_sites();
        } else {
            $localEntities = array($this->buildFakePrimaryShop());
        }

        return $this->wrapEntities($localEntities);
    }

    protected function buildFakePrimaryShop()
    {
        $shop = new stdClass();

        $shop->blog_id = get_current_blog_id();
        $shop->blogname = get_bloginfo('name', 'raw');

        return $shop;
    }
}
