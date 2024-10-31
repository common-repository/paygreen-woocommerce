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

namespace PGI\Module\PGWordPress\Services\Officers;

use PGI\Module\PGFramework\Foundations\AbstractService;

/**
 * Class ScheduleEventOfficer
 * @package PGWordPress\Services\Officers
 */
class ScheduleEventOfficer extends AbstractService
{
    /**
     * @param int $timestamp
     * @param string $hook
     * @param string $recurrence
     * @param array $params
     * @return bool
     */
    public function schedule($timestamp, $hook, $recurrence, $params = array())
    {
        $this->log()->debug("Schedule '$recurrence' event on '$hook' hook.");

        if (!$this->getNextScheduled($hook, $params)) {
            $result = wp_schedule_event($timestamp, $recurrence, $hook, $params);

            if ($result) {
                $this->log()->debug("'$recurrence' event successfully scheduled on '$hook' hook.");
            } else {
                $this->log()->debug("Event scheduling on '$hook' hook has failed.");
            }
        } else {
            $this->log()->debug("'$hook' event already scheduled.");
            $result = false;
        }

        return $result;
    }

    /**
     * @param string $hook
     * @param array $params
     * @return int|bool
     */
    public function getNextScheduled($hook, $params = array())
    {
        return wp_next_scheduled($hook, $params);
    }

    /**
     * @param int $timestamp
     * @param string $hook
     * @param array $params
     * @return bool
     */
    public function unschedule($timestamp, $hook, $params = array())
    {
        $result = wp_unschedule_event($timestamp, $hook, $params);

        if ($result) {
            $this->log()->debug("The '$hook' event was successfully deprogrammed.");
        } else {
            $this->log()->debug("The deprogramming of the '$hook' event failed.");
        }

        return $result;
    }

    /**
     * @param string $hook
     * @param array $params
     * @return void
     */
    public function clear($hook, $params = array())
    {
        $result = wp_clear_scheduled_hook($hook, $params);

        if (is_int($result)) {
            if ($result === 0) {
                $this->log()->debug("No events were scheduled with this hook and arguments combination.");
            }

            if ($result > 0) {
                $this->log()->debug("'$result' scheduled events were been deprogrammed.");
            }
        } else {
            $this->log()->debug("Clearing scheduled events for '$hook' hook has failed.");
        }
    }
}