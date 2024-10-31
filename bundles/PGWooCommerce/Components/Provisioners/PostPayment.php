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

namespace PGI\Module\PGWooCommerce\Components\Provisioners;

use PGI\Module\APIPayment\Components\Replies\Transaction as TransactionReplyComponent;
use PGI\Module\PGShop\Interfaces\Provisioners\PostPaymentProvisionerInterface;
use PGI\Module\PGShop\Tools\Price as PriceTool;
use PGI\Module\PGSystem\Foundations\AbstractObject;
use Exception;

class PostPayment extends AbstractObject implements PostPaymentProvisionerInterface
{
    /** @var string */
    private $pid;

    /** @var WC_Order|null  */
    private $order = null;

    /** @var TransactionReplyComponent */
    private $transaction;

    /**
     * PostPayment constructor.
     * @param string $pid
     * @param TransactionReplyComponent $transaction
     * @throws Exception
     */
    public function __construct($pid, TransactionReplyComponent $transaction)
    {
        $this->pid = $pid;
        $this->transaction = $transaction;

        $this->loadOrder();
    }

    /**
     * @throws Exception
     */
    protected function loadOrder()
    {
        $id = (int) $this->getTransaction()->getMetadata('order_id');

        $this->order = wc_get_order($id);

        if (!$this->order) {
            throw new Exception("Order #$id not found.");
        }
    }

    /**
     * @return string
     */
    public function getPid()
    {
        return $this->pid;
    }

    /**
     * @return TransactionReplyComponent
     */
    public function getTransaction()
    {
        return $this->transaction;
    }

    /**
     * @return float
     * @throws Exception
     */
    public function getUserAmount()
    {
        $price = $this->order->get_total();

        return PriceTool::fixFloat($price);
    }
}
