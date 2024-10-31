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

namespace PGI\Module\BOModule\Services\Listeners;

use PGI\Module\PGFramework\Services\Notifier;
use PGI\Module\PGServer\Components\Events\Action as ActionEventComponent;
use PGI\Module\PGShop\Services\Handlers\ShopHandler;

/**
 * Class ShopContextBackofficeListener
 * @package BOModule\Services\Listeners
 */
class ShopContextBackofficeListener
{
    /** @var Notifier */
    private $notifier;

    /** @var ShopHandler */
    private $shopHandler;

    private $bin;

    public function __construct(
        Notifier $notifier,
        ShopHandler $shopHandler
    ) {
        $this->notifier = $notifier;
        $this->shopHandler = $shopHandler;
    }

    public function listen(ActionEventComponent $event)
    {
        // Thrashing unused arguments
        $this->bin = $event;

        if ($this->shopHandler->isMultiShopActivated() && !$this->shopHandler->isShopContext()) {
            $this->notifier->add(
                Notifier::STATE_FAILURE,
                'misc.backoffice.errors.shop_context_needed'
            );
        }
    }
}
