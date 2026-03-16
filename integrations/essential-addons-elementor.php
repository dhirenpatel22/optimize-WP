<?php
/**
 * Optimize WP – Essential Addons for Elementor integration.
 *
 * Light touch: cleans up admin bar only.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Optimize_WP_Essential_Addons_Elementor' ) ) {

    final class Optimize_WP_Essential_Addons_Elementor {

        public static function init() {
            add_action( 'wp_before_admin_bar_render', array( __CLASS__, 'remove_admin_bar_items' ), 20 );
        }

        public static function remove_admin_bar_items() {
            global $wp_admin_bar;

            if ( ! is_object( $wp_admin_bar ) ) {
                return;
            }

            $wp_admin_bar->remove_menu( 'eael-admin-bar' );
        }
    }
}

Optimize_WP_Essential_Addons_Elementor::init();

