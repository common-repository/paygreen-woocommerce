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

namespace PGI\Module\PGServer\Services\Acceptors;

use PGI\Module\PGServer\Foundations\AbstractAcceptor;
use PGI\Module\PGServer\Foundations\AbstractResponse;

/**
 * Class ModelAcceptor
 * @package PGServer\Services\Acceptors
 */
class ModelAcceptor extends AbstractAcceptor
{
    public function isValid(AbstractResponse $response, $config)
    {
        $class = get_class($response);

        if (is_array($config)) {
            return in_array($class, $config);
        } else {
            return ($class === $config);
        }
    }
}
