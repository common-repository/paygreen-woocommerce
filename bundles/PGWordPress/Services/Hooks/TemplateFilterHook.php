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

class TemplateFilterHook
{
    const TEMPLATE_NAME = 'page-paygreen-frontoffice.php';

    public function filter($page_template)
    {
        $isPayGreenRequest = (isset($_GET['pgaction']) || isset($_POST['pgaction']));

        if (is_front_page() && $isPayGreenRequest) {

            if (file_exists(get_stylesheet_directory() . DS . 'woocommerce' . DS . self::TEMPLATE_NAME)) {
                $page_template = get_stylesheet_directory() . DS . 'woocommerce' . DS . self::TEMPLATE_NAME;
            } elseif (file_exists(get_stylesheet_directory() . DS . self::TEMPLATE_NAME)) {
                $page_template = get_stylesheet_directory() . DS . self::TEMPLATE_NAME;
            } elseif (file_exists(get_template_directory() . DS . 'woocommerce' . DS . self::TEMPLATE_NAME)) {
                $page_template = get_template_directory() . DS . 'woocommerce' . DS . self::TEMPLATE_NAME;
            } elseif (file_exists(get_template_directory() . DS . self::TEMPLATE_NAME)) {
                $page_template = get_template_directory() . DS . self::TEMPLATE_NAME;
            } else {
                $page_template = PAYGREEN_MODULE_DIR . DS . self::TEMPLATE_NAME;
            }

        }

        return $page_template;
    }
}
