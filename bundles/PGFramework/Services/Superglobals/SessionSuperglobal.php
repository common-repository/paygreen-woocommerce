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

namespace PGI\Module\PGFramework\Services\Superglobals;

use PGI\Module\PGFramework\Interfaces\SuperglobalInterface;
use PGI\Module\PGLog\Interfaces\LoggerInterface;

/**
 * Class SessionSuperglobal
 * @package PGFramework\Services\Superglobals
 */
class SessionSuperglobal implements SuperglobalInterface
{
    protected $data = array();

    /** @var LoggerInterface */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function toArray()
    {
        return $this->data;
    }

    /**
     * @return bool
     */
    protected function isSessionInit()
    {
        if (!function_exists('session_status') || !function_exists('session_start')) {
            $this->logger->error("Unavailable session functions.");
        } elseif (call_user_func('session_status') === constant('PHP_SESSION_DISABLED')) {
            $this->logger->error("Sessions are not available.");
        } elseif (call_user_func('session_status') === constant('PHP_SESSION_ACTIVE')) {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    protected function checkSession()
    {
        $result = true;

        if (!$this->isSessionInit()) {
            $result = session_start();
        }

        if (isset($_SESSION) && is_array($_SESSION)) {
            $this->data = &$_SESSION;
        } else {
            $this->logger->alert("Session superglobal is unavailable.");
        }

        return $result;
    }

    // ###################################################################
    // ###       table access functions
    // ###################################################################

    #[\ReturnTypeWillChange]
    public function offsetGet($name)
    {
        if ($this->checkSession()) {
            return isset($this[$name]) ? $this->data[$name] : null;
        }

        return null;
    }

    #[\ReturnTypeWillChange]
    public function offsetExists($name)
    {
        if ($this->checkSession()) {
            return array_key_exists($name, $this->data);
        }

        return false;
    }

    public function offsetSet($name, $value)
    {
        if ($this->checkSession()) {
            $this->data[$name] = $value;
        }
    }

    #[\ReturnTypeWillChange]
    public function offsetUnset($name)
    {
        if ($this->checkSession()) {
            if (isset($this[$name])) {
                unset($this->data[$name]);
            }
        }
    }

    // ###################################################################
    // ###       iterator functions
    // ###################################################################

    #[\ReturnTypeWillChange]
    public function rewind()
    {
        if ($this->checkSession()) {
            reset($this->data);
        }
    }

    #[\ReturnTypeWillChange]
    public function current()
    {
        if ($this->checkSession()) {
            return current($this->data);
        }

        return false;
    }

    #[\ReturnTypeWillChange]
    public function key()
    {
        if ($this->checkSession()) {
            return key($this->data);
        }
      
        return false;
    }

    #[\ReturnTypeWillChange]
    public function next()
    {
        if ($this->checkSession()) {
            next($this->data);
        }
    }

    #[\ReturnTypeWillChange]
    public function valid()
    {
        if ($this->checkSession()) {
            return key($this->data) !== null;
        }

        return false;
    }
}
