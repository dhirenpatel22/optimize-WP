<?php
/**
 * Optimize WP – Hello Elementor theme integration.
 *
 * Hello is already very minimal; this is mostly a hook point for future tweaks.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Optimize_WP_Theme_Hello_Elementor' ) ) {

    final class Optimize_WP_Theme_Hello_Elementor {

        public static function init() {
            // Currently no heavy tweaks – Hello is intentionally barebones.
            // This file exists so you can easily extend behavior later if needed.
        }
    }
}

Optimize_WP_Theme_Hello_Elementor::init();

