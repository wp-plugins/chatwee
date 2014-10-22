<?php

ob_start();

/*
Plugin Name: Chatwee
Description: Chatwee is fully customizable social chat & comment platform for website and blogs. With Chatwee you can engage your online community and provide real-time communication.
Author: pawelq
Version: 1.0.1
Author URI: http://chatwee.com
*/

add_action('admin_menu', 'chatwee_create_menu');   
add_action( 'admin_init', 'register_chatwee_settings' );
function chatwee_create_menu() 
{
	add_menu_page('Account Configuration', 'Chatwee', 'administrator', 'chatwee_panel', 'chatwee_panel',  plugins_url( '/ico_fb_small_16x16.png', __FILE__ ));
}

function register_chatwee_settings() {
	register_setting( 'chatwee-settings-group', 'is_home' ); 
	register_setting( 'chatwee-settings-group', 'is_search' );
	register_setting( 'chatwee-settings-group', 'is_archive' );
	register_setting( 'chatwee-settings-group', 'is_page' );
	register_setting( 'chatwee-settings-group', 'is_single' );
}

function chatwee_panel() 
{ 
	include ('chatwee.php');
}
	
function chatwee_embedchat()
{
	echo get_option('chatwee');	
}

 //get_option( 'chatwee-settings-group[is_single]') == "on" 
 //get_option( 'chatwee-settings-group[is_post]') == "on" 
 //get_option( 'chatwee-settings-group[is_archive]') == "on" 
 //get_option( 'chatwee-settings-group[is_search]') == "on")

 function check_site(){
	if(get_option( 'chatwee-settings-group[is_home]') == "on" && is_home()) {
        add_action( 'wp_footer', 'chatwee_embedchat' );
    }
	 if(get_option( 'chatwee-settings-group[is_page]') == "on" && is_page()) {
        add_action( 'wp_footer', 'chatwee_embedchat' );
    }
	 if(get_option( 'chatwee-settings-group[is_search]') == "on" && is_search()) {
        add_action( 'wp_footer', 'chatwee_embedchat' );
    }
	 if(get_option( 'chatwee-settings-group[is_single]') == "on" && is_single()) {
        add_action( 'wp_footer', 'chatwee_embedchat' );
    }
	 if(get_option( 'chatwee-settings-group[is_archive]') == "on" && is_archive()) {
        add_action( 'wp_footer', 'chatwee_embedchat' );
    }
}
add_action("wp_footer","check_site", 5);


?>