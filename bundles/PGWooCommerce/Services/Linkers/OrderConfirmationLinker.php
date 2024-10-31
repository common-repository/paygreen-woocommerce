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

namespace PGI\Module\PGWooCommerce\Services\Linkers;

use WC_Order as LocalWC_Order;
use PGI\Module\PGWooCommerce\Foundations\Linkers\AbstractOrderLinker;
use Exception;

class OrderConfirmationLinker extends AbstractOrderLinker
{
    /**
     * @inheritDoc
     * @throws Exception
     */
    public function buildUrl(array $data = array())
    {
        /** @var LocalWC_Order $localOrder */
        $localOrder = $this->findOrder($data)->getLocalEntity();

        return $localOrder->get_checkout_order_received_url();
    }
}
