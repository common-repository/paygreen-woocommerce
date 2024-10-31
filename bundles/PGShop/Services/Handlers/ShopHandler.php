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

namespace PGI\Module\PGShop\Services\Handlers;

use PGI\Module\PGFramework\Interfaces\Handlers\SessionHandlerInterface;
use PGI\Module\PGLog\Interfaces\LoggerInterface;
use PGI\Module\PGShop\Interfaces\Entities\ShopEntityInterface;
use PGI\Module\PGShop\Interfaces\Officers\ShopOfficerInterface;
use PGI\Module\PGShop\Services\Managers\ShopManager;
use PGI\Module\PGSystem\Foundations\AbstractObject;

/**
 * Class ShopHandler
 * @package PGShop\Services\Handlers
 */
class ShopHandler extends AbstractObject
{
    const SESSION_SHOP_KEY = 'paygreen_selected_shop_primary';

    /** @var ShopEntityInterface */
    private $shop = null;

    /** @var ShopManager */
    private $shopManager;

    /** @var SessionHandlerInterface */
    private $sessionHandler;

    /** @var ShopOfficerInterface */
    private $shopOfficer;

    /** @var LoggerInterface */
    private $logger;

    /**
     * ShopHandler constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param ShopManager $shopManager
     */
    public function setShopManager(ShopManager $shopManager)
    {
        $this->shopManager = $shopManager;
    }

    /**
     * @param SessionHandlerInterface $sessionHandler
     */
    public function setSessionHandler(SessionHandlerInterface $sessionHandler)
    {
        $this->sessionHandler = $sessionHandler;
    }

    /**
     * @param ShopOfficerInterface $shopOfficer
     */
    public function setShopOfficer(ShopOfficerInterface $shopOfficer)
    {
        $this->shopOfficer = $shopOfficer;
    }

    /**
     * @return ShopOfficerInterface
     */
    protected function getShopOfficer()
    {
        return $this->shopOfficer;
    }

    /**
     * @return LoggerInterface
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     * @return SessionHandlerInterface
     */
    public function getSessionHandler()
    {
        return $this->sessionHandler;
    }

    /**
     * @return ShopManager
     */
    public function getShopManager()
    {
        return $this->shopManager;
    }

    /**
     * @return bool
     */
    public function isMultiShopActivated()
    {
        return $this->getShopOfficer()->isMultiShopActivated();
    }

    /**
     * @return bool
     */
    public function isBackOffice()
    {
        return $this->getShopOfficer()->isBackOffice();
    }

    /**
     * @return bool
     */
    public function isShopContext()
    {
        return $this->getShopOfficer()->isShopContext();
    }

    /**
     * @return ShopEntityInterface
     */
    public function getCurrentShop()
    {
        if ($this->shop === null) {
            $this->shop = $this->buildCurrentShop();
        }

        return $this->shop;
    }

    /**
     * @return int
     */
    public function getCurrentShopPrimary()
    {
        return $this->getCurrentShop()->id();
    }

    /**
     * @param ShopEntityInterface $shop
     */
    public function defineCurrentShop(ShopEntityInterface $shop)
    {
        $this->shop = $shop;

        $this->sessionHandler->set(self::SESSION_SHOP_KEY, $shop->id());
    }

    /**
     * @return void
     */
    public function clear()
    {
        $this->logger->debug('Clear ShopHandler cache');

        $this->shop = null;
    }

    /**
     * @return ShopEntityInterface
     */
    protected function buildCurrentShop()
    {
        /** @var ShopEntityInterface $shop */
        $shop = null;

        if ($this->isMultiShopActivated() && $this->isBackOffice()) {
            $shop = $this->getShopFromSession();
        }

        if ($shop === null) {
            $shop = $this->shopManager->getCurrent();
        }

        return $shop;
    }

    /**
     * @return ShopEntityInterface|null
     */
    protected function getShopFromSession()
    {
        $shop = null;

        $id_shop = $this->sessionHandler->get(self::SESSION_SHOP_KEY);

        if ($id_shop !== null) {
            $shop = $this->shopManager->getByPrimary($id_shop);

            if ($shop === null) {
                $this->sessionHandler->rem(self::SESSION_SHOP_KEY);
            }
        }

        return $shop;
    }
}
