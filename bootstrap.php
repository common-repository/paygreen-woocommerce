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

use PGI\Module\PGLog\Interfaces\LoggerInterface;
use PGI\Module\PGShop\Interfaces\Entities\ShopEntityInterface;
use PGI\Module\PGShop\Services\Handlers\ShopHandler;
use PGI\Module\PGSystem\Components\Bootstrap as BootstrapComponent;

/**
 * @param Exception $exception
 * @param bool $throw
 * @throws Exception
 */
function catchLowLevelException(Exception $exception, $throw = true)
{
    $file = $exception->getFile();
    $line = $exception->getLine();
    $message = "Error during Paygreen module execution ($file#$line) : {$exception->getMessage()}";

    error_log($message);

    if (defined('PAYGREEN_ENV') && (PAYGREEN_ENV === 'DEV')) {
        die($message);
    } elseif ($throw) {
        throw $exception;
    }
}

try {
    // #############################################################################################
    // Setting module constants
    // #############################################################################################

    if (!defined('DS')) {
        define('DS', DIRECTORY_SEPARATOR);
    }

    $varPath = get_temp_dir();
    if ($varPath === '/tmp/') {
        $varPath = WP_CONTENT_DIR . DS . 'var' . DS;
    }

    define('PAYGREEN_MODULE_DIR', WP_PLUGIN_DIR . DS . 'paygreen-woocommerce');
    define('PAYGREEN_MODULE_NAME', plugin_basename(PAYGREEN_MODULE_FILE));
    define('PAYGREEN_VENDOR_DIR', PAYGREEN_MODULE_DIR . DS . 'bundles');
    define('PAYGREEN_VAR_DIR', $varPath . 'paygreen');
    define('PAYGREEN_MEDIA_DIR', WP_CONTENT_DIR . DS . 'uploads' . DS . 'paygreen');
    define('PAYGREEN_DATA_DIR', PAYGREEN_MODULE_DIR . DS . 'data');
    define('PAYGREEN_DB_PREFIX', $GLOBALS['wpdb']->base_prefix);
    define('PAYGREEN_CONTENT_URL', content_url());

    define('PAYGREEN_MODULE_VERSION', require(PAYGREEN_DATA_DIR . DS . 'module_version.php'));

    require_once(PAYGREEN_MODULE_DIR . DS . 'includer.php');

    // #############################################################################################
    // Running Bootstrap
    // #############################################################################################

    $bootstrap = new BootstrapComponent();
    
    $bootstrap
        ->buildKernel(PAYGREEN_DATA_DIR)
        ->buildPathfinder(array(
            'static' => PAYGREEN_MODULE_DIR . '/static',
            'module' => PAYGREEN_MODULE_DIR,
            'data' => PAYGREEN_MODULE_DIR . '/data',
            'var' => PAYGREEN_VAR_DIR,
            'log' => PAYGREEN_VAR_DIR . '/logs',
            'cache' => PAYGREEN_VAR_DIR . '/cache',
            'media' => PAYGREEN_MEDIA_DIR,
            'templates' => PAYGREEN_MODULE_DIR . '/templates'
        ))
        ->createVarFolder()
        ->registerAutoloader('PGI\Module\PGSystem\Components\Builders\AutoloaderCompiled')
        ->buildContainer()
        ->insertStaticServices()
    ;

    /** @var ShopHandler $shopHandler */
    $shopHandler = $bootstrap->getContainer()->get('handler.shop');

    /** @var ShopEntityInterface $shop */
    $shop = $shopHandler->getCurrentShop();

    if ($shopHandler->isMultiShopActivated()) {
        define('PAYGREEN_CACHE_PREFIX', 'shop-' . $shop->id());
    }

    $bootstrap->setup();

    // #############################################################################################
    // Init Shop
    // #############################################################################################

    /** @var LoggerInterface $logger */
    $logger = $bootstrap->getContainer()->get('logger');

    $logger->debug("Current shop detected : {$shop->getName()} #{$shop->id()}.");
    $logger->debug("Running PayGreen module for URI : {$_SERVER['REQUEST_URI']}");


    // #############################################################################################
    // Logging PHP errors
    // #############################################################################################

    if (PAYGREEN_ENV === 'DEV') {
        ini_set('error_log', $bootstrap->getPathfinder()->toAbsolutePath('log', '/error.log'));
    }
} catch (Exception $exception) {
    catchLowLevelException($exception);
}
