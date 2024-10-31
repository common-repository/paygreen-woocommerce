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

use PGI\Module\PGLog\Interfaces\LoggerInterface;
use PGI\Module\PGModule\Services\Broadcaster;
use PGI\Module\PGShop\Components\Events\LocalOrder as LocalOrderEventComponent;
use PGI\Module\PGShop\Interfaces\Entities\OrderEntityInterface;
use Exception;
use PGI\Module\PGWooCommerce\Services\Repositories\OrderRepository;

class OrderStateUpdateHook
{
    /** @var OrderRepository */
    private $orderRepository;

    /** @var Broadcaster */
    private $broadcaster;

    /** @var LoggerInterface */
    private $logger;

    public function __construct(
        OrderRepository $orderRepository,
        Broadcaster $broadcaster,
        LoggerInterface $logger
    ) {
        $this->orderRepository = $orderRepository;
        $this->broadcaster = $broadcaster;
        $this->logger = $logger;
    }

    public function validateLocalOrder($id_order, $old_status, $new_status)
    {
        try {
            /** @var OrderEntityInterface $order */
            $order = $this->orderRepository->findByPrimary($id_order);

            if ($order === null) {
                $this->logger->error("No order found with ID #$id_order.");
            } elseif ($new_status === 'completed' && ($old_status === 'on-hold' || $old_status === 'pending')) {
                $this->broadcaster->fire(new LocalOrderEventComponent('validation', $order));
            } elseif ($new_status === 'processing' && ($old_status === 'on-hold' || $old_status === 'pending')) {
                $this->broadcaster->fire(new LocalOrderEventComponent('validation', $order));
            } else {
                $this->logger->debug("No event handler on order state : '$new_status'.");
            }
        } catch (Exception $exception) {
            $this->logger->error("Error in OrderStateUpdate hook : " . $exception->getMessage(), $exception);
        }
    }
}
