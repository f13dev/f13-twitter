<?php namespace F13\Twitter\Controllers;


class Profile_widget extends \WP_Widget
{
    public $cache;
    public $settings;
    var $textdomain;
    var $fields;

    function __construct( $settings, $cache = 1 )
    {
        $this->cache = $cache;
        $this->settings = array(
            'oauth_access_token' => get_option('f13_twitter_access_token','f13-twitter-group' ),
            'oauth_access_token_secret' => get_option('f13_twitter_access_token_secret','f13-twitter-group' ),
            'consumer_key' => get_option('f13_twitter_access_api_key','f13-twitter-group' ),
            'consumer_secret' => get_option('f13_twitter_access_api_key_secret','f13-twitter-group' ),
        );
        $this->textdomain = strtolower(get_class($this));

        $this->add_field('title', 'Enter title', '', 'text');

        parent::__construct($this->textdomain, __('Twitter Profile Widget', 'f13-twitter'), array( 'description' => __('Some description', 'f13-twitter'), 'classname' => 'f13-twitter'));
    }

    public function widget($args, $instance)
    {
        $cache_key = 'f13_twitter_widget_'.serialize($instance);

        $cache = get_transient( $cache_key );
        if ( $cache ) {
            echo $cache;
            return;
        }

        $tweets_get = $tweets = get_option('f13_twitter_widget_tweets','f13-twitter-group' );;
        if ($tweets == 0) {
            $tweets_get = 1;
        }
        $m = new \F13\Twitter\Models\Twitter_api($this->settings);
        $url = "https://api.twitter.com/1.1/statuses/user_timeline.json";
        $data = json_decode(
            $m->setGetField('?screen_name='.get_option('f13_twitter_widget_user','f13-twitter-group' ).'&count='.$tweets_get)
              ->buildOauth($url, 'GET')
              ->performRequest(),
        $assoc = true);

        $v = new \F13\Twitter\Views\Profile(array(
            'data' => $data,
            'tweets' => $tweets,
        ));

        $return = $v->profile();

        echo $return;
    }

    public function form( $instance )
    {
        $v = '<p>Set your Twitter API tokens in the <a href="'.admin_url('admin.php').'?page=f13-settings-twitter">F13 Admin menu</a></p>';
        foreach($this->fields as $field_name => $field_data)
        {
            if($field_data['type'] === 'text')
            {
                $v .= '<p>';
                    $v .= '<label for="'.$this->get_field_id($field_name).'">'._e($field_data['description'], $this->textdomain ).'</label>';
                    $v .= '<input class="widefat" id="'.$this->get_field_id($field_name).'" name="'.$this->get_field_name($field_name).'" type="text" value="'.esc_attr(isset($instance[$field_name]) ? $instance[$field_name] : $field_data['default_value']).'" />';
                $v .= '</p>';
            }
            elseif($field_data['type'] === 'number')
            {
                $v .= '<p>';
                    $v .= '<label for="'.$this->get_field_id($field_name).'">'._e($field_data['description'], $this->textdomain ).'></label>';
                    $v .= '<input class="widefat" id="'.$this->get_field_id($field_name).'" name="'.$this->get_field_name($field_name).'" type="number" value="'.esc_attr(isset($instance[$field_name]) ? $instance[$field_name] : $field_data['default_value']).'" />';
                $v .= '</p>';
            }
            elseif($field_data['type'] === 'password')
            {
                $v .= '<p>';
                    $v .= '<label for="'.$this->get_field_id($field_name).'">'._e($field_data['description'], $this->textdomain ).'</label>';
                    $v .= '<input class="widefat" id="'.$this->get_field_id($field_name).'" name="'.$this->get_field_name($field_name).'" type="password" value="'.esc_attr(isset($instance[$field_name]) ? $instance[$field_name] : $field_data['default_value']).'" />';
                $v .= '</p>';
            }
            elseif($field_data['type'] === 'checkbox')
            {
                $v .= '<p>';
                    $v .= '<label for="'.$this->get_field_id($field_name).'">'._e($field_data['description'], $this->textdomain ).'</label><br />';
                    $v .= '<input id="'.$this->get_field_id($field_name).'" name="'.$this->get_field_name($field_name).'" type="checkbox"';
                    if (esc_attr($instance[$field_name]) == true)
                    {
                        $v .= ' checked';
                    }
                    $v .= '/>';
                $v .= '</p>';
            }
            /* Otherwise show an error */
            else
            {
                $v .= __('Error - Field type not supported', $this->textdomain) . ': ' . $field_data['type'];
            }
        }

        echo $v;
    }

    public function update($new_instance, $old_instance)
    {
        return $new_instance;
    }

    private function add_field($field_name, $field_description = '', $field_default_value = '', $field_type = 'text')
    {
        if(!is_array($this->fields))
            $this->fields = array();

        $this->fields[$field_name] = array('name' => $field_name, 'description' => $field_description, 'default_value' => $field_default_value, 'type' => $field_type);
    }

}