<?php
namespace Registration\Shortcode;

use Registration\Shortcode\ShortcodeInterface;
/**
 * Logout shortcode
 *
 * @author Raphaël GONCALVES <contact@raphael-goncalves.fr>
 */
class Logout implements ShortcodeInterface
{
    private $tag = 'logout';
    
    public function getTag() 
    {
        return $this->tag;
    }
    
    public function filter() 
    {
        wp_logout();
        
        wp_redirect(get_home_url(), 302);
        
        return;
    }
}
