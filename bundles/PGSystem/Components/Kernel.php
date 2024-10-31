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

namespace PGI\Module\PGSystem\Components;

use PGI\Module\PGSystem\Components\Bundle as BundleComponent;
use PGI\Module\PGSystem\Interfaces\BundleInterface;
use Exception;

/**
 * Class Kernel
 * @package PGSystem\Components
 */
class Kernel
{
    const VERSION = '3.12.1';

    private $bundles = array();

    /**
     * @return string
     */
    public function getVersion()
    {
        return self::VERSION;
    }

    /**
     * @param string $bundleName
     * @return bool
     */
    public function hasBundle($bundleName)
    {
        return array_key_exists($bundleName, $this->bundles);
    }

    /**
     * @param string $bundleName
     * @return BundleComponent
     * @throws Exception
     */
    public function getBundle($bundleName)
    {
        if (!$this->hasBundle($bundleName)) {
            throw new Exception("Bundle not found : '$bundleName'.");
        }

        return $this->bundles[$bundleName];
    }

    /**
     * @return array
     */
    public function getBundles()
    {
        return $this->bundles;
    }

    /**
     * @return array
     */
    public function getBundleNames()
    {
        return array_keys($this->bundles);
    }

    /**
     * @param BundleInterface $bundle
     * @throws Exception
     */
    public function addBundle(BundleInterface $bundle)
    {
        if ($this->hasBundle($bundle->getName())) {
            throw new Exception("Bundle already registered : '{$bundle->getName()}'.");
        }

        $this->bundles[$bundle->getName()] = $bundle;
    }

    /**
     * @param string $bundleName
     * @throws Exception
     */
    public function removeBundle($bundleName)
    {
        if (!$this->hasBundle($bundleName)) {
            throw new Exception("Bundle not found : '$bundleName'.");
        }

        unset($this->bundles[$bundleName]);
    }
}
