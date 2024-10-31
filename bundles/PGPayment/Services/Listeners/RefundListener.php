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

namespace PGI\Module\PGPayment\Services\Listeners;

use PGI\Module\PGModule\Services\Handlers\BehaviorHandler;
use PGI\Module\PGLog\Interfaces\LoggerInterface;
use PGI\Module\PGPayment\Components\Events\Refund as RefundEventComponent;
use PGI\Module\PGPayment\Exceptions\Unrefundable as UnrefundableException;
use PGI\Module\PGPayment\Services\Handlers\RefundHandler;
use Exception;

/**
 * Class RefundListener
 * @package PGPayment\Services\Listeners
 */
class RefundListener
{
    /** @var RefundHandler */
    private $refundHandler;

    /** @var BehaviorHandler */
    private $behaviorHandler;

    /** @var LoggerInterface */
    private $logger;

    public function __construct(
        RefundHandler $refundHandler,
        BehaviorHandler $behaviorHandler,
        LoggerInterface $logger
    ) {
        $this->refundHandler = $refundHandler;
        $this->behaviorHandler = $behaviorHandler;
        $this->logger = $logger;
    }

    public function listen(RefundEventComponent $event)
    {
        $this->logger->debug("Refund event catched.");

        try {
            $isRefundActivated = (bool) $this->behaviorHandler->get('transmission_on_refund');

            if ($isRefundActivated) {
                $this->logger->debug("Online refund activated.");

                $this->refundHandler->refundOrder($event->getOrder(), $event->getAmount());
            }
        } catch (UnrefundableException $exception) {
            $this->logger->notice(
                "Order #{$event->getOrder()->id()} is not refundable : " . $exception->getMessage()
            );
        } catch (Exception $exception) {
            $this->logger->error(
                "Error during refund order #{$event->getOrder()->id()} : " . $exception->getMessage(),
                $exception
            );
        }
    }
}
