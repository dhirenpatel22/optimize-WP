<?php
/**
 * Optimize WP – W3 Total Cache integration.
 *
 * Keeps W3TC behavior, only trims admin bar/menu noise.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Optimize_WP_W3_Total_Cache' ) ) {

    final class Optimize_WP_W3_Total_Cache {

        public static function init() {
            // Remove W3TC from admin bar to reduce clutter.
            add_action( 'wp_before_admin_bar_render', array( __CLASS__, 'remove_admin_bar_items' ), 20 );
        }

        public static function remove_admin_bar_items() {
            global $wp_admin_bar;

            if ( ! is_object( $wp_admin_bar ) ) {
                return;
            }

            $wp_admin_bar->remove_menu( 'w3tc' );
        }
    }
}

Optimize_WP_W3_Total_Cache::init();

