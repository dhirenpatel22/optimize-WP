<?php
/**
 * Optimize WP – All in One SEO integration.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Optimize_WP_AIOSEO' ) ) {

    final class Optimize_WP_AIOSEO {

        public static function init() {
            // Hide AIOSEO admin bar menu to reduce overhead for logged-in users.
            add_filter( 'aioseo_admin_bar_menu', '__return_false' );
        }
    }
}

Optimize_WP_AIOSEO::init();

