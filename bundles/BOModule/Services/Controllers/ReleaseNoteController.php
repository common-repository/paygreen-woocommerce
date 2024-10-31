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

namespace PGI\Module\BOModule\Services\Controllers;

use PGI\Module\BOModule\Foundations\Controllers\AbstractBackofficeController;
use PGI\Module\PGLog\Interfaces\LoggerInterface;
use PGI\Module\PGServer\Components\Resources\ScriptFile as ScriptFileResourceComponent;
use PGI\Module\PGSystem\Components\Storages\PHPFile as PHPFileStorageComponent;
use PGI\Module\PGSystem\Services\Pathfinder;

/**
 * Class ReleaseNoteController
 * @package BOModule\Services\Controllers
 */
class ReleaseNoteController extends AbstractBackofficeController
{
    const DEFAULT_NB_NOTES_DISPLAY_BY_RELEASE = 5;

    /** @var Pathfinder */
    private $pathfinder;

    /** @var LoggerInterface */
    private $logger;

    public function __construct(
        Pathfinder $pathfinder,
        LoggerInterface $logger
    ) {
        $this->pathfinder = $pathfinder;
        $this->logger = $logger;
    }

    public function displayListAction()
    {
        $filepath = $this->pathfinder->toAbsolutePath('data', '/release_note.php');

        $releasesNotes = new PHPFileStorageComponent($filepath);

        $data = $releasesNotes->getData();

        if (empty($data['releases'])) {
            $this->logger->error('An error occured during releases notes data recovery.');
        } else {
            $this->logger->debug('Releases notes data successfully recovered.');
        }

        return $this->buildTemplateResponse('release-note/block-list')
            ->addData('releases', array_reverse($data['releases']))
            ->addData('nbNotes', self::DEFAULT_NB_NOTES_DISPLAY_BY_RELEASE)
            ->addResource(new ScriptFileResourceComponent('/js/page-releases-notes.js'))
        ;
    }
}
