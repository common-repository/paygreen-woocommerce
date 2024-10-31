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

namespace PGI\Module\PGFramework\Services\Listeners;

use PGI\Module\PGModule\Services\Handlers\StaticFileHandler;
use PGI\Module\PGLog\Interfaces\LoggerInterface;
use Exception;

/**
 * Class InstallStaticFilesListener
 * @package PGFramework\Services\Listeners
 */
class InstallStaticFilesListener
{
    /** @var StaticFileHandler */
    private $staticFileHandler;

    /** @var LoggerInterface */
    private $logger;

    public function __construct(StaticFileHandler $staticFileHandler, LoggerInterface $logger)
    {
        $this->staticFileHandler = $staticFileHandler;
        $this->logger = $logger;
    }

    public function installStaticFiles()
    {
        try {
            if ($this->staticFileHandler->isInstallRequired()) {
                $this->logger->info("Install static files.");
                $this->staticFileHandler->installStaticFiles();
            } else {
                $this->logger->notice("Static file installation is not required.");
            }
        } catch (Exception $exception) {
            $this->logger->error("Error during static file installation : " . $exception->getMessage(), $exception);
        }
    }
}
