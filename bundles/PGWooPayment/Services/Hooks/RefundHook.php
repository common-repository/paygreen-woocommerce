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

namespace PGI\Module\PGWooPayment\Services\Hooks;

use PGI\Module\PGModule\Services\Broadcaster;
use PGI\Module\PGLog\Interfaces\LoggerInterface;
use PGI\Module\PGPayment\Components\Events\Refund as RefundEventComponent;
use PGI\Module\PGShop\Interfaces\Entities\OrderEntityInterface;
use PGI\Module\PGShop\Services\Managers\OrderManager;
use Exception;

class RefundHook
{
    /** @var Broadcaster */
    private $broadcaster;

    /** @var OrderManager */
    private $orderManager;

    /** @var LoggerInterface */
    private $logger;

    public function __construct(
        Broadcaster $broadcaster,
        OrderManager $orderManager,
        LoggerInterface $logger
    ) {
        $this->broadcaster = $broadcaster;
        $this->orderManager = $orderManager;
        $this->logger = $logger;
    }

    public function process($id_order, $amount = null)
    {
        $result = false;

        try {
            /** @var OrderEntityInterface $order */
            $order = $this->orderManager->getByPrimary($id_order);

            $this->broadcaster->fire(new RefundEventComponent($order, $amount));

            $result = true;
        } catch (Exception $exception) {
            $this->logger->error("Refund error : " . $exception->getMessage(), $exception);
        }

        return $result;
    }
}
