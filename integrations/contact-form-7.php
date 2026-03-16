<?php
/**
 * Optimize WP – Contact Form 7 integration.
 *
 * Keeps tweaks extremely conservative to avoid breaking forms.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Optimize_WP_Contact_Form_7' ) ) {

    final class Optimize_WP_Contact_Form_7 {

        public static function init() {
            // Reduce automatic reCAPTCHA script loading in admin screens where not needed.
            add_filter( 'wpcf7_load_js', array( __CLASS__, 'maybe_limit_js_loading' ) );
        }

        /**
         * Keep CF7 JS disabled in admin; front-end behavior is left untouched.
         *
         * @param bool $load_js Whether to load JS.
         * @return bool
         */
        public static function maybe_limit_js_loading( $load_js ) {
            if ( is_admin() ) {
                return false;
            }

            return $load_js;
        }
    }
}

Optimize_WP_Contact_Form_7::init();

