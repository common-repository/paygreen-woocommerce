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

use PGI\Module\PGDatabase\Services\Handlers\DatabaseHandler;
use PGI\Module\PGModule\Components\UpgradeStage as UpgradeComponent;
use PGI\Module\PGModule\Interfaces\UpgradeInterface;
use Exception;

class DatabaseDeltaUpgrade implements UpgradeInterface
{
    /** @var DatabaseHandler */
    private $databaseHandler;

    public function __construct(
        DatabaseHandler $databaseHandler
    ) {
        $this->databaseHandler = $databaseHandler;
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function apply(UpgradeComponent $upgradeStage)
    {
        $script = $upgradeStage->getConfig('script');

        if (empty($script)) {
            throw new Exception("Database delta require 'script' parameter.");
        }

        if (!function_exists('dbDelta')) {
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        }

        if (is_array($script)) {
            foreach($script as $oneScript) {
                $this->delta($oneScript);
            }
        } else {
            $this->delta($script);
        }

    }

    protected function delta($script)
    {
        $sql = $this->databaseHandler->loadScript($script);
        $sql = $this->databaseHandler->parseQuery($sql);

        dbDelta($sql);
    }
}
