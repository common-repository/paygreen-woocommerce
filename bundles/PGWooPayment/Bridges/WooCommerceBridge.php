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

namespace PGI\Module\PGWooPayment\Bridges;

use WC_Payment_Gateway as LocalWC_Payment_Gateway;
use WC_Order as LocalWC_Order;
use PGI\Module\PGFramework\Services\Handlers\HookHandler;
use PGI\Module\PGIntl\Services\Translator;
use PGI\Module\PGSystem\Services\Container;
use PGI\Module\PGWordPress\Services\Linkers\BackofficeLinker;
use Exception;

class WooCommerceBridge extends LocalWC_Payment_Gateway
{
    public function __construct()
    {
        $this->getService('container')->set('bridge.woocommerce', $this);

        /** @var Translator $translator */
        $translator = $this->getService('translator');

        $this->id = 'wcpaygreen';
        $this->method_title = 'PayGreen';
        $this->has_fields = false;
        $this->method_description = $translator->get('misc.module.description');

        $this->supports = array(
            'products',
            'refunds'
        );

        $this->icon = null;

        $this->init_settings();
    }

    /**
     * @param string $name
     * @return object
     * @throws Exception
     */
    protected function getService($name)
    {
        return Container::getInstance()->get($name);
    }

    /**
     * @param string $hookName
     * @param string $methodName
     * @param array $arguments
     * @return mixed
     * @throws Exception
     */
    protected function run($hookName, $methodName, array $arguments = array())
    {
        /** @var HookHandler $hookHandler */
        $hookHandler = $this->getService('handler.hook');

        return $hookHandler->run($hookName, $methodName, $arguments);
    }

    public function admin_options()
    {
        /** @var BackofficeLinker $backofficeLinker */
        $backofficeLinker = $this->getService('linker.backoffice');

        $url = $backofficeLinker->buildUrl();

        header("Location: $url");
        exit();
    }

    public function isEnabled()
    {
        return ($this->enabled === 'yes');
    }

    public function get_title()
    {
        return $this->run('gateway.checkout', 'getPaymentBlocTitle');
    }

    /**
     * Return the gateway's description.
     *
     * @return string
     * @throws Exception
     **/
    public function get_description()
    {
        return $this->run('gateway.checkout', 'display');
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function is_available()
    {
        return parent::is_available() && $this->run('gateway.checkout', 'isAvailable');
    }

    /**
     * @param int $order_id
     * @return array
     * @throws Exception
     */
    public function process_payment($order_id)
    {
        return $this->run(
            'gateway.payment.create',
            'process',
            array($order_id, $_POST['wcpaygreen_buttons_id'])
        );
    }

    /**
     * @param int $order_id
     * @param null $amount
     * @param string $reason
     * @return bool|mixed
     * @throws Exception
     */
    public function process_refund($order_id, $amount = null, $reason = '')
    {
        return $this->run('gateway.refund', 'process', array($order_id, $amount));
    }

    /**
     * @param LocalWC_Order $order
     * @return bool
     * @throws Exception
     */
    public function can_refund_order($order)
    {
        return parent::can_refund_order($order) && $this->run('gateway.refund_activation', 'verify');
    }
}
