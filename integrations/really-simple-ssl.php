<?php
/**
 * Optimize WP – Really Simple SSL integration.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Optimize_WP_Really_Simple_SSL' ) ) {

    final class Optimize_WP_Really_Simple_SSL {

        public static function init() {
            // Hide RSSSL admin bar menu.
            add_filter( 'rsssl_admin_bar_menu', '__return_false' );
        }
    }
}

Optimize_WP_Really_Simple_SSL::init();

