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
use PGI\Module\PGIntl\Services\Handlers\TranslationHandler;
use PGI\Module\PGModule\Components\UpgradeStage as UpgradeComponent;
use PGI\Module\PGModule\Interfaces\UpgradeInterface;
use PGI\Module\PGLog\Interfaces\LoggerInterface;
use PGI\Module\PGShop\Services\Managers\ShopManager;
use PGI\Module\PGSystem\Components\Parameters as ParametersComponent;
use PGI\Module\PGWordPress\Services\Officers\DatabaseOfficer;
use Exception;

/**
 * Class PGWordPressServicesUpgradesRestoreTranslations
 * @package PGWordPress\Services\Upgrades
 */
class RepareTranslationsTableUpgrade implements UpgradeInterface
{
    const TABLE_NAME_UNPREFIXED = 'paygreen_translations';

    const CREATION_TRANSLATIONS_TABLE_SCRIPT = 'PGIntl:translation/updates/001-creation-table.sql';

    /** @var DatabaseHandler */
    private $databaseHandler;

    /** @var DatabaseOfficer */
    private $databaseOfficer;

    /** @var ShopManager */
    private $shopManager;

    /** @var TranslationHandler */
    private $translationHandler;

    /** @var ParametersComponent  */
    private $parameters;

    /** @var LoggerInterface */
    private $logger;

    public function __construct(
        DatabaseHandler $databaseHandler,
        DatabaseOfficer $databaseOfficer,
        ShopManager $shopManager,
        TranslationHandler $translationHandler,
        ParametersComponent $parameters,
        LoggerInterface $logger
    ) {
        $this->databaseHandler = $databaseHandler;
        $this->databaseOfficer = $databaseOfficer;
        $this->shopManager = $shopManager;
        $this->translationHandler = $translationHandler;
        $this->parameters = $parameters;
        $this->logger = $logger;
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function apply(UpgradeComponent $upgradeStage)
    {
        $tableNamePrefixed = PAYGREEN_DB_PREFIX . self::TABLE_NAME_UNPREFIXED;

        if ($this->isTableExist($tableNamePrefixed)) {
            if ($this->isTableExist(self::TABLE_NAME_UNPREFIXED)) {
                $this->removeTable(self::TABLE_NAME_UNPREFIXED);
            }
        } else {
            if (!$this->isTableExist(self::TABLE_NAME_UNPREFIXED)) {
                $this->createTranslationTable();
            } else {
                $this->renameTable(self::TABLE_NAME_UNPREFIXED, $tableNamePrefixed);
            }
        }
    }

    /**
     * @param string $tableName
     * @return bool
     */
    private function isTableExist($tableName)
    {
        $sql = "SELECT * FROM $tableName";

        try {
            $this->databaseOfficer->fetch($sql);
        }
        catch (Exception $exception) {
            $this->logger->debug("Table '$tableName' doesn't exist.");

            return false;
        }

        return true;
    }

    /**
     * @param string $tableName
     * @throws Exception
     */
    private function removeTable($tableName)
    {
        $sql = "DROP TABLE $tableName";

        $this->databaseOfficer->execute($sql);

        if ($this->isTableExist($tableName)) {
            $this->logger->error("An error occured during '$tableName' removing.");
        } else {
            $this->logger->debug("'$tableName' removed.");
        }
    }

    /**
     * @param string $tableName
     * @param string $newTableName
     */
    private function renameTable($tableName, $newTableName)
    {
        $sql = "ALTER TABLE $tableName RENAME TO $newTableName;";

        $this->databaseOfficer->execute($sql);

        if ($this->isTableExist($newTableName)) {
            $this->logger->debug("'$tableName' successfully renamed in '$newTableName'.");;
        } else {
            $this->logger->error("An error occured during '$tableName' renaming.");
        }
    }

    /**
     * @throws Exception
     */
    private function createTranslationTable()
    {
        $translationTableName = $this->parameters['database.entities.translation.table'];
        $result = $this->databaseHandler->runScript(self::CREATION_TRANSLATIONS_TABLE_SCRIPT);

        if (!$result) {
            $this->logger->error("An error occured during '$translationTableName' creation.");
        } else {
            $this->logger->debug("'$translationTableName' successfully created.");
        }

        $this->installDefaultTranslations();
    }

    private function installDefaultTranslations()
    {
        $defaultTranslationsCodes = array_keys($this->parameters['translations']);

        $this->logger->debug($defaultTranslationsCodes);

        foreach ($this->shopManager->getAll() as $shop) {
            $this->translationHandler->insertDefaultTranslations($shop, $defaultTranslationsCodes);
        }
    }
}