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

use DateTime;
use Exception;
use PGI\Module\PGLog\Interfaces\LoggerInterface;
use PGI\Module\PGShop\Interfaces\Entities\CartEntityInterface;
use PGI\Module\PGShop\Interfaces\Entities\ProductEntityInterface;
use PGI\Module\PGShop\Interfaces\Entities\ShopableItemEntityInterface;
use WC_DateTime as LocalWC_DateTime;
use WC_Product_Variation as LocalWC_Product_Variation;

/**
 * Class ProductVariationOfficer
 * @package PGWooCommerce\Services\Officers
 */
class ProductVariationOfficer
{
    /** @var LoggerInterface */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param ProductEntityInterface $product
     * @param int $cost
     * @param string $variationAttribute
     * @return int|null
     */
    public function create(ProductEntityInterface $product, $cost, $variationAttribute = "")
    {
        try {
            $this->logger->debug("Create a product variation of the product '{$product->id()}'");

            $variationPost = array(
                'post_title' => $product->getName(),
                'post_name' => $product->getReference() . '-variation',
                'post_parent' => $product->id(),
                'post_type' => 'product_variation',
                'post_status' => 'publish',
                'guid' => $product->getLocalEntity()->get_permalink()
            );

            $variationProductId = wp_insert_post($variationPost);

            $variationProduct = new LocalWC_Product_Variation($variationProductId);

            $variationProduct->set_regular_price($cost);
            $variationProduct->set_stock_quantity(1);
            $variationProduct->set_manage_stock(true);
            $variationProduct->set_stock_status('');
            $variationProduct->set_description($variationAttribute);

            $variationProduct->set_attributes(array(
                'pg_variation_attribute' => 'gift'
            ));

            $variationProduct->save();

            $this->logger->debug('Product variation successfully created.');

            return $variationProductId;
        } catch (Exception $exception) {
            $this->logger->error('An error occurred while creating a product variation.', $exception);
            return null;
        }
    }

    /**
     * @param ProductEntityInterface $product
     * @param CartEntityInterface $cart
     * @return bool
     */
    public function remove(ProductEntityInterface $product, CartEntityInterface $cart)
    {
        $result = false;

        try {
            /** @var ShopableItemEntityInterface[] $cartItems */
            $cartItems = $cart->getItems();

            /** @var LocalWC_Product_Variation[] $productVariations */
            $productVariations = $this->getVariations($product);

            foreach ($cartItems as $item) {
                $localItem = $item->getLocalEntity();

                foreach ($productVariations as $variation) {
                    if ($localItem['variation_id'] === $variation->get_id())
                    {
                        $variationProduct = new LocalWC_Product_Variation($localItem['variation_id']);

                        $result = $variationProduct->delete(true);

                        if ($result) {
                            $this->logger->debug("Product variation successfully removed.");
                        } else {
                            throw new Exception('Product variation removing has failed.');
                        }
                    }
                }
            }
        } catch (Exception $exception) {
            $this->logger->error('An error occurred while removing the product variation.', $exception);
        }

        return $result;
    }

    /**
     * @param ProductEntityInterface $product
     * @param int $cost
     * @return bool
     */
    public function exist(ProductEntityInterface $product, $cost)
    {
        /** @var LocalWC_Product_Variation[] $productVariations */
        $productVariations = $this->getVariations($product);

        /** @var LocalWC_Product_Variation $productVariation */
        foreach ($productVariations as $productVariation) {
            if ($productVariation->get_regular_price() === $cost) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param ProductEntityInterface $product
     * @return void
     */
    public function clean(ProductEntityInterface $product)
    {
        try {
            /** @var LocalWC_Product_Variation[] $productVariations */
            $productVariations = $this->getVariations($product);

            /** @var LocalWC_Product_Variation $productVariation */
            foreach ($productVariations as $productVariation) {
                if (!$this->isVariationStillActive($productVariation)) {
                    $productVariation->delete(true);
                }
            }

            $this->logger->debug("'{$product->getName()}' product variations successfully cleaned.");
        } catch (Exception $exception) {
            $this->logger->error('An error occurred while cleaning product variations.', $exception);
        }
    }

    /**
     * @return LocalWC_Product_Variation[]
     */
    private function getVariations(ProductEntityInterface $product)
    {
        /** @var LocalWC_Product_Variation[] $productVariations */
        return $product->getLocalEntity()->get_available_variations('objects');
    }

    /**
     * @param LocalWC_Product_Variation $variation
     * @return bool
     */
    private function isVariationStillActive(LocalWC_Product_Variation $variation)
    {
        $hasStock = ($variation->get_stock_quantity() > 0);
        $isOutdated = false;

        /** @var LocalWC_DateTime|null $variationCreatedAt */
        $variationCreatedAt = $variation->get_date_created();

        if ($variationCreatedAt !== null) {
            $currentDatetime = new DateTime();
            $currentTimestamp = $currentDatetime->getTimestamp();

            $isOutdated = ($variationCreatedAt->getTimestamp() < ($currentTimestamp - 864000));
        }

        return ($hasStock && !$isOutdated);
    }
}