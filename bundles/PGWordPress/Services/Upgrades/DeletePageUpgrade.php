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

namespace PGI\Module\PGWordPress\Services\Upgrades;

use WP_Post as LocalWP_Post;
use PGI\Module\PGModule\Components\UpgradeStage as UpgradeComponent;
use PGI\Module\PGModule\Interfaces\UpgradeInterface;
use PGI\Module\PGLog\Interfaces\LoggerInterface;
use Exception;

class DeletePageUpgrade implements UpgradeInterface
{
    /** @var LoggerInterface */
    private $logger;

    /**
     * DeletePageUpgrade constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(
        LoggerInterface $logger
    ) {
        $this->logger = $logger;
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function apply(UpgradeComponent $upgradeStage)
    {
        $name = $upgradeStage->getConfig('name');

        if (empty($name)) {
            throw new Exception("Deleting page require 'name' parameter.");
        }

        if (is_array($name)) {
            foreach ($name as $item) {
                $this->deletePage($item);
            }
        } else {
            $this->deletePage($name);
        }
    }

    private function deletePage($name)
    {
        /** @var LocalWP_Post $page */
        $page = get_page_by_path($name);

        if ($page) {
            wp_delete_post($page->ID, true);
            $this->logger->notice("Page '$name' successfully deleted.");
        } else {
            $this->logger->warning("Page '$name' not found.");
        }
    }
}