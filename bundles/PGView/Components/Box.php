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

namespace PGI\Module\PGView\Components;

use PGI\Module\PGSystem\Foundations\AbstractObject;
use PGI\Module\PGView\Interfaces\ViewInterface;
use Exception;

/**
 * Class Box
 * @package PGView\Components
 */
class Box extends AbstractObject
{
    /** @var ViewInterface */
    private $view;

    public function __construct(ViewInterface $view)
    {
        $this->view = $view;
    }

    public function render()
    {
        return $this->view->render();
    }

    public function __toString()
    {
        try {
            return $this->render();
        } catch (Exception $exception) {
            $this->getService('logger')->error(
                "An error occurred during rendering box content : " . $exception->getMessage(),
                $exception
            );
            return '';
        }
    }
}
