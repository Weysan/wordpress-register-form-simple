<?php

namespace Registration\Form;

/**
 * Registration Form display and data update
 *
 * @author Raphaël GONCALVES <contact@raphael-goncalves.fr>
 */
class Registration 
{
    
    protected $post_data;
    
    public function __construct(array $post_data = null) 
    {
        $this->post_data = $post_data;
    }
    
    /**
     * Get HTML form to user registration
     * 
     * @return string
     */
    public function getForm($msg = null)
    {
        $user = wp_get_current_user();
        if($user->ID !== 0){
            \wp_redirect (get_home_url());
            return;
        }
        
        $html = '';
        
        if(isset($msg))
            $html .= '<p class="error-msg">'.$msg.'</p>';
        
        $html .= '<form method="post" action="#_">' . "\r\n";
        
        $html.= '<p><label>'. __('Prénom') .'</label><input type="text" name="first_name" required="required" value="" /></p>' . "\r\n";
        
        $html.= '<p><label>'. __('Nom') .'</label><input type="text" name="last_name" required="required" value="" /></p>' . "\r\n";
        
        $html.= '<p><label>'. __('Username') .'</label><input type="text" name="username" required="required" value="" /></p>' . "\r\n";
        
        $html.= '<p><label>'. __('Email') .'</label><input type="email" name="email" required="required" value="" /></p>' . "\r\n";
        
        $html.= '<p><label>'. __('Mot de passe') .'</label><input type="password" id="form_register_password_1" name="password" required="required" value="" /></p>' . "\r\n";
        
        $html.= '<p><label>'. __('Vérification mot de passe') .'</label><input type="password" name="validation_password" required="required" value="" /></p>' . "\r\n";
        
        $html.= '<input type="hidden" name="__wp_nonce" required="required" value="'.  wp_create_nonce('wp_register_plugin_nonce') . '" /></p>' . "\r\n";
        
        $html.= '<p><input type="submit" name="submit_plugin_register" value="'. __("S'inscrire") .'" /></p>' . "\r\n";
        
        $html.= '</form>' . "\r\n";
        
        return $html;
    }
    
    /**
     * Check if the form has been submitted
     * 
     * @return boolean
     */
    public function isPost()
    {
        return isset($_POST['submit_plugin_register']);
    }
    
    /**
     * Check the data validation
     * 
     * @return boolean
     */
    public function isValid()
    {
        
        $required_fields = array(
            'first_name',
            'last_name',
            'username',
            'email',
            'password',
            'validation_password'
        );
        
        //check wp_nonce
        $nonce = $this->post_data['__wp_nonce'];
        if(!wp_verify_nonce( $nonce, 'wp_register_plugin_nonce' ))
                return false;
        
        //check required fields
        foreach($required_fields as $post_key){
            if(!isset($this->post_data[$post_key]) || empty($this->post_data[$post_key]))
                return false;
        }
        
        //password check
        if($this->post_data['password'] !== $this->post_data['validation_password'])
            return false;
        
        if(!filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL))
                return false;
        
        return true;
    }
    
    /**
     * Get clean Form Data
     * 
     * @return array
     */
    public function getCleanData()
    {
        $clean = array();
        
        $clean['first_name'] = filter_input(INPUT_POST, 'first_name');
        $clean['last_name'] = filter_input(INPUT_POST, 'last_name');
        $clean['user_login'] = filter_input(INPUT_POST, 'username');
        $clean['user_email'] = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $clean['user_pass'] = filter_input(INPUT_POST, 'password');
        
        return $clean;
    }
}
