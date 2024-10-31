<?php

use PGI\Module\PGWordPress\Bridges\WordPressBridge as WordPressBridgeBridge;

/**
 * Plugin Name: PayGreen WooCommerce
 * Plugin URI: http://www.paygreen.io
 * Description: PayGreen, solution de paiement Frenchy et solidaire pour WooCommerce
 * Author: WattIsIt
 * Original Author: Renaud Gerson
 * Version: 4.10.2
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('WC_PayGreen')) {
    define('PAYGREEN_MODULE_FILE', __FILE__);

    require_once dirname(PAYGREEN_MODULE_FILE) . DIRECTORY_SEPARATOR . 'bootstrap.php';

    new WordPressBridgeBridge();
}
