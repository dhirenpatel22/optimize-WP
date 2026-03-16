<?php
/**
 * Optimize WP – Wordfence integration.
 *
 * Very conservative: mainly admin bar cleanup.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Optimize_WP_Wordfence' ) ) {

    final class Optimize_WP_Wordfence {

        public static function init() {
            add_action( 'wp_before_admin_bar_render', array( __CLASS__, 'remove_admin_bar_items' ), 20 );
        }

        public static function remove_admin_bar_items() {
            global $wp_admin_bar;

            if ( ! is_object( $wp_admin_bar ) ) {
                return;
            }

            $wp_admin_bar->remove_menu( 'wordfence' );
        }
    }
}

Optimize_WP_Wordfence::init();

