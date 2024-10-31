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

namespace PGI\Module\PGFramework\Services\Diagnostics;

use PGI\Module\PGFramework\Foundations\AbstractDiagnostic;
use PGI\Module\PGFramework\Services\Handlers\PictureHandler;
use PGI\Module\PGFramework\Tools\SystemFile as SystemFileTool;
use PGI\Module\PGSystem\Services\Pathfinder;
use Exception;

/**
 * Class MediaFolderChmodDiagnostic
 * @package PGFramework\Services\Diagnostics
 */
class MediaFolderChmodDiagnostic extends AbstractDiagnostic
{
    /** @var Pathfinder */
    private $pathfinder;

    public function __construct(Pathfinder $pathfinder)
    {
        $this->pathfinder = $pathfinder;
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function isValid()
    {
        return (!$this->isFolderExists() || $this->isFolderChmodIsValid());
    }

    /**
     * @return bool
     * @throws Exception
     */
    protected function isFolderExists()
    {
        $path = $this->getMediaPath();

        return (file_exists($path) && is_dir($path));
    }

    /**
     * @return bool
     * @throws Exception
     */
    protected function isFolderChmodIsValid()
    {
        $this->requirements();

        $chmod = SystemFileTool::getChmod($this->getMediaPath());

        return ($chmod === PictureHandler::MEDIA_FOLDER_CHMOD);
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function resolve()
    {
        $this->requirements();

        return chmod(
            $this->getMediaPath(),
            PictureHandler::MEDIA_FOLDER_CHMOD
        );
    }

    /**
     * @return string
     * @throws Exception
     */
    protected function getMediaPath()
    {
        return $this->pathfinder->toAbsolutePath('media');
    }

    /**
     * @throws Exception
     */
    private function requirements()
    {
        $path = $this->getMediaPath();

        if (!is_dir($path)) {
            throw new Exception("PayGreen media folder not found: $path");
        }
    }
}
