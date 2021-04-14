<?php namespace F13\Twitter\Controllers;

class Control
{
    private $cache_timeout;

    public function __construct()
    {
        add_shortcode('latest_tweet', array($this, 'latest_tweet'));
        add_shortcode('tweet', array($this, 'tweet'));
        add_shortcode('twitter_profile', array($this, 'profile'));
        add_action('widgets_init', array($this, 'widget'));

        $this->cache_timeout = get_option('cache_timeout','f13-twitter-group' );
    }

    public function _check_cache( $timeout )
    {
        if ( empty($timeout) ) {
            $timeout = (int) $this->cache_timeout;
        }
        if ( (int) $timeout < 1 ) {
            $timeout = 1;
        }

        $timeout = $timeout * 60;

        return $timeout;
    }

    public function _check_tweets( $tweets, $zero = true )
    {
        if ( (int) $tweets < 1 || empty($tweets)) {
            $tweets = 1;
            if ($zero) {
                $tweets = 0;
            }
        }

        return (int) $tweets;
    }

    public function latest_tweet($atts)
    {
        extract(shortcode_atts(array('user' => false, 'count' => '1', 'cache' => ''), $atts));
        $cache = $this->_check_cache( $cache );
        $c = new Tweet( );
        return $c->latest_tweet( $user, $count, $cache );
    }

    public function tweet($atts)
    {
        extract(shortcode_atts(array('id' => '20', 'cache' => ''), $atts));
        $cache = $this->_check_cache( $cache );
        $c = new Tweet( );
        return $c->tweet( $id, $cache );
    }

    public function profile($atts)
    {
        extract(shortcode_atts(array('user' => false, 'tweets' => '', 'cache' => ''), $atts));
        $tweets = $this->_check_tweets( $tweets );
        $cache = $this->_check_cache( $cache );
        $c = new Profile( );
        return $c->profile( $user, $tweets, $cache );
    }

    public function widget()
    {
        $cache = $this->_check_cache( null );
        $c = new Profile_widget( $cache );
        register_widget($c);
    }
}