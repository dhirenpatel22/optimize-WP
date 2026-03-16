<?php
/**
 * Optimize WP – Advanced Custom Fields integration.
 *
 * ACF is very lightweight by default; we only trim admin bar items.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Optimize_WP_Advanced_Custom_Fields' ) ) {

    final class Optimize_WP_Advanced_Custom_Fields {

        public static function init() {
            add_action( 'wp_before_admin_bar_render', array( __CLASS__, 'remove_admin_bar_items' ), 20 );
        }

        public static function remove_admin_bar_items() {
            global $wp_admin_bar;

            if ( ! is_object( $wp_admin_bar ) ) {
                return;
            }

            $wp_admin_bar->remove_menu( 'acf-admin' );
        }
    }
}

Optimize_WP_Advanced_Custom_Fields::init();

