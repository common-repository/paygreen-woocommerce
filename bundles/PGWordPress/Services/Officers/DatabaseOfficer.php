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

namespace PGI\Module\PGWordPress\Services\Officers;

use wpdb as Localwpdb;
use PGI\Module\PGDatabase\Interfaces\DatabaseOfficerInterface;
use Exception;

class DatabaseOfficer implements DatabaseOfficerInterface
{
    public function quote($value)
    {
        return $this->db()->_real_escape($value);
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function execute($sql)
    {
        $this->db()->query($sql);

        $this->verifyErrors();

        return true;
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function insert($sql)
    {
        $this->db()->query($sql);

        $this->verifyErrors();

        return $this->db()->insert_id;
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function fetch($sql)
    {
        /** @var false|array $result */
        $result = $this->db()->get_results($sql, ARRAY_A);

        $this->verifyErrors();

        if (empty($result)) {
            $result = array();
        } elseif (!is_array($result)) {
            throw new Exception("Request result cannot be converted in array.");
        }

        return $result;
    }

    /**
     * @return Localwpdb
     */
    protected function db()
    {
        return $GLOBALS['wpdb'];
    }

    /**
     * @throws Exception
     */
    protected function verifyErrors()
    {
        $error = $this->db()->last_error;

        if (!empty($error)) {
            $text ="An error occurred during execute sql statement : $error";
            throw new Exception($text);
        }
    }
}
