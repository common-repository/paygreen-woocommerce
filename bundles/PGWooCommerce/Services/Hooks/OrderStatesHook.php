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

namespace PGI\Module\PGWooCommerce\Services\Hooks;

use PGI\Module\PGFramework\Services\Handlers\CacheHandler;
use PGI\Module\PGIntl\Services\Translator;
use Exception;

class OrderStatesHook
{
    private $definitions = array();

    private $customOrderStates = array();

    /** @var CacheHandler */
    private $cacheHandler;

    /** @var Translator */
    private $translator;

    public function __construct(
        array $definitions,
        CacheHandler $cacheHandler,
        Translator $translator
    ) {
        $this->definitions = $definitions;
        $this->cacheHandler = $cacheHandler;
        $this->translator = $translator;
    }

    /**
     * @throws Exception
     */
    public function register()
    {
        foreach($this->getCustomOrderStates() as $slug => $definition) {
                register_post_status($slug, array(
                    'label'                     => $definition['name'],
                    'public'                    => true,
                    'show_in_admin_status_list' => true,
                    'show_in_admin_all_list'    => true,
                    'exclude_from_search'       => false,
                    'label_count'               => _n_noop($definition['count'], $definition['count'])
                ));
        }
    }

    /**
     * @param array $order_statuses
     * @return array
     * @throws Exception
     */
    public function addOrderStates(array $order_statuses)
    {
        if (empty($this->customOrderStates)) {
            $customOrderStates = $this->getCustomOrderStates();

            $this->customOrderStates = array();

            foreach($customOrderStates as $slug => $definition) {
                $this->customOrderStates[$slug] = $definition['name'];
            }
        }

        return array_merge($order_statuses, $this->customOrderStates);
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getCustomOrderStates()
    {
        $customOrderStates = $this->cacheHandler->loadEntry('custom-order-states');

        if ($customOrderStates === null) {
            $customOrderStates = $this->buildCustomOrderStates();

            $this->cacheHandler->saveEntry('custom-order-states', $customOrderStates);
        }

        return $customOrderStates;
    }

    protected function buildCustomOrderStates()
    {
        $customOrderStates = array();

        foreach($this->definitions as $code => $definition) {
            if (array_key_exists('create', $definition) && $definition['create']) {
                $translate = $definition['source']['translate'];

                $name = $this->translator->get($translate);
                $slug = 'wc-' . $definition['source']['code'];

                $customOrderStates[$slug] = array(
                    'name' => $name,
                    'count' => $name . ' <span class="count">(%s)</span>'
                );
            }
        }

        return $customOrderStates;
    }
}
