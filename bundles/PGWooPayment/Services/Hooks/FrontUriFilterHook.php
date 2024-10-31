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
use PGI\Module\PGServer\Services\Server;
use PGI\Module\PGWordPress\Services\Linkers\HomeLinker;
use Exception;

class FrontUriFilterHook
{
    /** @var HomeLinker $linker */
    private $linker;

    /** @var Server $server */
    private $server;

    /** @var LoggerInterface $logger */
    private $logger;

    public function __construct(
        HomeLinker $linker,
        Server $server,
        LoggerInterface $logger
    ) {
        $this->linker = $linker;
        $this->server = $server;
        $this->logger = $logger;
    }

    public function filter()
    {
        $isPayGreenRequest = (isset($_GET['pgaction']) || isset($_POST['pgaction']));

        if ($isPayGreenRequest && (preg_match('/paygreen-frontoffice/', $_SERVER['REQUEST_URI']))) {
            $this->logger->debug("Wrong front URI detected.");

            if (isset($_GET['pgaction'])) {
                $action = $_GET['pgaction'];
                $queryArgs = http_build_query($_GET);
            } else {
                $action = $_POST['pgaction'];
                $queryArgs = http_build_query($_POST);
            }

            switch ($action) {
                case 'front.payment.receive':
                    $this->postProcess();
                    break;
                case 'front.payment.process_customer_return':
                    $uri = $this->linker->buildUrl() . DIRECTORY_SEPARATOR . '?' . $queryArgs;
                    wp_redirect($uri);
                    exit;
                default:
                    break;
            }
        }
    }

    /**
     * @throws Exception
     */
    public function postProcess()
    {
        $this->logger->debug("Request incoming in front office endpoint.");

        try {
            $this->server->run();
        } catch (Exception $exception) {
            $this->logger->error("Front controller error : " . $exception->getMessage(), $exception);
            header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
            die();
        }
    }
}
