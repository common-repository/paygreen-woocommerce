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

namespace PGI\Module\PGIntl\Services\Handlers;

use PGI\Module\PGLog\Interfaces\LoggerInterface;
use PGI\Module\PGModule\Services\Settings;
use PGI\Module\PGSystem\Foundations\AbstractObject;
use PGI\Module\PGSystem\Services\Pathfinder;
use Exception;

/**
 * Class CacheTranslationHandler
 * @package PGIntl\Services\Handlers
 */
class CacheTranslationHandler extends AbstractObject
{
    /** @var Pathfinder */
    private $pathfinder;

    /** @var Settings */
    private $settings;

    /** @var LoggerInterface */
    private $logger;

    public function __construct(
        Pathfinder $pathfinder,
        Settings $settings,
        LoggerInterface $logger
    ) {
        $this->pathfinder = $pathfinder;
        $this->settings = $settings;
        $this->logger = $logger;

        if ($this->isActivate()) {
            $this->logger->debug("Translation cache handler initialized.");
        }
    }

    public function isActivate()
    {
        $varFolder = $this->pathfinder->getBasePath('cache');
        $useCache = $this->settings->get('use_cache');

        return ($useCache && is_dir($varFolder) && is_writable($varFolder));
    }

    public function load($language)
    {
        $data = null;

        if ($this->isActivate() && $this->hasValidEntry($language)) {
            $path = $this->getPath($language);

            $this->logger->debug("Reading language translations '$language' in '$path'.");

            $content = file_get_contents($path);

            $data = json_decode($content, true);
        }

        return $data;
    }

    public function save($language, $data)
    {
        $path = $this->getPath($language);

        if ($this->isActivate()) {
            $this->logger->debug("Saving language translations '$language' in '$path'.");

            $content = json_encode($data);

            $result = file_put_contents($path, $content);

            if ($result === false) {
                throw new Exception("Unable to save language translations '$language' in path '$path'.");
            }

            $this->logger->debug("$result octets saved in '$path' for language translations '$language'.");
        }
    }

    /**
     * @param $language
     * @return bool
     */
    protected function hasValidEntry($language)
    {
        $path = $this->getPath($language);

        $hasEntry = $this->hasEntry($language, $path);

        if (!$hasEntry) {
            $this->logger->warning("File not found for entry '$language' : '$path'.");
        }

        return $hasEntry;
    }

    protected function hasEntry($language, $path = null)
    {
        $path = ($path !== null) ? $path : $this->getPath($language);

        return file_exists($path);
    }

    protected function getPath($language)
    {
        return $this->pathfinder->toAbsolutePath('cache', "/language-$language.cache.json");
    }

    public function reset()
    {
        $folder = $this->pathfinder->toAbsolutePath('cache');
        $files = scandir($folder);

        foreach ($files as $file) {
            if (strpos($file, 'language-') === 0) {
                unlink($folder . DIRECTORY_SEPARATOR . $file);
            }
        }
    }
}
