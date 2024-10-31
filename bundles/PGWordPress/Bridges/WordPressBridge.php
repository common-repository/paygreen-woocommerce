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

namespace PGI\Module\PGWordPress\Bridges;

use PGI\Module\PGFramework\Services\Handlers\HookHandler;
use PGI\Module\PGSystem\Components\Parameters as ParametersComponent;
use PGI\Module\PGSystem\Foundations\AbstractObject;
use Exception;

class WordPressBridge extends AbstractObject
{
    /**
     * PGModuleBridgesWordpressBridge constructor.
     * @throws Exception
     */
    public function __construct()
    {
        $this->getService('container')->set('bridge.wordpress', $this);

        /** @var HookHandler $hookHandler */
        $hookHandler = $this->getService('handler.hook');

        register_activation_hook(PAYGREEN_MODULE_FILE, $hookHandler->addHookName('setup', 'activate'));

        $this->initHooks();
    }

    /**
     * @throws Exception
     */
    private function initHooks()
    {
        /** @var HookHandler $hookHandler */
        $hookHandler = $this->getService('handler.hook');

        /** @var ParametersComponent $parameters */
        $parameters = $this->getService('parameters');

        $wordPressHooks = $parameters['wp.hooks'];

        foreach($wordPressHooks as $wordPressHook) {
            if (!array_key_exists('filter', $wordPressHook)) {
                throw new Exception("WordPress hook require 'filter' key.");
            } elseif (!array_key_exists('hook', $wordPressHook)) {
                throw new Exception("WordPress hook require 'hook' key.");
            }

            $method = array_key_exists('method', $wordPressHook) ? $wordPressHook['method'] : 'filter';
            $priority = array_key_exists('priority', $wordPressHook) ? $wordPressHook['priority'] : 10;
            $args = array_key_exists('args', $wordPressHook) ? $wordPressHook['args'] : 1;
            $direct = array_key_exists('direct', $wordPressHook) ? $wordPressHook['direct'] : false;

            if ($direct) {
                $hook = array(
                    $this->getService('hook.' . $wordPressHook['hook']),
                    $method
                );
            } else {
                $hook = $hookHandler->addHookName(
                    $wordPressHook['hook'],
                    $method
                );
            }


            add_filter(
                $wordPressHook['filter'],
                $hook,
                $priority,
                $args
            );
        }
    }
}
