<?php namespace F13\Twitter\Controllers;

class Profile
{
    public function __construct( )
    {
        $this->settings = array(
            'oauth_access_token' => get_option('f13_twitter_access_token','f13-twitter-group' ),
            'oauth_access_token_secret' => get_option('f13_twitter_access_token_secret','f13-twitter-group' ),
            'consumer_key' => get_option('f13_twitter_access_api_key','f13-twitter-group' ),
            'consumer_secret' => get_option('f13_twitter_access_api_key_secret','f13-twitter-group' ),
        );
    }

    public function profile( $user = false, $tweets = 1, $cache = 1 )
    {
        $cache_key = 'f13_twitter_profile_'.md5($user.'-'.$tweets.'-'.$cache);

        $transient = get_transient( $cache_key );
        if ( $transient ) {
            echo '<script>console.log("Building twitter profile shortcode from transient: '.$cache_key.'");</script>';
            return $transient;
            return;
        }

        $tweets_get = $tweets;
        if ($tweets == 0) {
            $tweets_get = 1;
        }
        $m = new \F13\Twitter\Models\Twitter_api($this->settings);
        $url = "https://api.twitter.com/1.1/statuses/user_timeline.json";
        $data = json_decode(
            $m->setGetField('?screen_name='.$user.'&count='.$tweets_get)
              ->buildOauth($url, 'GET')
              ->performRequest(),
        $assoc = true);

        //print('<pre>'.print_r($data, true).'</pre>');

        if (array_key_exists('errors', $data)) {
            return '<div style="text-align: center; margin: 0.5em 0; padding: 0.5em; background: #ffcccc; border: 1px solid #222;">'.$data['errors'][0]['message'].'</div>';
        }

        $v = new \F13\Twitter\Views\Profile(array(
            'data' => $data,
            'tweets' => $tweets,
        ));

        $return = $v->profile();

        set_transient($cache_key, $return, $cache);
        echo '<script>console.log("Building twitter profile shortcode from API, setting transient: '.$cache_key.'");</script>';

        return $return;
    }
}