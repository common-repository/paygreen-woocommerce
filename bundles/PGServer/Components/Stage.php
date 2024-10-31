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

namespace PGI\Module\PGServer\Components;

use PGI\Module\PGLog\Interfaces\LoggerInterface;
use PGI\Module\PGServer\Components\Trigger as TriggerComponent;
use PGI\Module\PGServer\Foundations\AbstractResponse;
use PGI\Module\PGSystem\Foundations\AbstractObject;
use Exception;

/**
 * Class Stage
 * @package PGServer\Components
 */
class Stage extends AbstractObject
{
    private $config;

    /** @var TriggerComponent|null */
    private $trigger;

    /** @var LoggerInterface */
    private $logger;

    public $do;

    public $with;

    public function __construct(array $config, TriggerComponent $trigger = null)
    {
        $this->config = $config;
        $this->trigger = $trigger;

        $this->do = strtoupper($this->config['do']);
        $this->with = isset($this->config['with']) ? $this->config['with'] : null;
    }

    /**
     * @param string|null $key
     * @return array|mixed|null
     */
    protected function getConfig($key = null)
    {
        if ($key === null) {
            return $this->config;
        } elseif (array_key_exists($key, $this->config)) {
            return $this->config[$key];
        } else {
            return null;
        }
    }

    /**
     * @return LoggerInterface
     */
    protected function getLogger()
    {
        return $this->logger;
    }

    /**
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param AbstractResponse $response
     * @return bool
     */
    public function isTriggered(AbstractResponse $response)
    {
        return ($this->trigger === null) ? true : $this->trigger->isTriggered($response);
    }

    /**
     * @param AbstractResponse $response
     * @return mixed
     * @throws Exception
     */
    protected function callService(AbstractResponse $response)
    {
        if ($this->with === null) {
            throw new Exception("Server Stage must specify service to perform action.");
        }

        $service = $this->getService($this->with);

        if (!method_exists($service, 'process')) {
            throw new Exception(
                "@{$this->with} is not a valid renderer. Target service must implements 'process' method."
            );
        }

        $arguments = array($response, $this->getConfig('config'));

        return call_user_func_array(array($service, 'process'), $arguments);
    }

    /**
     * @param AbstractResponse $response
     * @return AbstractResponse|null
     * @throws Exception
     */
    public function execute(AbstractResponse $response)
    {
        if ($this->with !== null) {
            $this->getLogger()->debug("Process Response with '@{$this->with}'.");

            return $this->callService($response);
        } else {
            return $response;
        }
    }
}
