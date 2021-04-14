<?php namespace F13\Twitter\Views;

class Admin
{

    public function __construct( $params = array() )
    {
        foreach ($params as $key => $value) {
            $this->{$key} = $value;
        }
    }

    public function f13_settings()
    {
        $v = '<div class="wrap">';
            $v .= '<h1>'.$this->label_plugins_by_f13.'</h1>';
            $v .= '<div id="f13-plugins">'.file_get_contents('https://f13dev.com/f13-plugins/').'</div>';
            //$v .= '<div id="f13-plugins">'.file_get_contents('https://f13.dev/wp-admin/admin-ajax.php?action=f13_plugins').'</div>';
            $v .= '<a href="'.admin_url('plugin-install.php').'?s=f13dev&tab=search&type=author">'.$this->label_all_wordpress_plugins.'</a>';
        $v .= '</div>';

        return $v;
    }

    public function twitter_settings()
    {
        $v = '<div class="wrap">';
            $v .= '<h1>F13 Twitter Settings</h1>';

        $v .= '<form method="post" action="options.php">';
            $v .= '<input type="hidden" name="option_page" value="'.esc_attr('f13-twitter-group').'" />';
            $v .= '<input type="hidden" name="action" value="update">';
            $v .= '<input type="hidden" id="_wpnonce" name="_wpnonce" value="'.wp_create_nonce('f13-twitter-group-options').'">';
            do_settings_sections( 'f13-twitter-group' );

            $v .= '<table class="form-table">';
                $v .= '<tr valign="top">';
                    $v .= '<th scope="row">Access Token:</th>';
                    $v .= '<td>';
                        $v .= '<input type="text" name="f13_twitter_access_token" value="'.esc_attr( get_option( 'f13_twitter_access_token' ) ).'" style="width: 50%;"/>';
                    $v .= '</td>';
                $v .= '</tr>';
                $v .= '<tr valign="top">';
                    $v .= '<th scope="row">Access Token secret:</th>';
                    $v .= '<td>';
                        $v .= '<input type="password" name="f13_twitter_access_token_secret" value="'.esc_attr( get_option( 'f13_twitter_access_token_secret' ) ).'" style="width: 50%;"/>';
                    $v .= '</td>';
                $v .= '</tr>';
                $v .= '<tr valign="top">';
                    $v .= '<th scope="row">API Key:</th>';
                    $v .= '<td>';
                        $v .= '<input type="text" name="f13_twitter_access_api_key" value="'.esc_attr( get_option( 'f13_twitter_access_api_key' ) ).'" style="width: 50%;"/>';
                    $v .= '</td>';
                $v .= '</tr>';
                $v .= '<tr valign="top">';
                    $v .= '<th scope="row">API Key secret:</th>';
                    $v .= '<td>';
                        $v .= '<input type="password" name="f13_twitter_access_api_key_secret" value="'.esc_attr( get_option( 'f13_twitter_access_api_key_secret' ) ).'" style="width: 50%;"/>';
                    $v .= '</td>';
                $v .= '</tr>';
                $v .= '<tr valign="top">';
                    $v .= '<th scope="row">Cache timeout:</th>';
                    $v .= '<td>';
                        $v .= '<input type="number" name="f13_twitter_cache_timeout" value="'.esc_attr( get_option( 'f13_twitter_cache_timeout' ) ).'" style="width: 75px;"/>';
                    $v .= '</td>';
                $v .= '</tr>';
                $v .= '<tr valign="top">';
                    $v .= '<th scope="row">User:</th>';
                    $v .= '<td>';
                        $v .= '<input type="text" name="f13_twitter_widget_user" value="'.esc_attr( get_option( 'f13_twitter_widget_user' ) ).'" style="width: 50%;"/>';
                    $v .= '</td>';
                $v .= '</tr>';
                $v .= '<tr valign="top">';
                    $v .= '<th scope="row">Tweets:</th>';
                    $v .= '<td>';
                        $v .= '<input type="number" name="f13_twitter_widget_tweets" value="'.esc_attr( get_option( 'f13_twitter_widget_tweets' ) ).'" style="width: 75px;"/>';
                    $v .= '</td>';
                $v .= '</tr>';
                $v .= '<tr valign="top">';
                    $v .= '<th scope="row">Show bio:</th>';
                    $v .= '<td>';
                        $v .= '<input type="checkbox" name="f13_twitter_widget_bio" value="1" '.(( get_option( 'f13_twitter_widget_bio' )) ? 'checked="checked"' : '' ).'/>';
                    $v .= '</td>';
                $v .= '</tr>';
                $v .= '<tr valign="top">';
                    $v .= '<th scope="row">Show stats:</th>';
                    $v .= '<td>';
                        $v .= '<input type="checkbox" name="f13_twitter_widget_stats" value="1" '.(( get_option( 'f13_twitter_widget_stats' )) ? 'checked="checked"' : '' ).'/>';
                    $v .= '</td>';
                $v .= '</tr>';
                $v .= '<tr valign="top">';
                    $v .= '<th scope="row">Show follow button:</th>';
                    $v .= '<td>';
                        $v .= '<input type="checkbox" name="f13_twitter_widget_follow_button" value="1" '.(( get_option( 'f13_twitter_widget_follow_button' )) ? 'checked="checked"' : '' ).'/>';
                    $v .= '</td>';
                $v .= '</tr>';
            $v .= '</table>';
            $v .= '<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"></p>';
        $v .= '</form>';


        return $v;
    }

    public function widget_settings()
    {

    }
}