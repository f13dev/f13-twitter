<?php namespace F13\Twitter\Controllers;

class Tweet
{
    private $cache;
    private $count;
    private $settings;
    private $user;

    public function __construct( )
    {
        $this->settings = array(
            'oauth_access_token' => get_option('f13_twitter_access_token','f13-twitter-group' ),
            'oauth_access_token_secret' => get_option('f13_twitter_access_token_secret','f13-twitter-group' ),
            'consumer_key' => get_option('f13_twitter_access_api_key','f13-twitter-group' ),
            'consumer_secret' => get_option('f13_twitter_access_api_key_secret','f13-twitter-group' ),
        );
    }

    public function latest_tweet($user = false, $count = 1, $cache = 1)
    {
        if (!$user) {
            $user = get_option('f13_twitter_widget_user', 'f13-twitter-group');
        }

        $cache_key = 'f13_latest_tweet_'.md5($user.'-'.$count.'-'.$cache);

        $transient = get_transient( $cache_key );
        if ( $transient ) {
            echo '<script>console.log("Building tweet from transient: '.$cache_key.'");</script>';
            return $transient;
        }

        $m = new \F13\Twitter\Models\Twitter_api($this->settings);
        $url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
        $data = json_decode(
            $m->setGetField('?screen_name='.$user.'&count='.$count)
              ->buildOauth($url, 'GET')
              ->performRequest(),
        $assoc = true);

        $v = new \F13\Twitter\Views\Tweet(array(
            'data' => $data
        ));

        $return = $v->tweet();

        set_transient($cache_key, $return, $cache);
        echo '<script>console.log("Building tweet from API, setting transient: '.$cache_key.'");</script>';

        return $return;
    }

    public function tweet( $id = '20', $cache = '1' )
    {
        $cache_key = 'f13_tweet_'.md5($id, $cache);

        $cache = get_transient( $cache_key );
        if ($cache) {
            return $cache;
        }

        $m = new \F13\Twitter\Models\Twitter_api($this->settings);
        $url = 'https://api.twitter.com/1.1/statuses/show.json';
        $data = json_decode(
            $m->setGetField('?id='.$id)
              ->buildOauth($url, 'GET')
              ->performRequest(),
        $assoc = true);

        if (array_key_exists('errors', $data)) {
            return '<div style="text-align:center; background: #ffcccc; padding: 0.5em; margin: 0.5em 0; border: 1px solid #222;">'.$data['errors'][0]['message'].'</div>';
        }

        $v = new \F13\Twitter\Views\Tweet(array(
            'data' => $data
        ));

        $return = $v->tweet();

        set_transient($cache_key, $return, $cache);

        return $return;
    }
}