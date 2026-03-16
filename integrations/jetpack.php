<?php
/**
 * Optimize WP – Jetpack integration.
 *
 * Does not disable modules; only trims front-end/admin bar noise.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Optimize_WP_Jetpack' ) ) {

    final class Optimize_WP_Jetpack {

        public static function init() {
            // Remove Jetpack admin bar menu to reduce clutter.
            add_action( 'wp_before_admin_bar_render', array( __CLASS__, 'remove_admin_bar_items' ), 20 );
        }

        public static function remove_admin_bar_items() {
            global $wp_admin_bar;

            if ( ! is_object( $wp_admin_bar ) ) {
                return;
            }

            $wp_admin_bar->remove_menu( 'jetpack' );
        }
    }
}

Optimize_WP_Jetpack::init();

