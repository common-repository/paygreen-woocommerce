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

namespace PGI\Module\PGWooPayment\Services\Listeners;

use WC_Order as LocalWC_Order;
use PGI\Module\PGFramework\Components\Events\Task as TaskEventComponent;
use PGI\Module\PGIntl\Services\Translator;
use PGI\Module\PGLog\Interfaces\LoggerInterface;
use PGI\Module\PGPayment\Components\Tasks\PaymentValidation as PaymentValidationTaskComponent;
use Exception;

class AddRefusedNotesListener
{
    /** @var LoggerInterface */
    private $logger;

    /** @var Translator */
    private $translator;

    public function __construct(LoggerInterface $logger,Translator $translator)
    {
        $this->logger = $logger;
        $this->translator = $translator;
    }

    public function listen(TaskEventComponent $event)
    {
        /** @var PaymentValidationTaskComponent $paymentTask */
        $paymentTask = $event->getTask();

        $id_order = $paymentTask->getTransaction()->getMetadata('order_id');

        /** @var LocalWC_Order|null $order */
        $order = wc_get_order($id_order);

        if ($order === null) {
            $this->logger->debug("Action 'addRefusedNotes' require valid Order.");
            throw new Exception("Action 'addRefusedNotes' require valid Order.");
        }

        $note = $this->translator->get('translations.message_payment_refused.field.help');
        $order->add_order_note( $note );
    }
}