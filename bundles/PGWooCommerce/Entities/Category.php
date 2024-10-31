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

use WP_Term as LocalWP_Term;
use PGI\Module\PGShop\Foundations\Entities\AbstractCategoryEntity;

/**
 * Class Category
 *
 * @method LocalWP_Term getLocalEntity()
 */
class Category extends AbstractCategoryEntity
{
    /**
     * @inheritdoc
     */
    public function id()
    {
        return (int) $this->getLocalEntity()->term_taxonomy_id;
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return (string) $this->getLocalEntity()->name;
    }

    /**
     * @inheritdoc
     */
    public function getSlug()
    {
        return (string) $this->getLocalEntity()->slug;
    }

    /**
     * @inheritdoc
     */
    public function getParentId()
    {
        return $this->getLocalEntity()->parent;
    }
}
