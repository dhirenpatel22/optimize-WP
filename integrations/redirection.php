<?php
/**
 * Optimize WP – Redirection plugin integration.
 *
 * Keeps things lightweight by trimming admin bar items only.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Optimize_WP_Redirection' ) ) {

    final class Optimize_WP_Redirection {

        public static function init() {
            add_action( 'wp_before_admin_bar_render', array( __CLASS__, 'remove_admin_bar_items' ), 20 );
        }

        public static function remove_admin_bar_items() {
            global $wp_admin_bar;

            if ( ! is_object( $wp_admin_bar ) ) {
                return;
            }

            // Redirection admin bar node id.
            $wp_admin_bar->remove_menu( 'redirection' );
        }
    }
}

Optimize_WP_Redirection::init();

