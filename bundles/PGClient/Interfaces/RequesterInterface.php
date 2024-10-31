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

namespace PGI\Module\PGClient\Interfaces;

use PGI\Module\PGClient\Components\Request as RequestComponent;
use PGI\Module\PGClient\Components\Response as ResponseComponent;
use Exception;

/**
 * Interface RequesterInterface
 * @package PGClient\Interfaces
 */
interface RequesterInterface
{
    /**
     * @param RequestComponent $request
     * @return bool
     */
    public function isValid(RequestComponent $request);

    /**
     * @param RequestComponent $request
     * @param bool $jsonEncodePostFields
     * @return ResponseComponent
     * @throw Exception
     */
    public function send(RequestComponent $request, $jsonEncodePostFields = true);

    /**
     * @return bool
     */
    public function checkCompatibility();
}
