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

namespace PGI\Module\PGWooCommerce\Services\Linkers;

use PGI\Module\PGServer\Foundations\AbstractLinker;
use Exception;

class EndpointLinker extends AbstractLinker
{
    /**
     * @inheritDoc
     * @throws Exception
     */
    public function buildUrl(array $data = array())
    {
        /** @var string $route */
        $route = $this->getConfig('route');

        if (!is_string($route)) {
            throw new Exception("Endpoint linker require 'route' config key.");
        }

        $url = wc_get_account_endpoint_url($route);

        $this->log()->debug("Generating URL for endpoint '{$route}' : $url");

        return $url;
    }
}
