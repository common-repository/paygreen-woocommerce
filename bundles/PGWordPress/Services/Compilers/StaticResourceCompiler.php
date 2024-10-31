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

namespace PGI\Module\PGWordPress\Services\Compilers;

use Exception;
use PGI\Module\PGFramework\Tools\Version;
use PGI\Module\PGWordPress\Services\Facades\ApplicationFacade;
use WP_Styles as LocalWP_Styles;
use WP_Scripts as LocalWP_Scripts;
use PGI\Module\PGModule\Services\Handlers\StaticFileHandler;
use PGI\Module\PGLog\Interfaces\LoggerInterface;
use PGI\Module\PGServer\Components\ResourceBag as ResourceBagComponent;
use PGI\Module\PGServer\Foundations\AbstractResourceBasic;

/**
 * Class StaticResourceCompiler
 *
 * @package PGWordPress\Services\Compilers
 */
class StaticResourceCompiler
{
    /** @var StaticFileHandler */
    private $staticFileHandler;

    /** @var ApplicationFacade */
    private $applicationFacade;

    /** @var LoggerInterface */
    private $logger;

    public function __construct(
        StaticFileHandler $staticFileHandler,
        ApplicationFacade $applicationFacade,
        LoggerInterface $logger
    ) {
        $this->staticFileHandler = $staticFileHandler;
        $this->applicationFacade = $applicationFacade;
        $this->logger = $logger;
    }

    public function insertResources(ResourceBagComponent $resources)
    {
        /** @var AbstractResourceBasic $resource */
        foreach ($resources->get() as $resource)
        {
            switch($resource::NAME) {
                case 'JS-FILE':
                    $this->insertScriptFile($resource->getPath());
                    break;
                case 'CSS-FILE':
                    $this->insertStyleFile($resource->getPath());
                    break;
                case 'JS-DATA':
                    $this->insertScriptData($resource->getData());
                    break;
            }
        }
    }

    private function insertStyleFile($path)
    {
        /** @var LocalWP_Styles $wpStyles */
        $wpStyles = wp_styles();

        $url = $this->staticFileHandler->getUrl($path);
        $this->logger->debug("Adding CSS resource : " . $url);
        $wpStyles->add(sha1($url), $url);
        $wpStyles->enqueue(sha1($url));
    }

    private function insertScriptFile($path)
    {
        /** @var LocalWP_Scripts $wpScripts */
        $wpScripts = wp_scripts();

        $url = $this->staticFileHandler->getUrl($path);
        $this->logger->debug("Adding JS resource : " . $url);
        $wpScripts->add(sha1($url), $url);
        $wpScripts->enqueue(sha1($url));
    }

    private function insertScriptData(array $data)
    {
        /** @var LocalWP_Scripts $wpScripts */
        $wpScripts = wp_scripts();

        $handle = 'paygreen-data';
        $wpScripts->add($handle, '');

        if (Version::greaterOrEqualThan($this->getWordPressVersion(), '5.7.0')) {
            foreach ($data as $key => $val) {
                $this->logger->debug("Adding JS data : " . $key);

                if (is_bool($val)) {
                    $val = ($val) ? 'true' : 'false';
                }

                if (is_array($val)) {
                    $wpScripts->localize($handle, $key, $val);
                } else {
                    $wpScripts->add_inline_script($handle, 'var ' . $key . ' = "' . $this->escape($val) . '";');
                }

                $wpScripts->enqueue($handle);
            }
        } else {
            foreach ($data as $key => $val) {
                $this->logger->debug("Adding JS data : " . $key);

                if (is_bool($val)) {
                    $val = ($val) ? 'true' : 'false';
                }

                $wpScripts->localize($handle, $key, $val);
                $wpScripts->enqueue($handle);
            }
        }
    }

    /**
     * @return string
     * @throws Exception
     */
    private function getWordPressVersion()
    {
        $applicationVersion = $this->applicationFacade->getVersion();

        preg_match('/WP:([0-9\.]*)\/WC/', $applicationVersion, $results);

        return $results[1];
    }

    /**
     * @param string $value
     * @return string
     */
    private function escapeSlashes($value)
    {
        return str_replace('/', '\\/', $value);
    }

    /**
     * @param string $value
     * @return string
     */
    private function clearQuotes($value)
    {
        $value = str_replace('"', '', $value);

        $value = str_replace("'", "", $value);

        return $value;
    }

    /**
     * @param string $value
     * @return string
     */
    private function escape($value)
    {
        $value = $this->escapeSlashes($value);

        $value = $this->clearQuotes($value);

        return $value;
    }
}
