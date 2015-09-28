<?php

namespace Registration;

/**
 * Plugin initialisation
 *
 * @author Raphaël GONCALVES <contact@raphael-goncalves.fr>
 */
class Plugin 
{
    private $shortcodes;
    
    public function __construct() 
    {
        
        $this->shortcodes[] = new Shortcode\RegistrationForm;
        $this->shortcodes[] = new Shortcode\LoginForm;
        $this->shortcodes[] = new Shortcode\Logout;
        
        \add_action('init', array($this, 'initShortcodes'));
    }
    
    /**
     * Shortcodes registration
     */
    public function initShortcodes()
    {
        foreach($this->shortcodes as $shortcode){
            \add_shortcode( $shortcode->getTag(), array( $shortcode, 'filter' ) );
        }
    }
}
