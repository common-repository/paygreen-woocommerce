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

namespace PGI\Module\PGFramework\Services\Handlers;

use PGI\Module\PGFramework\Interfaces\SuperglobalInterface;
use PGI\Module\PGLog\Interfaces\LoggerInterface;

/**
 * Class CookieHandler
 * @package PGFramework\Services\Handlers
 */
class CookieHandler
{
    /** @var SuperglobalInterface */
    private $cookieAdapter;
    
    /** @var LoggerInterface */
    private $logger;

    public function __construct(
        SuperglobalInterface $cookieAdapter,
        LoggerInterface $logger
    ) {
        $this->cookieAdapter = $cookieAdapter;
        $this->logger = $logger;
    }

    /**
     * @param string $var
     * @return mixed|null
     */
    public function get($var)
    {
        if ($this->has($var)) {
            return $this->cookieAdapter[$var];
        } else {
            $this->logger->error("Cookie var not found : '$var'.");
        }

        return null;
    }

    /**
     * @param string $var
     * @return bool
     */
    public function has($var)
    {
        return isset($this->cookieAdapter[$var]);
    }

    /**
     * @param string $var
     * @return void
     */
    public function set($var, $val)
    {
        $this->cookieAdapter[$var] = $val;
    }
}
