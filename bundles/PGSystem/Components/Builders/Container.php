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

namespace PGI\Module\PGSystem\Components\Builders;

use PGI\Module\PGSystem\Components\Parameters as ParametersComponent;
use PGI\Module\PGSystem\Components\Service\Library as LibraryServiceComponent;
use PGI\Module\PGSystem\Services\Container as PaygreenContainer;
use PGI\Module\PGSystem\Services\Pathfinder;
use Exception;

/**
 * Class Container
 * @package PGSystem\Components\Builders
 */
class Container
{
    /** @var Pathfinder */
    private $pathfinder;

    public function __construct(Pathfinder $pathfinder)
    {
        $this->pathfinder = $pathfinder;
    }

    /**
     * @return PaygreenContainer
     * @throws Exception
     */
    public function buildContainer()
    {
        $container = PaygreenContainer::getInstance();

        $this->loadServiceLibrary($container);
        $this->loadParameters($container);

        return $container;
    }

    /**
     * @param PaygreenContainer $container
     * @throws Exception
     */
    private function loadServiceLibrary(PaygreenContainer $container)
    {
        /** @var LibraryServiceComponent $library */
        $library = $container->get('service.library');

        if (defined('PAYGREEN_SUBSET')) {
            $filename = 'container-' . PAYGREEN_SUBSET . '.php';
        } else {
            $filename = 'container.php';
        }

        $path = $this->pathfinder->toAbsolutePath("data:/$filename");

        $library->setSource($path)->reset();
    }

    /**
     * @param PaygreenContainer $container
     * @throws Exception
     */
    private function loadParameters(PaygreenContainer $container)
    {
        /** @var ParametersComponent $parameters */
        $parameters = $container->get('parameters');

        if (defined('PAYGREEN_SUBSET')) {
            $filename = 'parameters-' . PAYGREEN_SUBSET . '.php';
        } else {
            $filename = 'parameters.php';
        }

        $path = $this->pathfinder->toAbsolutePath("data:/$filename");

        $parameters->setSource($path)->reset();
    }
}
