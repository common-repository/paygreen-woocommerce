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

use WC_Order_Item_Product as LocalWC_Order_Item_Product;
use PGI\Module\PGShop\Foundations\Entities\AbstractShopableItemEntity;
use PGI\Module\PGShop\Interfaces\Repositories\ProductRepositoryInterface;
use PGI\Module\PGShop\Tools\Price as PriceTool;

/**
 * Class OrderItem
 *
 * @package PGWooCommerce\Entities
 * @method LocalWC_Order_Item_Product getLocalEntity()
 */
class OrderItem extends AbstractShopableItemEntity
{
    /**
     * @inheritdoc
     */
    public function getCost()
    {
        $price = (float) $this->getLocalEntity()->get_total('edit') + (float) $this->getLocalEntity()->get_total_tax('edit');

        return PriceTool::toInteger($price);
    }

    /**
     * @inheritdoc
     */
    public function getQuantity()
    {
        return $this->getLocalEntity()->get_quantity();
    }

    /**
     * @inheritdoc
     */
    public function getProductDescription()
    {
        return $this->getLocalEntity()->get_product()->get_description();
    }

    /**
     * @inheritdoc
     */
    protected function preloadProduct()
    {
        /** @var ProductRepositoryInterface $productRepository */
        $productRepository = $this->getService('repository.product');

        return $productRepository->wrapEntity($this->getLocalEntity()->get_product());
    }
}
