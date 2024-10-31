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

namespace PGI\Module\APIPayment\Services\Listeners;

use PGI\Module\PGPayment\Services\Facades\PaygreenFacade;
use Exception;

/**
 * Class InstallCompatibilityCheckListener
 * @package APIPayment\Services\Listeners
 */
class InstallCompatibilityCheckListener
{
    /** @var PaygreenFacade */
    private $paygreenFacade;

    public function __construct(PaygreenFacade $paygreenFacade)
    {
        $this->paygreenFacade = $paygreenFacade;
    }

    public function checkCompatibility()
    {
        if (!$this->paygreenFacade->getApiFacade()->getRequestSender()->checkCompatibility()) {
            $error = "Your server is not able to contact PayGreen API.";
            $error .= " You must install the cURL extension or allow URL fopen.";

            throw new Exception($error);
        }
    }
}
