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

use PGI\Module\PGFramework\Services\Handlers\HookHandler;
use PGI\Module\PGSystem\Components\Parameters;

class AdminMenuHook
{
    /** @var HookHandler */
    private $hookHandler;

    /** @var Parameters */
    private $parameters;

    public function __construct(HookHandler $hookHandler, Parameters $parameters)
    {
        $this->hookHandler = $hookHandler;
        $this->parameters = $parameters;
    }

    /**
     * @todo Traduire le titre la page.
     */
    public function display()
    {
        $menuTitle = $this->parameters['cms.admin.menu.title'];
        $menuCode = $this->parameters['cms.admin.menu.code'];
        $menuIcon = $this->parameters['cms.admin.menu.icon'];

        add_menu_page(
            "Configuration du module $menuTitle",
            $menuTitle,
            'manage_options',
            $menuCode,
            $this->hookHandler->addHookName('backoffice', 'run'),
            $menuIcon
        );
    }
}
