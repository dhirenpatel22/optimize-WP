<?php
/**
 * Optimize WP – Elementor integration.
 *
 * Tiny cleanup for Elementor when active.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Optimize_WP_Elementor' ) ) {

    final class Optimize_WP_Elementor {

        public static function init() {
            // Disable default Elementor Font Awesome loading; many themes bundle their own.
            add_filter( 'elementor/frontend/print_google_fonts', '__return_false' );
        }
    }
}

Optimize_WP_Elementor::init();

