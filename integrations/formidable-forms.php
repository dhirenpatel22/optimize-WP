<?php
/**
 * Optimize WP – Formidable Forms integration.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Optimize_WP_Formidable_Forms' ) ) {

    final class Optimize_WP_Formidable_Forms {

        public static function init() {
            // Keep the admin bar clean.
            add_action( 'wp_before_admin_bar_render', array( __CLASS__, 'remove_admin_bar_items' ), 20 );
        }

        public static function remove_admin_bar_items() {
            global $wp_admin_bar;

            if ( ! is_object( $wp_admin_bar ) ) {
                return;
            }

            $wp_admin_bar->remove_menu( 'formidable' );
        }
    }
}

Optimize_WP_Formidable_Forms::init();

