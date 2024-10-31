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

use PGI\Module\PGModule\Services\Providers\OutputProvider;
use PGI\Module\PGServer\Components\ResourceBag as ResourceBagComponent;
use PGI\Module\PGServer\Components\Resources\StyleFile as StyleFileResourceComponent;
use PGI\Module\PGWordPress\Services\Compilers\StaticResourceCompiler;
use Exception;

class StaticFilesHook
{
    /** @var OutputProvider */
    private $outputProvider;

    /** @var StaticResourceCompiler */
    private $wordpressResourceHandler;

    public function __construct(
        OutputProvider $outputProvider,
        StaticResourceCompiler $wordpressResourceHandler
    ) {
        $this->outputProvider = $outputProvider;
        $this->wordpressResourceHandler = $wordpressResourceHandler;
    }

    /**
     * @throws Exception
     */
    public function register()
    {
        if (is_admin() || $this->isLoginPage()) {
            $resources = new ResourceBagComponent();

            $resources->add(new StyleFileResourceComponent('/css/backoffice.css'));
        } else {
            $channels = array('FRONT.HEAD');

            if (is_home()) {
                $channels[] = 'FRONT.HOME.FOOTER';
            }

            if (is_checkout()) {
                $channels[] = 'FRONT.FUNNEL.CHECKOUT';
            }

            /** @var ResourceBagComponent $resources */
            $resources = $this->outputProvider->getResources($channels);
        }

        $this->wordpressResourceHandler->insertResources($resources);
    }

    protected function isLoginPage()
    {
        return ($GLOBALS['pagenow'] === 'wp-login.php' );
    }
}
