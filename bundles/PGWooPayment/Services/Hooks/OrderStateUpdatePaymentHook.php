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

use PGI\Module\PGLog\Interfaces\LoggerInterface;
use PGI\Module\PGPayment\Services\Handlers\TokenizeHandler;
use PGI\Module\PGShop\Interfaces\Entities\OrderEntityInterface;
use PGI\Module\PGShop\Services\Managers\OrderManager;
use Exception;

class OrderStateUpdatePaymentHook
{
    /** @var TokenizeHandler */
    private $tokenizeHandler;

    /** @var OrderManager */
    private $orderManager;

    /** @var LoggerInterface */
    private $logger;

    public function __construct(
        TokenizeHandler $tokenizeHandler,
        OrderManager $orderManager,
        LoggerInterface $logger
    ) {
        $this->tokenizeHandler = $tokenizeHandler;
        $this->orderManager = $orderManager;
        $this->logger = $logger;
    }

    public function process($id_order, $old_status, $new_status)
    {
        try {
            /** @var OrderEntityInterface $order */
            $order = $this->orderManager->getByPrimary($id_order);

            if ($order === null) {
                $this->logger->error("No order found with ID #$id_order.");
            } elseif (($new_status === 'completed') && ($old_status === 'pg-auth')) {
                if ($this->tokenizeHandler->processTokenizedPayments($order)) {
                    $this->logger->info("Shipping validation success.");
                } else {
                    $this->logger->error("Shipping validation failure.");
                    return false;
                }
            } else {
                $this->logger->debug("No event handler on order state : '$new_status'.");
            }
        } catch (Exception $exception) {
            $this->logger->error("Error in OrderStateUpdate hook : " . $exception->getMessage(), $exception);
        }
    }
}
