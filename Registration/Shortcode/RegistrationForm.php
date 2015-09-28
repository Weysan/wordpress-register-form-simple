<?php

namespace Registration\Shortcode;

use Registration\Shortcode\ShortcodeInterface;
use Registration\Form\Registration;

/**
 * Registration form Shortcode
 *
 * @author Raphaël
 */
class RegistrationForm implements ShortcodeInterface
{
    
    private $tag = 'registration_form';
    
    public function getTag() 
    {
        return $this->tag;
    }
    
    public function filter() 
    {
        $html = '';
        
        $form = new Registration($_POST);
        
        if($form->isPost() && $form->isValid()){
            $return = $this->registerUser($form->getCleanData());
            if(is_int($return))
                $this->loginAfterRegistration($return);
        }
        
        $html .= $form->getForm($return);
        
        return $html;
    }
    
    /**
     * Register an user
     * 
     * @param array $userdata
     * @return interger|string
     */
    private function registerUser(array $userdata)
    {
        $user_id = wp_insert_user( $userdata );

        //On success
        if ( ! is_wp_error( $user_id ) ) {
            return (int)$user_id;
        } else {
            return $user_id->get_error_message();
        }
    }
    
    /**
     * Login the user
     * 
     * @param integer $idUser
     */
    private function loginAfterRegistration($idUser)
    {
        $user = \get_user_by( 'id', $idUser ); 
        if($user){
            \wp_set_current_user( $idUser, $user->user_login );
            \wp_set_auth_cookie( $idUser );
            \do_action( 'wp_login', $user->user_login );

            \header('Location:'.get_home_url());
        }
    }
}
