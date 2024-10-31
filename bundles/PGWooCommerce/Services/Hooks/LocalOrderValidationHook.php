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

namespace PGI\Module\PGWooCommerce\Services\Hooks;

use PGI\Module\PGModule\Services\Broadcaster;
use PGI\Module\PGShop\Components\Events\LocalOrder as LocalOrderEventComponent;
use PGI\Module\PGShop\Interfaces\Entities\OrderEntityInterface;
use PGI\Module\PGWooCommerce\Services\Repositories\OrderRepository;
use Exception;

/**
 * Class LocalOrderValidationHook
 * @package PGWooCommerce\Services\Hooks
 */
class LocalOrderValidationHook
{
    /** @var Broadcaster */
    private $broadcaster;

    /** @var OrderRepository */
    private $orderRepository;

    private $isAlreadyCalled = false;

    public function __construct(
        Broadcaster $broadcaster,
        OrderRepository $orderRepository
    ) {
        $this->broadcaster = $broadcaster;
        $this->orderRepository = $orderRepository;
    }

    /**
     * @param int $orderId
     * @throws Exception
     */
    public function sendLocalOrderValidationEvent($orderId)
    {
        if (!$this->isAlreadyCalled) {
            $this->isAlreadyCalled = true;

            /** @var OrderEntityInterface $order */
            $order = $this->orderRepository->findByPrimary($orderId);

            if ($order !== null) {
                $this->broadcaster->fire(new LocalOrderEventComponent('validation', $order));
            }
        }
    }
}