<?php

	ob_start();

	/*
	Plugin Name: Chatwee
	Description: Chatwee is fully customizable social chat & comment platform for website and blogs. With Chatwee you can engage your online community and provide real-time communication.
	Author: pawelq
	Version: 1.5.0
	Author URI: http://chatwee.com
	*/


	register_activation_hook( __FILE__, 'set_up_options' );

	function set_up_options(){
		register_setting( 'chatwee-settings-group', 'is_home' ); 
		register_setting( 'chatwee-settings-group', 'is_search' );
		register_setting( 'chatwee-settings-group', 'is_archive' );
		register_setting( 'chatwee-settings-group', 'is_page' );
		register_setting( 'chatwee-settings-group', 'is_single' );
		register_setting( 'chatwee-settings-group', 'ssostatus' );
		register_setting( 'chatwee-settings-group', 'clientid' );
		register_setting( 'chatwee-settings-group', 'keyapi' );
		
		update_option('chatwee-settings-group[is_home]',"on");
		update_option('chatwee-settings-group[is_search]',"on");
		update_option('chatwee-settings-group[is_archive]',"on");
		update_option('chatwee-settings-group[is_single]',"on");
		update_option('chatwee-settings-group[is_page]',"on");
		update_option('chatwee-settings-group[ssostatus]',"on");
		update_option('chatwee',"");
		
		}

		add_action('admin_menu', 'chatwee_create_menu');   
	
	if (check_sso_enable())
		add_action('wp_login', 'remote_login',7,2);
	if (check_sso_enable())
		add_action('wp_logout', 'remote_logout',7);
	

	function chatwee_create_menu() 
	{
		add_menu_page('Account Configuration', 'Chatwee', 'administrator', 'chatwee_panel', 'chatwee_panel',  plugins_url( '/ico_fb_small_16x16.png', __FILE__ ));
	}
	
	function check_sso_enable()
	{
		$option = get_option('chatwee-settings-group[ssostatus]');
		$status = ($option == 'on') ? true : false;
		return $status;
	}
	
	function check_user_agent($type = NULL)
	{	
        $user_agent = strtolower ( $_SERVER['HTTP_USER_AGENT'] );
        if ( $type == 'bot' ) {
                if ( preg_match ( "/googlebot|adsbot|yahooseeker|yahoobot|msnbot|watchmouse|pingdom\.com|feedfetcher-google/", $user_agent ) ) {
                        return true;
                }
        } else if ( $type == 'browser' ) {
                if ( preg_match ( "/mozilla\/|opera\//", $user_agent ) ) {
                        return true;
                }
        } else if ( $type == 'mobile' ) {
            
                if ( preg_match ( "/phone|iphone|itouch|ipod|symbian|android|htc_|htc-|palmos|blackberry|opera mini|iemobile|windows ce|nokia|fennec|hiptop|kindle|mot |mot-|webos\/|samsung|sonyericsson|^sie-|nintendo/", $user_agent ) ) {
                        return true;
                } else if ( preg_match ( "/mobile|pda;|avantgo|eudoraweb|minimo|netfront|brew|teleca|lg;|lge |wap;| wap /", $user_agent ) ) {
                        return true;
                }
        }
        return false;
	}
	
	function get_the_user_ip()
	{
	
		if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
			//check ip from share internet
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
		//to check ip is pass from proxy
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		
		return $ip;
	}
	
	function get_avatar_url($user_id)
	{

		$img = get_avatar($user_id);
		preg_match("/src='(.*?)'/i", $img, $matches);
		$url = $matches[1];
		
		return $url;
	}

	function remote_logout() 
	{

		$chatId = get_option('chatwee-settings-group[clientid]');
		
		$clientKey = get_option('chatwee-settings-group[keyapi]');
		
		$sessionId = $_COOKIE['chch-SI'];
		
		$url = "http://chatwee-api.com/api/remotelogout?chatId=".$chatId."&clientKey=".$clientKey."&sessionId=".$sessionId;
		
		file_get_contents($url);

		$hostChunks = explode(".", $_SERVER["HTTP_HOST"]);

		$hostChunks = array_slice($hostChunks, -2);

		$domain = "." . implode(".", $hostChunks);

		setcookie("chch-SI", "", time() - 1, "/", $domain);
	}

	function remote_login($user_login, $user)
	{
		
		$chatId = get_option('chatwee-settings-group[clientid]');
		
		$clientKey = get_option('chatwee-settings-group[keyapi]');
		
		$isAdmin = (is_super_admin( $user->ID) ? 1 : 0);
		
		$ismobile = (check_user_agent('mobile')==true) ? 1 : 0;
		
		$ip = get_the_user_ip();
		
		$avatar = get_avatar_url($user->ID);
		
		$previousSessionId = isSet($_COOKIE["chch-PSI"]) ? $_COOKIE["chch-PSI"] : null;

		$url = "http://chatwee-api.com/api/remotelogin?chatId=".$chatId."&clientKey=".$clientKey."&login=".$user_login."&isAdmin=".$isAdmin."&ipAddress=".$ip."&avatar=".$avatar."&isMobile=".$ismobile."&previousSessionId=".$previousSessionId;
		
		$url = str_replace(' ', '%20', $url);	
		
		$response = file_get_contents($url);
		
		$sessionArray = json_decode($response);
		
		$sessionId = $sessionArray->sessionId;
		
		$hostChunks = explode(".", $_SERVER["HTTP_HOST"]);

		$hostChunks = array_slice($hostChunks, -2);

		$domain = "." . implode(".", $hostChunks);

		setcookie("chch-SI", $sessionId, time() + 2592000, "/", $domain);
	}


	function chatwee_panel() 
	{ 
		include ('chatwee.php');
	}
		
	function chatwee_embedchat()
	{
		echo get_option('chatwee');	
	}

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