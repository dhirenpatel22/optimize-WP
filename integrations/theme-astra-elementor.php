<?php
/**
 * Optimize WP – Astra + Elementor integration.
 *
 * Tweaks Astra output on pages built with Elementor to avoid duplicate markup
 * (titles, headers, footers) while keeping the site stable.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Optimize_WP_Theme_Astra_Elementor' ) ) {

    final class Optimize_WP_Theme_Astra_Elementor {

        public static function init() {
            // Run after Elementor / Astra have had a chance to register locations.
            add_action( 'template_redirect', array( __CLASS__, 'setup_elementor_page_filters' ), 5 );
        }

        /**
         * Attach filters, but only for Elementor-built singular pages.
         */
        public static function setup_elementor_page_filters() {
            if ( ! self::is_elementor_page() ) {
                return;
            }

            // Hide Astra page title when Elementor controls the page.
            add_filter( 'astra_the_title_enabled', '__return_false' );

            // If Elementor theme builder provides header/footer, let it take over.
            if ( function_exists( 'elementor_theme_do_location' ) ) {
                if ( elementor_theme_do_location( 'header' ) ) {
                    add_filter( 'astra_primary_header_enabled', '__return_false' );
                }

                if ( elementor_theme_do_location( 'footer' ) ) {
                    add_filter( 'astra_footer_sml_layout_enabled', '__return_false' );
                }
            }
        }

        /**
         * Check whether the current request is for a page built with Elementor.
         *
         * @return bool
         */
        private static function is_elementor_page() {
            if ( ! did_action( 'elementor/loaded' ) ) {
                return false;
            }

            if ( ! is_singular() ) {
                return false;
            }

            $post_id = get_queried_object_id();

            if ( ! $post_id ) {
                return false;
            }

            try {
                $document = \Elementor\Plugin::$instance->documents->get( $post_id );

                if ( $document && method_exists( $document, 'is_built_with_elementor' ) ) {
                    return (bool) $document->is_built_with_elementor();
                }
            } catch ( \Exception $e ) {
                return false;
            }

            return false;
        }
    }
}

Optimize_WP_Theme_Astra_Elementor::init();

