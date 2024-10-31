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

namespace PGI\Module\PGSystem\Interfaces\Builders;

use PGI\Module\PGSystem\Components\Bootstrap as BootstrapComponent;
use PGI\Module\PGSystem\Services\Autoloaders\CamelifiedAutoloader;
use Exception;

/**
 * Interface BootstrapBuilderInterface
 * @package PGSystem\Interfaces\Builders
 */
interface BootstrapBuilderInterface
{
    public function __construct(BootstrapComponent $bootstrap);

    /**
     * @param array $config
     * @return CamelifiedAutoloader
     * @throws Exception
     */
    public function build(array $config = array());
}
