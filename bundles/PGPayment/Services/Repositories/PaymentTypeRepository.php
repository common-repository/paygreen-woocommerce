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

namespace PGI\Module\PGPayment\Services\Repositories;

use PGI\Module\APIPayment\Components\Response as ResponseComponent;
use PGI\Module\PGDatabase\Foundations\AbstractRepositoryPaygreen;
use PGI\Module\PGFramework\Services\Handlers\CacheHandler;
use PGI\Module\PGLog\Interfaces\LoggerInterface;
use PGI\Module\PGPayment\Entities\PaymentType;
use Exception;

/**
 * Class PaymentTypeRepository
 *
 * @package PGPayment\Services\Repositories
 * @method PaymentType[] wrapList(array $rawEntities)
 */
class PaymentTypeRepository extends AbstractRepositoryPaygreen
{
    /**
     * @inheritdoc
     */
    public function getModelClassName()
    {
        return 'PGI\Module\PGPayment\Entities\PaymentType';
    }

    /**
     * @return PaymentType[]
     */
    public function findAll()
    {
        /** @var CacheHandler $cacheHandler */
        $cacheHandler = $this->getService('handler.cache');

        /** @var LoggerInterface $logger */
        $logger = $this->getService('logger');

        $rawPaymentTypes = $cacheHandler->loadEntry('payment-types');

        if ($rawPaymentTypes === null) {
            try {
                /** @var ResponseComponent $response */
                $response = $this->getApiFacade()->paymentTypes();

                $rawPaymentTypes = (array) $response->data;

                if (!empty($rawPaymentTypes)) {
                    $cacheHandler->saveEntry('payment-types', $rawPaymentTypes);
                }
            } catch (Exception $exception) {
                $logger->alert("Error when importing payment methods: " . $exception->getMessage(), $exception);

                $rawPaymentTypes = array();
            }
        }

        return $this->wrapEntities($rawPaymentTypes);
    }
}
