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

namespace PGI\Module\PGClient\Services\Requesters;

use PGI\Module\PGClient\Components\Feedback as FeedbackComponent;
use PGI\Module\PGClient\Components\Request as RequestComponent;
use PGI\Module\PGClient\Foundations\AbstractRequester;

/**
 * Class FopenRequester
 * @package PGClient\Services\Requesters
 */
class FopenRequester extends AbstractRequester
{
    private $bin;

    public function isValid(RequestComponent $request)
    {
        // Thrashing unused arguments
        $this->bin = $request;

        return $this->checkCompatibility();
    }

    public function sendRequest(RequestComponent $request, $jsonEncodePostFields = true)
    {
        $rawRequestContent = $request->getContent();

        if ($jsonEncodePostFields === true) {
            $encodedRequestContent = json_encode($rawRequestContent);
        } else {
            $encodedRequestContent = $rawRequestContent;
        }

        $contentLength = 0;
        if (!empty($rawRequestContent)) {
            $contentLength = strlen($encodedRequestContent);
        }

        $request->addHeaders(array(
            "Content-Length: $contentLength"
        ));

        $options = array(
            'http' => array(
                'method'  => $request->getMethod(),
                'header'  => join("\r\n", $request->getHeaders()),
                'content' => $encodedRequestContent
            )
        );

        $context = stream_context_create($options);
        $http_response_header = null;

        $rawResult = file_get_contents($request->getFinalUrl(), false, $context);

        $details = $this->parseHeaders($http_response_header);

        if (empty($rawResult) && ($details['response_code'] === 500)) {
            $this->log('alert', 'Unknown error 500 with empty response.', $options, $details);
        }

        return new FeedbackComponent($request, $details['response_code'], $rawResult, $details);
    }

    public function parseHeaders($headers)
    {
        $head = array();
        foreach ($headers as $v) {
            $t = explode(':', $v, 2);
            if (isset($t[1])) {
                $head[trim($t[0])] = trim($t[1]);
            } else {
                $head[] = $v;
                if (preg_match("#HTTP/[0-9\.]+\s+([0-9]+)#", $v, $out)) {
                    $head['response_code'] = (int) $out[1];
                }
            }
        }

        return $head;
    }

    public function checkCompatibility()
    {
        return (bool) ini_get('allow_url_fopen');
    }
}
