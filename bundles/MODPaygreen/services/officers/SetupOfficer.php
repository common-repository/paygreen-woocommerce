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

namespace PGI\Module\MODPaygreen\Services\Officers;

use PGI\Module\PGDatabase\Interfaces\DatabaseOfficerInterface;
use PGI\Module\PGDatabase\Services\Handlers\DatabaseHandler;
use PGI\Module\PGModule\Interfaces\Officers\SetupOfficerInterface;
use Exception;

/**
 * Class SetupOfficer
 * @package PGPresta\Services\Officers
 */
class SetupOfficer implements SetupOfficerInterface
{
    /** @var DatabaseHandler */
    private $databaseHandler;

    /** @var DatabaseOfficerInterface */
    private $databaseOfficer;

    public function __construct(
        DatabaseHandler $databaseHandler,
        DatabaseOfficerInterface $databaseOfficer
    ) {
        $this->databaseHandler = $databaseHandler;
        $this->databaseOfficer = $databaseOfficer;
    }

    /**
     * @return string|null
     */
    public function retrieveOldInstallation()
    {
       if (!$this->isValidRequest("SELECT 1 FROM `%{database.entities.transaction.table}` LIMIT 1;")) {
            return null;
        }

        if (!$this->isValidRequest("SELECT 1 FROM `%{database.entities.fingerprint.table}` LIMIT 1;")) {
            return "1.4.0";
        }

        if (!$this->isValidRequest("SELECT 1 FROM `%{database.entities.category_has_payment.table}` LIMIT 1;")) {
            return "2.0.0";
        }

        return "2.2.0";
    }

    /**
     * @param string $sql
     * @return bool
     */
    protected function isValidRequest($sql)
    {
        try {
            $sql = $this->databaseHandler->parseQuery($sql);

            $result = $this->databaseOfficer->execute($sql);
        } catch (Exception $exception) {
            $result = false;
        }

        return $result;
    }
}
