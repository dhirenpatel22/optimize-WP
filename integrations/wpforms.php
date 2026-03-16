<?php
/**
 * Optimize WP – WPForms integration.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Optimize_WP_WPForms' ) ) {

    final class Optimize_WP_WPForms {

        public static function init() {
            // Prevent loading WPForms assets in WordPress admin list screens where not necessary.
            add_action( 'admin_enqueue_scripts', array( __CLASS__, 'limit_admin_assets' ), 20 );
        }

        public static function limit_admin_assets( $hook ) {
            // Only allow WPForms admin assets on its own pages; this is conservative.
            if ( strpos( $hook, 'wpforms' ) === false ) {
                wp_dequeue_style( 'wpforms-full' );
                wp_dequeue_script( 'wpforms-full' );
            }
        }
    }
}

Optimize_WP_WPForms::init();

