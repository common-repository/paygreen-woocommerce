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

namespace PGI\Module\PGClient\Components;

use PGI\Module\PGClient\Components\Response as ResponseComponent;
use PGI\Module\PGClient\Exceptions\ResponseMalformed as ResponseMalformedException;
use PGI\Module\PGSystem\Services\Container;
use stdClass;

/**
 * Class ResponseJSON
 * @package PGClient\Components
 */
class ResponseJSON extends ResponseComponent
{
    /**
     * @param string $data
     * @return stdClass
     * @throws ResponseMalformedException
     */
    protected function format($data)
    {
        $data = parent::format($data);

        $decodedData = @json_decode($data);

        if (is_array($decodedData)) {
            foreach ($decodedData as $data) {
                if (!$data instanceof  stdClass) {
                    throw new ResponseMalformedException("Invalid JSON result.");
                }
            }
        } elseif (!$decodedData instanceof stdClass) {
            throw new ResponseMalformedException("Invalid JSON result.");
        }

        return $decodedData;
    }
}
