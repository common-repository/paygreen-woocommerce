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
use PGI\Module\PGShop\Interfaces\Repositories\CarrierRepositoryInterface;
use PGI\Module\PGWooCommerce\Entities\Carrier;
use WC_Shipping_Zones;

class CarrierRepository extends AbstractRepositoryWrapped implements CarrierRepositoryInterface
{
    /**
     * @param array $localEntity
     * @return Carrier
     */
    public function wrapEntity($localEntity)
    {
        return new Carrier($localEntity);
    }

    public function findByPrimary($id)
    {
        $result = array();
        $methods = $this->getAllMethods();

        foreach ($methods as $method) {
            foreach ($method as $delivery) {
                if ($delivery->instance_id = $id) {
                    $result = array(
                        "id" => $delivery->instance_id,
                        "name" => $delivery->id,
                        "enabled" => $delivery->enabled
                    );
                }
            }
        };

        return $this->wrapEntity($result);
    }

    /**
     * @inheritdoc
     */
    public function findAll()
    {
        $result = array();
        $methods = $this->getAllMethods();

        foreach ($methods as $method) {
            foreach ($method as $delivery) {
                $result[] = array(
                    "id" => $delivery->instance_id,
                    "name" => $delivery->id,
                    "enabled" => $delivery->enabled
                );
            }
        }

        return $this->wrapEntities($result);
    }

    /**
     * @return array
     */
    public function getAllMethods()
    {
        $zones = WC_Shipping_Zones::get_zones();

        return array_map(function($zone) {
            return $zone['shipping_methods'];
        }, $zones);
    }

}
