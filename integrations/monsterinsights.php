<?php
/**
 * Optimize WP – MonsterInsights (Google Analytics for WordPress) integration.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Optimize_WP_MonsterInsights' ) ) {

    final class Optimize_WP_MonsterInsights {

        public static function init() {
            // Remove MonsterInsights admin bar menu to reduce overhead.
            add_filter( 'monsterinsights_show_admin_bar_menu', '__return_false' );
        }
    }
}

Optimize_WP_MonsterInsights::init();

