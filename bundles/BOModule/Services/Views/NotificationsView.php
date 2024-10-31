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

namespace PGI\Module\BOModule\Services\Views;

use PGI\Module\PGFramework\Services\Notifier;
use PGI\Module\PGView\Services\View;
use Exception;

/**
 * Class NotificationsView
 * @package BOModule\Services\Views
 */
class NotificationsView extends View
{
    /** @var Notifier */
    private $notifier;

    private static $NOTIFICATION_CODES = array(
        Notifier::STATE_FAILURE => 'failure',
        Notifier::STATE_NOTICE => 'notice',
        Notifier::STATE_SUCCESS => 'success'
    );

    public function __construct(Notifier $notifier)
    {
        $this->notifier = $notifier;

        $this->setTemplate('block-notifications');
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getData()
    {
        $notifications = $this->notifier->collect();

        array_walk($notifications, array($this, 'formatNotification'));

        return array(
            'notifications' => $notifications
        );
    }

    public function formatNotification(array &$notification)
    {
        if (!array_key_exists('type', $notification)) {
            throw new Exception("Notification must contains 'type' key.");
        }

        $type = $notification['type'];

        $notification['type'] = self::$NOTIFICATION_CODES[$type];
    }
}
