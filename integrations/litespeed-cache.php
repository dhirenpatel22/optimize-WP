<?php
/**
 * Optimize WP – LiteSpeed Cache integration.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Optimize_WP_LiteSpeed_Cache' ) ) {

    final class Optimize_WP_LiteSpeed_Cache {

        public static function init() {
            // Remove LSCache admin bar menu entry.
            add_action( 'wp_before_admin_bar_render', array( __CLASS__, 'remove_admin_bar_items' ), 20 );
        }

        public static function remove_admin_bar_items() {
            global $wp_admin_bar;

            if ( ! is_object( $wp_admin_bar ) ) {
                return;
            }

            $wp_admin_bar->remove_menu( 'litespeed-menu' );
        }
    }
}

Optimize_WP_LiteSpeed_Cache::init();

