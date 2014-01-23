<?php

ob_start();

/*
Plugin Name: Chatwee
Description: Chatwee is fully customizable social chat & comment platform for website and blogs. With Chatwee you can engage your online community and provide real-time communication.
Author: pawelq
Version: 1.0.0
Author URI: http://chatwee.com
*/

add_action('admin_menu', 'chatwee_create_menu');   

function chatwee_create_menu() 
{
	add_menu_page('Account Configuration', 'Chatwee', 'administrator', 'chatwee_panel', 'chatwee_panel',  plugins_url( '/ico_fb_small_16x16.png', __FILE__ ));
}

function chatwee_panel() 
{ 
	include ('chatwee.php');
}
	
function chatwee_embedchat()
{
	echo get_option('chatwee');	
}
 
add_action("wp_footer","chatwee_embedchat", 5);

?>