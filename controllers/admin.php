<?php namespace F13\Twitter\Controllers;

class Admin
{
    public function __construct()
    {
        add_action( 'admin_menu', array($this, 'admin_menu') );
        add_action( 'admin_init', array($this, 'register_settings') );
    }

    public function admin_menu()
    {
        global $menu;
        $exists = false;
        foreach($menu as $item) {
            if(strtolower($item[0]) == strtolower('F13 Admin')) {
                $exists = true;
            }
        }
        if(!$exists) {
            add_menu_page( 'F13 Settings', 'F13 Admin', 'manage_options', 'f13-settings', array($this, 'f13_settings'), 'dashicons-embed-generic', 4);
            add_submenu_page( 'f13-settings', 'Plugins', 'Plugins', 'manage_options', 'f13-settings', array($this, 'f13_settings'));
        }
        add_submenu_page( 'f13-settings', 'F13 Twitter Settings', 'Twitter', 'manage_options', 'f13-settings-twitter', array($this, 'f13_twitter_settings'));
    }

    public function f13_settings()
    {
        $response = wp_remote_get('https://f13.dev/wp-json/v1/f13-plugins');
        $data     = json_decode(wp_remote_retrieve_body( $response ));

        $v = new \F13\Twitter\Views\Admin(array(
            'data' => $data,
        ));

        echo $v->f13_settings();
    }

    public function f13_twitter_settings()
    {
        $v = new \F13\Twitter\Views\Admin();

        echo $v->twitter_settings();
    }

    public function register_settings()
    {
        register_setting( 'f13-twitter-group', 'f13_twitter_widget_title');
        register_setting( 'f13-twitter-group', 'f13_twitter_widget_user');
        register_setting( 'f13-twitter-group', 'f13_twitter_widget_tweets');
        register_setting( 'f13-twitter-group', 'f13_twitter_widget_bio');
        register_setting( 'f13-twitter-group', 'f13_twitter_widget_stats');
        register_setting( 'f13-twitter-group', 'f13_twitter_widget_follow_button');
        
        register_setting( 'f13-twitter-group', 'f13_twitter_access_token');
        register_setting( 'f13-twitter-group', 'f13_twitter_access_token_secret');
        register_setting( 'f13-twitter-group', 'f13_twitter_access_api_key');
        register_setting( 'f13-twitter-group', 'f13_twitter_access_api_key_secret');
        register_setting( 'f13-twitter-group', 'f13_twitter_cache_timeout');
    }
}