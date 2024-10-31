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

namespace PGI\Module\PGPayment\Services\Managers;

use PGI\Module\APIPayment\Components\Replies\Transaction as TransactionReplyComponent;
use PGI\Module\PGDatabase\Foundations\AbstractManager;
use PGI\Module\PGPayment\Components\Tasks\TransactionManagement as TransactionManagementTaskComponent;
use PGI\Module\PGPayment\Interfaces\Entities\ProcessingEntityInterface;
use PGI\Module\PGPayment\Interfaces\Repositories\ProcessingRepositoryInterface;
use PGI\Module\PGShop\Interfaces\Entities\OrderEntityInterface;
use PGI\Module\PGShop\Interfaces\Entities\ShopEntityInterface;
use DateTime;
use Exception;

/**
 * Class ProcessingManager
 *
 * @package PGPayment\Services\Managers
 * @method ProcessingRepositoryInterface getRepository()
 */
class ProcessingManager extends AbstractManager
{
    /**
     * @param string $reference
     * @return ProcessingEntityInterface|null
     */
    public function getSuccessedProcessingByReference($reference)
    {
        return $this->getRepository()->findSuccessedProcessingByReference($reference);
    }

    /**
     * @param string $reference
     * @param bool $isSuccess
     * @param ShopEntityInterface $shop
     * @param TransactionManagementTaskComponent $paymentValidationTask
     * @param TransactionReplyComponent $transaction
     * @param OrderEntityInterface|null $order
     * @param string $stateFrom
     * @return ProcessingEntityInterface
     * @throws Exception
     */
    public function create(
        $reference,
        $isSuccess,
        ShopEntityInterface $shop,
        TransactionManagementTaskComponent $paymentValidationTask,
        TransactionReplyComponent $transaction,
        OrderEntityInterface $order = null,
        $stateFrom = null
    ) {
        $taskStatus = $paymentValidationTask->getStatusName($paymentValidationTask->getStatus());

        $data = array(
            'id_shop' => $shop->id(),
            'reference' => $reference,
            'success' => $isSuccess,
            'status' => $taskStatus,
            'pid' => $transaction->getPid(),
            'pid_status' => $transaction->getResult()->getStatus(),
            'created_at' => time(),
            'echoes' => array(),
            'amount' => $transaction->getAmount()
        );

        if ($order !== null) {
            $data += array(
                'id_order' => $order->id(),
                'state_from' => $stateFrom,
                'state_to' => $order->getState()
            );
        }

        $processing = $this->getRepository()->create($data);

        $this->getRepository()->insert($processing);

        return $processing;
    }

    /**
     * @param ProcessingEntityInterface $processing
     * @return bool
     * @throws Exception
     */
    public function addEcho(ProcessingEntityInterface $processing)
    {
        $processing->addEcho(new DateTime());

        return $this->getRepository()->update($processing);
    }
}
