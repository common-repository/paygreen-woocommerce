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

namespace PGI\Module\PGPayment\Entities;

use PGI\Module\PGDatabase\Foundations\AbstractEntityPersisted;
use PGI\Module\PGPayment\Interfaces\Entities\LockEntityInterface;
use DateTime;
use Exception;

/**
 * Class Lock
 * @package PGPayment\Entities
 */
class Lock extends AbstractEntityPersisted implements LockEntityInterface
{
    /**
     * @inheritdoc
     */
    public function getPid()
    {
        return $this->get('pid');
    }

    /**
     * @inheritdoc
     * @throws Exception
     */
    public function getLockedAt()
    {
        $timestamp = (int) $this->get('locked_at');

        $dt = new DateTime();

        return $dt->setTimestamp($timestamp);
    }

    /**
     * @inheritdoc
     */
    public function setLockedAt(DateTime $lockedAt)
    {
        return $this->set('locked_at', $lockedAt->getTimestamp());
    }
}
