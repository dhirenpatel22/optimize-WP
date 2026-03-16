<?php
/**
 * Optimize WP – UpdraftPlus integration.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Optimize_WP_UpdraftPlus' ) ) {

    final class Optimize_WP_UpdraftPlus {

        public static function init() {
            // Remove UpdraftPlus from admin bar.
            add_action( 'wp_before_admin_bar_render', array( __CLASS__, 'remove_admin_bar_items' ), 20 );
        }

        public static function remove_admin_bar_items() {
            global $wp_admin_bar;

            if ( ! is_object( $wp_admin_bar ) ) {
                return;
            }

            $wp_admin_bar->remove_menu( 'updraft_admin_node' );
        }
    }
}

Optimize_WP_UpdraftPlus::init();

