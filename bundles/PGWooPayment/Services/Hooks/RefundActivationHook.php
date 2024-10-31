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

use PGI\Module\PGModule\Services\Handlers\BehaviorHandler;
use PGI\Module\PGLog\Interfaces\LoggerInterface;
use Exception;

class RefundActivationHook
{
    /** @var BehaviorHandler */
    private $behaviorHandler;

    /** @var LoggerInterface */
    private $logger;

    public function __construct(
        BehaviorHandler $behaviorHandler,
        LoggerInterface $logger
    ) {
        $this->behaviorHandler = $behaviorHandler;
        $this->logger = $logger;
    }

    public function verify()
    {
        $result = false;

        try {
            $result = $this->behaviorHandler->get('transmission_on_refund');
        } catch (Exception $exception) {
            $this->logger->error("Refund validation error : " . $exception->getMessage(), $exception);
        }

        return $result;
    }
}
