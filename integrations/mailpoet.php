<?php
/**
 * Optimize WP – MailPoet integration.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Optimize_WP_MailPoet' ) ) {

    final class Optimize_WP_MailPoet {

        public static function init() {
            // Hide MailPoet admin bar shortcut.
            add_filter( 'mailpoet_display_admin_bar_menu', '__return_false' );
        }
    }
}

Optimize_WP_MailPoet::init();

