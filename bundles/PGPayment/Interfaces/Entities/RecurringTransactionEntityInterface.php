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

namespace PGI\Module\PGPayment\Interfaces\Entities;

use PGI\Module\PGDatabase\Interfaces\EntityPersistedInterface;
use PGI\Module\PGShop\Interfaces\Entities\OrderEntityInterface;
use DateTime;

/**
 * Interface RecurringTransactionEntityInterface
 * @package PGPayment\Interfaces\Entities
 */
interface RecurringTransactionEntityInterface extends EntityPersistedInterface
{
    /**
     * @return string
     */
    public function getPid();

    /**
     * @return int
     */
    public function getOrderPrimary();

    /**
     * @return OrderEntityInterface
     */
    public function getOrder();

    /**
     * @return string
     */
    public function getState();

    /**
     * @return string
     */
    public function getStateOrderBefore();

    /**
     * @return string
     */
    public function getStateOrderAfter();

    /**
     * @param string $stateOrderAfter
     * @return self
     */
    public function setStateOrderAfter($stateOrderAfter);

    /**
     * @return string
     */
    public function getMode();

    /**
     * @return int
     */
    public function getAmount();

    /**
     * @return int
     */
    public function getRank();

    /**
     * @return DateTime
     */
    public function getCreatedAt();
}
