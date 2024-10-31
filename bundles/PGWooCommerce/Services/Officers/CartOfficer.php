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

use Exception;
use PGI\Module\PGShop\Interfaces\Entities\ShopableItemEntityInterface;
use PGI\Module\PGLog\Interfaces\LoggerInterface;
use PGI\Module\PGShop\Interfaces\Entities\CartEntityInterface;
use PGI\Module\PGShop\Interfaces\Entities\ProductEntityInterface;
use PGI\Module\PGShop\Interfaces\Officers\CartOfficerInterface;

/**
 * Class CartOfficer
 * @package PGWooCommerce\Services\Officers
 */
class CartOfficer implements CartOfficerInterface
{
    /** @var ProductVariationOfficer */
    private $productVariationOfficer;

    /** @var LoggerInterface */
    private $logger;

    public function __construct(ProductVariationOfficer $productVariationOfficer, LoggerInterface $logger)
    {
        $this->productVariationOfficer = $productVariationOfficer;
        $this->logger = $logger;
    }

    /**
     * @inerhitDoc
     * @throws Exception
     */
    public function addItem(CartEntityInterface $cart, ProductEntityInterface $product, $cost, $variationAttribute = "")
    {
        $this->logger->debug("Adding item '{$product->id()}' to the cart. with variation product : '{$variationAttribute}'");

        $variationProductId = $this->productVariationOfficer->create($product, $cost, $variationAttribute);

        if ($variationProductId !== null) {
            $result = $cart->getLocalEntity()->add_to_cart(
                $variationProductId,
                1,
                0,
                array()
            );

            if ($result) {
                $this->logger->debug("Item '$variationProductId' successfully added to the cart.");
            } else {
                $this->logger->debug("An error occurred while adding item '$variationProductId' to the cart.");
            }
        } else {
            $this->logger->debug("An error occurred while creating the product '{$product->id()}' variation.");
        }
    }

    /**
     * @inerhitDoc
     * @throws Exception
     */
    public function removeItem(CartEntityInterface $cart, ProductEntityInterface $product)
    {
        $this->logger->debug("Removing item '{$product->id()}' from the cart.");

        $cartItemKey = null;

        /** @var ShopableItemEntityInterface $item */
        foreach ($cart->getItems() as $item) {
            if ($item->getProduct()->id() === $product->id()) {
                $localCartItem = $item->getLocalEntity();
                $cartItemKey = $localCartItem['key'];
            }
        }

        if ($cartItemKey !== null) {
            $this->productVariationOfficer->remove($product, $cart);
            $result = $cart->getLocalEntity()->remove_cart_item($cartItemKey);

            if ($result) {
                $this->logger->debug("Item '{$product->id()}' successfully removed from the cart.");
            } else {
                $this->logger->debug("An error occurred while removing item '{$product->id()}' from the cart.");
            }
        } else {
            throw new Exception("Cart item key not found for product '{$product->id()}'.");
        }

        return $result;
    }
}