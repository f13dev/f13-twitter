<?php namespace F13\Twitter\Views;

class Tweet
{

    public function __construct( $params = array() )
    {
        foreach ($params as $key => $value) {
            $this->{$key} = $value;
        }
    }

    public function tweet()
    {
        $v = '<div style="margin: auto; max-width: 550px;">';
            if (array_key_exists('text', $this->data)) {
                $v .= '<blockquote class="twitter-tweet">';
                    $v .= '<p lang="cy" dir="ltr">'.$this->data['text'].'</p>';
                    $v .= '&mdash; '.$this->data['user']['name'].' (@'.$this->data['user']['screen_name'].')';
                    $v .= '<a href="https://twitter.com/f13dev/status/'.$this->data['id'].'?ref_src=twsrc%5Etfw">April 5, 2021</a>';
                $v .= '</blockquote>';
            } else {
                foreach ($this->data as $tweet) {
                    $v .= '<blockquote class="twitter-tweet">';
                        $v .= '<p lang="cy" dir="ltr">'.$tweet['text'].'</p>';
                        $v .= '&mdash; '.$tweet['user']['name'].' (@'.$tweet['user']['screen_name'].')';
                        $v .= '<a href="https://twitter.com/f13dev/status/'.$tweet['id'].'?ref_src=twsrc%5Etfw">April 5, 2021</a>';
                    $v .= '</blockquote>';
                }
            }
        $v .= '</div>';

        return $v;
    }
}