<?php
/**
 * Plugin Name: Optimize WP (Lightweight)
 * Description: Lightweight performance and cleanup plugin that disables several default WordPress features to reduce bloat. No settings; everything works automatically while the plugin is active.
 * Author: Dhiren
 * Version: 0.1.0
 * License: GPL2+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: optimize-wp
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Optimize_WP' ) ) {

    final class Optimize_WP {

        /**
         * Boot the plugin.
         */
        public static function init() {
            // Core cleanup and optimizations.
            add_action( 'init', array( __CLASS__, 'disable_emojis' ) );
            add_action( 'init', array( __CLASS__, 'disable_embeds' ) );
            add_action( 'init', array( __CLASS__, 'cleanup_head' ) );

            // XML-RPC.
            add_filter( 'xmlrpc_enabled', '__return_false' );

            // Disable feeds.
            add_action( 'do_feed', array( __CLASS__, 'disable_feeds' ), 1 );
            add_action( 'do_feed_rdf', array( __CLASS__, 'disable_feeds' ), 1 );
            add_action( 'do_feed_rss', array( __CLASS__, 'disable_feeds' ), 1 );
            add_action( 'do_feed_rss2', array( __CLASS__, 'disable_feeds' ), 1 );
            add_action( 'do_feed_atom', array( __CLASS__, 'disable_feeds' ), 1 );
            add_action( 'do_feed_rss2_comments', array( __CLASS__, 'disable_feeds' ), 1 );
            add_action( 'do_feed_atom_comments', array( __CLASS__, 'disable_feeds' ), 1 );

            // Remove version from scripts and styles query string.
            add_filter( 'script_loader_src', array( __CLASS__, 'remove_asset_version' ), 15, 1 );
            add_filter( 'style_loader_src', array( __CLASS__, 'remove_asset_version' ), 15, 1 );

            // Disable dashicons for non-logged-in users on the front-end.
            add_action( 'wp_enqueue_scripts', array( __CLASS__, 'maybe_disable_dashicons' ), 11 );

            // Disable self pingbacks.
            add_action( 'pre_ping', array( __CLASS__, 'disable_self_pingbacks' ) );

            // Load conditional integrations for popular plugins.
            add_action( 'plugins_loaded', array( __CLASS__, 'maybe_load_integrations' ), 20 );

            // Load theme-specific integrations (e.g. Astra) after theme setup.
            add_action( 'after_setup_theme', array( __CLASS__, 'maybe_load_theme_integrations' ), 20 );
        }

        /**
         * Disable emoji scripts, styles and related filters.
         */
        public static function disable_emojis() {
            remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
            remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
            remove_action( 'wp_print_styles', 'print_emoji_styles' );
            remove_action( 'admin_print_styles', 'print_emoji_styles' );
            remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
            remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
            remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );

            add_filter( 'emoji_svg_url', '__return_false' );
        }

        /**
         * Disable oEmbed discovery, REST oEmbed endpoints, and auto-embeds.
         */
        public static function disable_embeds() {
            // Remove oEmbed discovery links.
            remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
            remove_action( 'wp_head', 'wp_oembed_add_host_js' );

            // Disable REST API oEmbed endpoint.
            remove_action( 'rest_api_init', 'wp_oembed_register_route' );

            // Turn off auto-embeds.
            if ( ! is_admin() ) {
                remove_filter( 'the_content', array( $GLOBALS['wp_embed'], 'autoembed' ), 8 );
            }
        }

        /**
         * Clean up unnecessary tags in <head>.
         */
        public static function cleanup_head() {
            // Remove feed links from head (we also disable feed endpoints separately).
            remove_action( 'wp_head', 'feed_links_extra', 3 ); // Category, tag feeds, etc.
            remove_action( 'wp_head', 'feed_links', 2 );       // General feeds.

            // Really Simple Discovery service endpoint.
            remove_action( 'wp_head', 'rsd_link' );

            // Windows Live Writer manifest.
            remove_action( 'wp_head', 'wlwmanifest_link' );

            // Shortlink.
            remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );

            // WordPress version.
            remove_action( 'wp_head', 'wp_generator' );
            add_filter( 'the_generator', '__return_empty_string' );
        }

        /**
         * Disable all feed endpoints and optionally redirect users.
         */
        public static function disable_feeds() {
            // You can change this to a redirect to home if you prefer.
            wp_die(
                esc_html__( 'No RSS feeds are available. Please visit the website directly.', 'optimize-wp' ),
                esc_html__( 'Feeds Disabled', 'optimize-wp' ),
                array( 'response' => 404 )
            );
        }

        /**
         * Strip the "ver" query argument from asset URLs to improve cacheability.
         *
         * @param string $src Script or style URL.
         * @return string
         */
        public static function remove_asset_version( $src ) {
            if ( strpos( $src, 'ver=' ) !== false ) {
                $src = remove_query_arg( 'ver', $src );
            }

            return $src;
        }

        /**
         * Disable dashicons on the front-end for non-logged-in users.
         */
        public static function maybe_disable_dashicons() {
            if ( is_user_logged_in() ) {
                return;
            }

            wp_deregister_style( 'dashicons' );
        }

        /**
         * Prevent self pingbacks (pings to the same site).
         *
         * @param string[] $links Links about to be pinged.
         */
        public static function disable_self_pingbacks( &$links ) {
            $home = get_option( 'home' );

            foreach ( $links as $index => $link ) {
                if ( 0 === strpos( $link, $home ) ) {
                    unset( $links[ $index ] );
                }
            }
        }

        /**
         * Conditionally load integration files for popular plugins if they are active.
         */
        public static function maybe_load_integrations() {
            if ( ! function_exists( 'is_plugin_active' ) ) {
                require_once ABSPATH . 'wp-admin/includes/plugin.php';
            }

            $integrations_dir = plugin_dir_path( __FILE__ ) . 'integrations/';

            $map = array(
                // SEO.
                'wordpress-seo/wp-seo.php'                  => 'yoast-seo.php',
                'all-in-one-seo-pack/all_in_one_seo_pack.php' => 'aioseo.php',
                'seo-by-rank-math/rank-math.php'           => 'rank-math.php',

                // Forms / builders.
                'contact-form-7/wp-contact-form-7.php'     => 'contact-form-7.php',
                'wpforms-lite/wpforms.php'                 => 'wpforms.php',
                'formidable/formidable.php'                => 'formidable-forms.php',
                'elementor/elementor.php'                  => 'elementor.php',

                // Commerce.
                'woocommerce/woocommerce.php'              => 'woocommerce.php',

                // Performance / caching / images.
                'w3-total-cache/w3-total-cache.php'        => 'w3-total-cache.php',
                'wp-super-cache/wp-cache.php'              => 'wp-super-cache.php',
                'litespeed-cache/litespeed-cache.php'      => 'litespeed-cache.php',
                'wp-smushit/wp-smush.php'                  => 'smush.php',

                // Security / SSL / backups.
                'wordfence/wordfence.php'                  => 'wordfence.php',
                'really-simple-ssl/rlrsssl-really-simple-ssl.php' => 'really-simple-ssl.php',
                'updraftplus/updraftplus.php'              => 'updraftplus.php',

                // Analytics / marketing / email.
                'google-analytics-for-wordpress/googleanalytics.php' => 'monsterinsights.php',
                'mailpoet/mailpoet.php'                    => 'mailpoet.php',
                'jetpack/jetpack.php'                      => 'jetpack.php',

                // Translation / editorial / classic.
                'polylang/polylang.php'                    => 'polylang.php',
                'classic-editor/classic-editor.php'        => 'classic-editor.php',

                // Anti-spam.
                'akismet/akismet.php'                      => 'akismet.php',

                // Other popular utilities.
                'redirection/redirection.php'              => 'redirection.php',
                'ultimate-elementor/ultimate-elementor.php'=> 'ultimate-addons-elementor.php',
                'advanced-custom-fields/acf.php'           => 'advanced-custom-fields.php',
                'essential-addons-for-elementor-lite/essential_adons_elementor.php' => 'essential-addons-elementor.php',
            );

            foreach ( $map as $plugin_file => $integration_file ) {
                if ( is_plugin_active( $plugin_file ) ) {
                    $full_path = $integrations_dir . $integration_file;

                    if ( file_exists( $full_path ) ) {
                        require_once $full_path;
                    }
                }
            }
        }

        /**
         * Conditionally load integration files for active themes.
         */
        public static function maybe_load_theme_integrations() {
            $integrations_dir = plugin_dir_path( __FILE__ ) . 'integrations/';

            if ( ! function_exists( 'wp_get_theme' ) ) {
                return;
            }

            $theme = wp_get_theme();

            if ( ! $theme ) {
                return;
            }

            $template  = $theme->get_template();   // Parent theme slug.
            $stylesheet = $theme->get_stylesheet(); // Child theme slug.

            // Astra integration (works for parent or Astra-based child themes).
            if ( in_array( 'astra', array( $template, $stylesheet ), true ) ) {
                $astra_integration = $integrations_dir . 'theme-astra.php';

                if ( file_exists( $astra_integration ) ) {
                    require_once $astra_integration;
                }

                // Additional Astra + Elementor specific integration if Elementor is active.
                if ( did_action( 'elementor/loaded' ) ) {
                    $astra_elementor_integration = $integrations_dir . 'theme-astra-elementor.php';

                    if ( file_exists( $astra_elementor_integration ) ) {
                        require_once $astra_elementor_integration;
                    }
                }
            }

            // Hello Elementor theme integration (works for parent or child themes).
            if ( in_array( 'hello-elementor', array( $template, $stylesheet ), true ) ) {
                $hello_integration = $integrations_dir . 'theme-hello-elementor.php';

                if ( file_exists( $hello_integration ) ) {
                    require_once $hello_integration;
                }
            }
        }
    }
}

Optimize_WP::init();

