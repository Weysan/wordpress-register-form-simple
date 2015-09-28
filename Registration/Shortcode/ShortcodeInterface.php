<?php
namespace Registration\Shortcode;

/**
 *
 * @author Raphaël GONCALVES <contact@raphael-goncalves.fr>
 */
interface ShortcodeInterface 
{
    public function filter();
    
    public function getTag();
}
