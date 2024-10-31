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

use WC_Product as LocalWC_Product;
use PGI\Module\PGShop\Foundations\Entities\AbstractProductEntity;
use PGI\Module\PGShop\Interfaces\Entities\ProductEntityInterface;
use PGI\Module\PGShop\Services\Managers\CategoryManager;

/**
 * Class PGModuleEntitiesCustomer
 *
 * @package PGWooCommerce\Entities
 * @method LocalWC_Product getLocalEntity()
 */
class Product extends AbstractProductEntity implements ProductEntityInterface
{
    /**
     * @inheritdoc
     */
    public function id()
    {
        return $this->getLocalEntity()->get_id();
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return $this->getLocalEntity()->get_title();
    }

    /**
     * @inheritdoc
     */
    public function getWeight()
    {
        return (float) $this->getLocalEntity()->get_weight();
    }

    /**
     * @inheritdoc
     */
    public function getReference()
    {
        return $this->getLocalEntity()->get_slug();
    }

    /**
     * @inheritdoc
     */
    public function isVirtual()
    {
        return $this->getLocalEntity()->is_virtual();
    }

    /**
     * @inheritdoc
     */
    protected function preloadCategories()
    {
        /** @var CategoryManager $categoryManager */
        $categoryManager = $this->getService('manager.category');

        $categories = array();

        foreach ($this->getLocalEntity()->get_category_ids() as $id_category) {
            $category = $categoryManager->getByPrimary($id_category);

            if ($category !== null) {
                $categories[] = $category;
            }
        }

        return $categories;
    }

    /**
     * @inheritdoc
     */
    public function getPrice()
    {
        return $this->getLocalEntity()->get_price();
    }
}
