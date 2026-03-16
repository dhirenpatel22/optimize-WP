<?php
/**
 * Optimize WP – WP Super Cache integration.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Optimize_WP_WP_Super_Cache' ) ) {

    final class Optimize_WP_WP_Super_Cache {

        public static function init() {
            // Remove WP Super Cache from admin bar to reduce clutter.
            add_action( 'wp_before_admin_bar_render', array( __CLASS__, 'remove_admin_bar_items' ), 20 );
        }

        public static function remove_admin_bar_items() {
            global $wp_admin_bar;

            if ( ! is_object( $wp_admin_bar ) ) {
                return;
            }

            $wp_admin_bar->remove_menu( 'wpsc' );
        }
    }
}

Optimize_WP_WP_Super_Cache::init();

