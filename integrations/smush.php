<?php
/**
 * Optimize WP – Smush integration.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Optimize_WP_Smush' ) ) {

    final class Optimize_WP_Smush {

        public static function init() {
            // Hide Smush admin bar menu.
            add_filter( 'wp_smush_show_admin_bar_menu', '__return_false' );
        }
    }
}

Optimize_WP_Smush::init();

