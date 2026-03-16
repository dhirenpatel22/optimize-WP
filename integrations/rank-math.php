<?php
/**
 * Optimize WP – Rank Math SEO integration.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Optimize_WP_Rank_Math' ) ) {

    final class Optimize_WP_Rank_Math {

        public static function init() {
            // Disable Rank Math admin bar menu to reduce logged-in front-end overhead.
            add_filter( 'rank_math/admin_bar/items', '__return_empty_array' );
        }
    }
}

Optimize_WP_Rank_Math::init();

