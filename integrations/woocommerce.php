<?php
/**
 * Optimize WP – WooCommerce integration.
 *
 * Applies lightweight, safe tweaks when WooCommerce is active.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Optimize_WP_WooCommerce' ) ) {

    final class Optimize_WP_WooCommerce {

        public static function init() {
            // Remove WooCommerce dashboard status widget to reduce queries on admin dashboard.
            add_action( 'wp_dashboard_setup', array( __CLASS__, 'cleanup_dashboard_widgets' ), 20 );

            // Optional: Disable WooCommerce marketing / suggestions in admin to declutter.
            add_filter( 'woocommerce_allow_marketplace_suggestions', '__return_false' );

            // Reduce background admin notes noise.
            add_filter( 'woocommerce_admin_show_admin_notice', '__return_false' );

            // Disable cart fragments script on non-cart / non-checkout pages for guests to reduce front-end overhead.
            add_action( 'wp_enqueue_scripts', array( __CLASS__, 'maybe_disable_cart_fragments' ), 20 );
        }

        /**
         * Remove WooCommerce dashboard widgets that are not critical.
         */
        public static function cleanup_dashboard_widgets() {
            remove_meta_box( 'woocommerce_dashboard_status', 'dashboard', 'normal' );
        }

        /**
         * Dequeue cart fragments where they are rarely useful to reduce AJAX and JS on the front-end.
         */
        public static function maybe_disable_cart_fragments() {
            if ( is_admin() ) {
                return;
            }

            if ( function_exists( 'is_cart' ) && is_cart() ) {
                return;
            }

            if ( function_exists( 'is_checkout' ) && is_checkout() ) {
                return;
            }

            // Keep for logged-in users (common for shops with accounts).
            if ( is_user_logged_in() ) {
                return;
            }

            wp_dequeue_script( 'wc-cart-fragments' );
            wp_dequeue_script( 'woocommerce-cart-fragments' );
            wp_dequeue_script( 'wc-add-to-cart' );
        }
    }
}

Optimize_WP_WooCommerce::init();

