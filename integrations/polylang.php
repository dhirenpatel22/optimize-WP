<?php
/**
 * Optimize WP – Polylang integration.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Optimize_WP_Polylang' ) ) {

    final class Optimize_WP_Polylang {

        public static function init() {
            // Hide Polylang admin bar menu if not needed.
            add_filter( 'pll_admin_bar', '__return_false' );
        }
    }
}

Optimize_WP_Polylang::init();

