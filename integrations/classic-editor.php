<?php
/**
 * Optimize WP – Classic Editor integration.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Optimize_WP_Classic_Editor' ) ) {

    final class Optimize_WP_Classic_Editor {

        public static function init() {
            // No heavy tweaks for Classic Editor yet; reserved for future use.
        }
    }
}

Optimize_WP_Classic_Editor::init();

