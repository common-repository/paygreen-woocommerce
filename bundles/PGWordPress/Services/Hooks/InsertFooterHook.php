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

namespace PGI\Module\PGWordPress\Services\Hooks;

use WP_Query as LocalWP_Query;
use PGI\Module\PGModule\Components\Output as OutputComponent;
use PGI\Module\PGModule\Services\Providers\OutputProvider;
use PGI\Module\PGWordPress\Services\Compilers\StaticResourceCompiler;

class InsertFooterHook
{
    /** @var OutputProvider */
    private $outputProvider;

    /** @var StaticResourceCompiler */
    private $wordpressResourceHandler;

    private $isAlreadyCalled = false;

    public function __construct(
        OutputProvider $outputProvider,
        StaticResourceCompiler $wordpressResourceHandler
    )
    {
        $this->outputProvider = $outputProvider;
        $this->wordpressResourceHandler = $wordpressResourceHandler;
    }

    public function insertIntoFooter()
    {
        if ($this->getWPQuery()->is_front_page() && !$this->isAlreadyCalled) {
            $this->isAlreadyCalled = true;

            /** @var OutputComponent $output */
            $output = $this->outputProvider->getZoneOutput('FRONT.HOME.FOOTER');

            $this->wordpressResourceHandler->insertResources($output->getResources());

            echo $output->getContent();
        }
    }

    /**
     * @return LocalWP_Query
     */
    private function getWPQuery()
    {
        global $wp_query;

        return $wp_query;
    }
}