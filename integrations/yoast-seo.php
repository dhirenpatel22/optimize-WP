<?php
/**
 * Optimize WP – Yoast SEO integration.
 *
 * Focuses on reducing admin clutter and minor overhead.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Optimize_WP_Yoast_SEO' ) ) {

    final class Optimize_WP_Yoast_SEO {

        public static function init() {
            // Remove Yoast SEO admin bar menu to reduce front-end overhead for logged-in users.
            add_filter( 'wpseo_use_page_analysis', '__return_true' );
            add_action( 'wp_before_admin_bar_render', array( __CLASS__, 'remove_admin_bar_items' ), 20 );

            // Disable Yoast SEO "Text link counter" calculation cron to reduce background tasks.
            add_filter( 'wpseo_link_count_enabled', '__return_false' );
        }

        /**
         * Remove Yoast SEO items from the admin bar.
         */
        public static function remove_admin_bar_items() {
            global $wp_admin_bar;

            if ( ! is_object( $wp_admin_bar ) ) {
                return;
            }

            $wp_admin_bar->remove_menu( 'wpseo-menu' );
        }
    }
}

Optimize_WP_Yoast_SEO::init();

