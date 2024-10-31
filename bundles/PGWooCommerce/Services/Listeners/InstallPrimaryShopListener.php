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

namespace PGI\Module\PGWooCommerce\Services\Listeners;

use PGI\Module\PGLog\Interfaces\LoggerInterface;
use PGI\Module\PGModule\Services\Settings;

class InstallPrimaryShopListener
{
    /** @var Settings */
    private $settings;

    /** @var LoggerInterface */
    private $logger;

    public function __construct(Settings $settings, LoggerInterface $logger)
    {
        $this->settings = $settings;
        $this->logger = $logger;
    }

    public function createPrimaryShop()
    {

        $id_shop = $this->settings->get('shop_identifier');

        if (empty($id_shop)) {
            $pool = array_merge(range(0, 9), range('A', 'Z'));

            $key = null;
            for ($i = 0; $i < 4; $i++) {
                $key .= $pool[mt_rand(0, count($pool) - 1)];
            }

            $this->settings->set('shop_identifier', $key);

            $this->logger->notice("ID shop successfully created.");
        } else {
            $this->logger->error("ID shop already exists.");
        }
    }
}