<?php namespace F13\Twitter\Views;

class Profile
{

    public function __construct( $params = array() )
    {
        foreach ($params as $key => $value) {
            $this->{$key} = $value;
        }
    }

    public function profile()
    {
        $v = '<div class="f13-twitter" style="max-width: 100%; border: 1px solid #ccc; border-radius: 10px; margin: auto;">';
            $v .= '<div class="f13-twitter-head" style="position:relative;">';
                $v .= '<img alt="@'.$this->data[0]['user']['screen_name'].' on Twitter" src="' . str_replace('normal', '400x400', $this->data[0]['user']['profile_image_url_https']) . '" style="position: absolute; height: auto; max-width: 22%; border-radius: 60px; border: 4px solid white; margin-top: 22%; margin-left: 5%;" class="f13-twitter-profile-image;"/>';
                $v .= '<img alt="@'.$this->data[0]['user']['screen_name'].' Twitter banner" src="'.$this->data[0]['user']['profile_banner_url'].'" style="border-radius: 10px 10px 0 0; max-width: 100%;">';
            $v .= '</div>';
            $v .= '<div class="f13-twitter-body" style="position:relative">';
                $v .= '<span style="font-size: 22px; margin-left: 30%; display: block;">'.$this->data[0]['user']['name'] .'</span>';
                $v .= '<span style="font-size: 16px; margin-left: 30%; display: block;">';
                    $v .= '<a href="https://twitter.com/'.$this->data[0]['user']['screen_name'].'">';
                        $v .= '@'.$this->data[0]['user']['screen_name'];
                    $v .= '</a>';
                $v .= '</span>';
                $v .= '<div class="f13-twitter-follow">';
                    $v .= '<a href="https://twitter.com/'.$this->data[0]['user']['screen_name'].'?ref_src=twsrc%5Etfw" class="twitter-follow-button" data-show-count="false">
                        Follow @'.$this->data[0]['user']['screen_name'].'
                    </a>';
                $v .= '</div>';
                $v .= '<div style="border-top: 1px solid #ccc; margin-top: 5px;">';
                    $v .= '<span style="display: block; margin: 10px;">'.$this->data[0]['user']['description'] .'</span>';
                    $v .= '<div style="margin: 10px; text-align: center;">';
                        $v .= '<span class="dashicons dashicons-location-alt""></span>&nbsp;<span style="margin-right: 10px;">'.$this->data[0]['user']['location'].'</span>';
                        $date = explode(' ', $this->data[0]['user']['created_at']);
                        $v .= '<span class="dashicons dashicons-calendar-alt"></span>&nbsp;<span>'.$date[1].' '.$date[5].'</span>';
                    $v .= '</div>';
                $v .= '</div>';
            $v .= '</div>';

            if ($this->tweets) {
                $v .= '<div style="margin: 10px; border-top: 1px solid #ccc; padding-top: 10px;">';
                    foreach ($this->data as $tweet) {
                        $v .= '<blockquote class="twitter-tweet">';
                            $v .= '<p lang="cy" dir="ltr">'.$tweet['text'].'</p>';
                            $v .= '&mdash; '.$tweet['user']['name'].' (@'.$tweet['user']['screen_name'].')';
                            $v .= '<a href="https://twitter.com/f13dev/status/'.$tweet['id'].'?ref_src=twsrc%5Etfw">April 5, 2021</a>';
                        $v .= '</blockquote>';
                    }
                $v .= '</div>';
            }
        $v .= '</div>';

        return $v;
    }
}