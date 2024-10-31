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

namespace PGI\Module\PGWooPayment\Services\Upgrades;

use PGI\Module\PGDatabase\Services\Handlers\DatabaseHandler;
use PGI\Module\PGModule\Components\UpgradeStage as UpgradeComponent;
use PGI\Module\PGModule\Interfaces\UpgradeInterface;
use PGI\Module\PGLog\Interfaces\LoggerInterface;
use PGI\Module\PGModule\Services\Settings;
use Exception;

class RestoreButtonsUpgrade implements UpgradeInterface
{
    const CONFIG_KEY_BUTTON_INDEX = 'wcpaygreen_btn_count';
    const CONFIG_KEY_BUTTON_PREFIX = 'wcpaygreen_btn_data_';

    public static $PAYMENT_MODES = array(
        'CASH',
        'RECURRING',
        'TOKENIZE',
        'XTIME'
    );

    /** @var Settings */
    private $settings;

    /** @var DatabaseHandler */
    private $databaseHandler;

    /** @var LoggerInterface */
    private $logger;

    /**
     * PGModuleServicesListenersRestoreSettingsListener constructor.
     * @param Settings $settings
     * @param DatabaseHandler $databaseHandler
     * @param LoggerInterface $logger
     */
    public function __construct(
        Settings $settings,
        DatabaseHandler $databaseHandler,
        LoggerInterface $logger
    ) {
        $this->settings = $settings;
        $this->databaseHandler = $databaseHandler;
        $this->logger = $logger;
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function apply(UpgradeComponent $upgradeStage)
    {
        $oldButtonIndex = get_option(self::CONFIG_KEY_BUTTON_INDEX);

        if (!empty($oldButtonIndex) && ($oldButtonIndex > 0)) {
            $this->logger->notice("Old buttons configuration finded.");
            $this->restoreButtons($oldButtonIndex);
        }

        return true;
    }

    /**
     * @param int $oldButtonIndex
     * @throws Exception
     */
    private function restoreButtons($oldButtonIndex)
    {
        for ($c = 1; $c <= $oldButtonIndex; $c ++) {
            $oldButton = get_option(self::CONFIG_KEY_BUTTON_PREFIX . $c);

            if (!empty($oldButton)) {
                $oldButton = json_decode($oldButton, true);

                if (!empty($oldButton) && is_array($oldButton)) {
                    $this->restoreButton($oldButton, $c);
                }
            }
        }

        delete_option(self::CONFIG_KEY_BUTTON_INDEX);
    }

    /**
     * @param array $oldButton
     * @param int $index
     * @throws Exception
     */
    private function restoreButton(array $oldButton, $index)
    {
        $paymentMode = self::$PAYMENT_MODES[$oldButton['executedAt']];

        $data = array(
            'label' => $oldButton['label'],
            'paymentMode' => $paymentMode,
            'paymentType' => $oldButton['paymentType'],
            'minAmount' => $oldButton['minAmount'],
            'maxAmount' => $oldButton['maxAmount'],
            'firstPaymentPart' => $oldButton['firstPayment'],
            'paymentNumber' => $oldButton['nbPayment'],
            'paymentReport' => $oldButton['reportPayment']
        );

        $columns = array();
        $values = array();

        foreach($data as $key => $val) {
            $val = $this->databaseHandler->quote($val);

            $columns[] = "`$key`";
            $values[] = "'$val'";
        }

        $columns = join(', ', $columns);
        $values = join(', ', $values);

        $sql = "INSERT INTO `\${PAYGREEN_DB_PREFIX}paygreen_buttons` ($columns) VALUES ($values)";

        if ($this->databaseHandler->execute($sql)) {
            $this->logger->notice("Old button '{$oldButton['label']}' successfully restored.");
        } else {
            $this->logger->error("Unable to save old button '{$oldButton['label']}'.");
        }

        delete_option(self::CONFIG_KEY_BUTTON_PREFIX . $index);
    }
}