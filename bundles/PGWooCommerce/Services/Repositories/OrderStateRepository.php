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

use PGI\Module\PGDatabase\Foundations\AbstractRepositoryWrapped;
use PGI\Module\PGShop\Interfaces\Repositories\OrderStateRepositoryInterface;
use Exception;

/**
 * Class OrderStateRepository
 * @package PGWooCommerce\Services\Repositories
 */
class OrderStateRepository extends AbstractRepositoryWrapped implements OrderStateRepositoryInterface
{
    /**
     * @inheritdoc
     * @throws Exception
     */
    public function findByPrimary($id)
    {
        throw new Exception("Not implemented.");
    }

    /**
     * @inheritdoc
     * @throws Exception
     */
    public function create($code, $name, array $metadata = array())
    {
        throw new Exception("Not implemented.");
    }

    /**
     * @inheritdoc
     * @throws Exception
     */
    protected function createOrderStateEntity($setting_name, $name, array $metadata = array())
    {
        throw new Exception("Not implemented.");
    }

    /**
     * @inheritdoc
     * @throws Exception
     */
    public function wrapEntity($localEntity)
    {
        throw new Exception("Not implemented.");
    }
}
