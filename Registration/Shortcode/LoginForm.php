<?php

namespace Registration\Shortcode;

use Registration\Shortcode\ShortcodeInterface;

/**
 * Login form
 *
 * @author Raphaël GONCALVES <contact@raphael-goncalves.fr>
 */
class LoginForm implements ShortcodeInterface
{
    private $tag = 'login_form';
    
    public function getTag() 
    {
        return $this->tag;
    }
    
    public function filter() 
    {
        if(!is_user_logged_in()){
            $args = array('echo' => false);
        
            return wp_login_form($args);
        } else {
            $user = wp_get_current_user();
            return sprintf(__('Hello %s'), $user->user_login);
        }
        
    }
}
