<?php
/*
Plugin Name: F13 Twitter
Plugin URI: https://f13.dev/wordpress-plugins/wordpress-plugin-twitter/
Description: Twitter profile widget, and tweet shortcode
Version: 0.0.1
Author: Jim Valentine
Author URI: https://www.f13.dev
Text Domain: f13
*/

namespace F13\Twitter;

if (!isset($wpdb)) global $wpdb;
if (!function_exists('get_plugins')) require_once(ABSPATH.'wp-admin/includes/plugin.php');
if (!defined('F13_TWITTER')) define('F13_TWITTER', get_plugin_data(__FILE__, false, false)['Version']);
if (!defined('F13_TWITTER_PATH')) define('F13_TWITTER_PATH', plugin_dir_path( __FILE__ ));
if (!defined('F13_TWITTER_URL')) define('F13_TWITTER_URL', plugin_dir_url(__FILE__));

class Plugin
{
    public function init()
    {
        spl_autoload_register(__NAMESPACE__.'\Plugin::autoload');

        add_action('wp_enqueue_scripts', array($this, 'style_and_scripts'));
        add_action('admin_enqueue_scripts', array($this, 'admin_style_and_scripts'));



        if (is_admin()) {
            $a = new Controllers\Admin();
        }

        $c = new Controllers\Control();
    }

    public static function autoload($class)
    {
        $class = ltrim($class, '\\');
        if (strpos($class, __NAMESPACE__) !== 0) return;
        $class = ltrim(str_replace(__NAMESPACE__, '', $class), '\\');
        $path = F13_TWITTER_PATH.strtolower(str_replace('\\', DIRECTORY_SEPARATOR, $class).'.php');
        require_once $path;
    }

    public function style_and_scripts()
    {
        $styles_ver  = date("ymd-Gis", filemtime( plugin_dir_path( __FILE__ ) . 'css/styles.css' ));
        wp_enqueue_style('f13_twitter_styles', F13_TWITTER_URL.'css/styles.css', array(), $styles_ver);
        wp_enqueue_script('twitter', 'https://platform.twitter.com/widgets.js', array());
    }

    public function admin_style_and_scripts()
    {

    }
}

$p = new Plugin();
$p->init();