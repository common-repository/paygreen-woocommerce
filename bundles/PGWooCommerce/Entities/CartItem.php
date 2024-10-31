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

use PGI\Module\PGShop\Interfaces\Entities\ProductEntityInterface;
use WC_Product as localWC_Product;
use PGI\Module\PGShop\Foundations\Entities\AbstractShopableItemEntity;
use PGI\Module\PGShop\Interfaces\Repositories\ProductRepositoryInterface;
use PGI\Module\PGShop\Tools\Price as PriceTool;

/**
 * Class CartItem
 *
 * @package PGWooCommerce\Entities
 * @method array getLocalEntity()
 */
class CartItem extends AbstractShopableItemEntity
{
    public function __construct($localEntity)
    {
        if (!is_array($localEntity)) {
            $localEntity = array(
              'data' => $localEntity->get_product(),
              'quantity' => $localEntity->get_quantity()
            );
        }

        parent::__construct($localEntity);
    }

    /**
     * @inheritdoc
     */
    public function getCost()
    {
        $price = $this->getLocalProduct()->get_price();

        return PriceTool::toInteger($price);
    }

    /**
     * @inheritdoc
     */
    public function getQuantity()
    {
        $data = $this->getLocalEntity();

        return $data['quantity'];
    }

    /**
     * @inheritdoc
     */
    protected function preloadProduct()
    {
        /** @var ProductRepositoryInterface $productRepository */
        $productRepository = $this->getService('repository.product');

        return $productRepository->wrapEntity($this->getLocalProduct());
    }

    /**
     * @return localWC_Product
     */
    protected function getLocalProduct()
    {
        $data = $this->getLocalEntity();

        $product = $data['data'];

        return $product;
    }

    public function getProductDescription()
    {
        // not used
    }
}
