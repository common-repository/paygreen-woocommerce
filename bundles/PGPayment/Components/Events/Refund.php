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

namespace PGI\Module\PGPayment\Components\Events;

use PGI\Module\PGModule\Foundations\AbstractEvent;
use PGI\Module\PGShop\Interfaces\Entities\OrderEntityInterface;

/**
 * Class Refund
 * @package PGPayment\Components\Events
 */
class Refund extends AbstractEvent
{
    /** @var OrderEntityInterface */
    private $order;

    /** @var float */
    private $amount;

    public function __construct(OrderEntityInterface $order, $amount = 0)
    {
        $this->order = $order;
        $this->amount = $amount;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ORDER.REFUND';
    }

    /**
     * @return OrderEntityInterface
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }
}
