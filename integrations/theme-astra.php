<?php
/**
 * Optimize WP – Astra theme integration.
 *
 * Lightweight tweaks that only apply when Astra is the active theme (or a child of Astra).
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Optimize_WP_Theme_Astra' ) ) {

    final class Optimize_WP_Theme_Astra {

        public static function init() {
            // Ensure no default Google Fonts output if you are handling fonts elsewhere.
            add_filter( 'astra_google_fonts', array( __CLASS__, 'maybe_disable_google_fonts' ) );

            // Optionally trim schema output if you prefer SEO plugins to handle it.
            add_filter( 'astra_schema_enabled', '__return_false' );
        }

        /**
         * Disable Astra's Google Fonts list if you don't need it.
         *
         * @param array $fonts
         * @return array
         */
        public static function maybe_disable_google_fonts( $fonts ) {
            return array();
        }
    }
}

Optimize_WP_Theme_Astra::init();

