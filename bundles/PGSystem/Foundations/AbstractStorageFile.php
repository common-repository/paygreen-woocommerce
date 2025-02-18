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

namespace PGI\Module\PGSystem\Foundations;

use PGI\Module\PGSystem\Foundations\AbstractStorage;

/**
 * Class AbstractStorageFile
 * @package PGSystem\Foundations
 */
abstract class AbstractStorageFile extends AbstractStorage
{
    private $filename;

    /**
     * @return mixed
     */
    protected function getFilename()
    {
        return $this->filename;
    }

    /**
     * @param mixed $filename
     */
    protected function setFilename($filename)
    {
        $this->filename = $filename;
    }

    protected function loadFile()
    {
        $content = null;

        if (file_exists($this->getFilename())) {
            $content = file_get_contents($this->getFilename());
        }

        return $content;
    }

    protected function saveFile($content)
    {
        $handler = @fopen($this->getFilename(), "w+");

        if ($handler && flock($handler, LOCK_EX | LOCK_NB)) {
            ftruncate($handler, 0);
            fwrite($handler, $content);
            flock($handler, LOCK_UN);
        }
    }
}
