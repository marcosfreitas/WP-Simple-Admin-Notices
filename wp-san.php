<?php
/**
 * Plugin Name: WordPress Simple Admin Notice (WP SAN)
 * Description: This plugin implements a Class to trigger notices into Wordpress Admin more easily using a shortcode.
 * Plugin URI: https://github.com/marcosfreitas/WP-Simple-Admin-Notices
 * Author: Marcos Freitas
 * Author URI: http://fb.me/marcoosfreitas
 * Version: 0.3
 * Last Update: September 26, 2015 : 17:25hs
 * License: GPLv3 or later
 */

/**
 * How to use:
 * do_shortcode('[wpsan message="Oops, a error have ocurred." class="error"]');
 * You have to create an style in your css file with the custom class of message or the class you be .update-nag of wordpress, it's all!
 */
class WP_SAN {
    public $message = '';
    public $class = '';
    protected static $instance = NULL;

    public static function get_instance() {
        // create an object
        if ( is_null( self::$instance ) ) {
            self::$instance = new self;
        }
        return self::$instance; // return the object
    }
    /**
     * This function expects to receive in maximum two arguments: 'message' and 'class'
     * @args array
     */
    public function notice($args){
        $this->message = isset($args['message']) ? $args['message'] : '';
        $this->class = isset($args['class']) ? $args['class'] : 'update-nag';
        add_action( 'admin_notices', array( $this, 'output' ) );
        add_action( 'network_admin_notices', array( $this, 'output' ) );
    }
    public function output(){
        echo '<div class="' . $this->class .'"><p>' . $this->message . '</p></div>';
    }
}
add_shortcode( 'wpsan', array( WP_SAN::get_instance(), 'notice' ) );
