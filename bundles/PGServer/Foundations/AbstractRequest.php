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

namespace PGI\Module\PGServer\Foundations;

/**
 * Class AbstractRequest
 * @package PGServer\Foundations
 */
abstract class AbstractRequest
{
    private $action;

    private $data = array();

    private $headers = array();

    public function __construct($action, array $data = array(), array $headers = array())
    {
        $this->action = $action;
        $this->data = $data;
        $this->headers = $headers;
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    public function get($var, $defaultValue = null)
    {
        return $this->has($var) ? $this->data[$var] : $defaultValue;
    }

    public function has($var)
    {
        return array_key_exists($var, $this->data);
    }

    public function getAll()
    {
        return $this->data;
    }

    public function getHeader($header)
    {
        return $this->hasHeader($header) ? $this->headers[$header] : null;
    }

    public function hasHeader($header)
    {
        return array_key_exists($header, $this->headers);
    }

    public function getAllHeaders()
    {
        return $this->headers;
    }

    public function getHash()
    {
        return md5(serialize(array(
            'action' => $this->getAction(),
            'data' => $this->getAll(),
            'headers' => $this->getAllHeaders()
        )));
    }
}
