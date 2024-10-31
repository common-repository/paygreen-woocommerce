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

namespace PGI\Module\PGWordPress\Services\Hooks;

use PGI\Module\PGModule\Services\Handlers\DiagnosticHandler;
use Exception;
use PGI\Module\PGLog\Interfaces\LoggerInterface;
use PGI\Module\PGShop\Services\Handlers\ShopHandler;

class SetupHook
{
    /** @var DiagnosticHandler */
    private $diagnosticHandler;

    /** @var ShopHandler */
    private $shopHandler;

    /** @var LoggerInterface */
    private $logger;

    public function __construct(
        DiagnosticHandler $diagnosticHandler,
        ShopHandler $shopHandler,
        LoggerInterface $logger
    ) {
        $this->diagnosticHandler = $diagnosticHandler;
        $this->shopHandler = $shopHandler;
        $this->logger = $logger;
    }

    /**
     * @throws Exception
     */
    public function activate($networkActivation)
    {
        if ($networkActivation && (function_exists('is_multisite') && is_multisite())) {
            $this->logger->notice('Network activation detected.');

            foreach (get_sites(array('fields'=>'ids')) as $shopId) {
                switch_to_blog($shopId);

                $this->logger->debug("Switch to shop '$shopId'.");

                $this->shopHandler->clear();
                $this->diagnosticHandler->run();
                restore_current_blog();
            }

        } else {
            $this->diagnosticHandler->run();
        }
    }
}
