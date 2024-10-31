<?php

use PGI\Module\PGSystem\Services\Container;
use PGI\Module\PGWordPress\Services\Handlers\FrontofficeHandler;

/**
Template Name: PayGreen Frontoffice
Template Post Type: page
*/


/** @var FrontofficeHandler $frontOfficeHandler */
$frontOfficeHandler = Container::getInstance()->get('handler.frontoffice');

$content = $frontOfficeHandler->run();

get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

        <p><?php echo $content; ?></p>

    </main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();