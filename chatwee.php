<?php
if(isset($_POST['chatweesubmit'])){
	
	update_option('chatwee',stripslashes($_POST['chatweesnippet']));
	$chatwee_settings_page_group = $_POST['chatwee-settings-group'];

	update_option('chatwee-settings-group[is_home]',$chatwee_settings_page_group['is_home']);
	update_option('chatwee-settings-group[is_archive]',$chatwee_settings_page_group['is_archive']);
	update_option('chatwee-settings-group[is_search]',$chatwee_settings_page_group['is_search']);
	update_option('chatwee-settings-group[is_page]',$chatwee_settings_page_group['is_page']);
	update_option('chatwee-settings-group[is_single]',$chatwee_settings_page_group['is_single']);
	update_option('chatwee-settings-group[ssostatus]',$chatwee_settings_page_group['ssostatus']);
	update_option('chatwee-settings-group[keyapi]',$chatwee_settings_page_group['keyapi']);
	update_option('chatwee-settings-group[clientid]',$chatwee_settings_page_group['clientid']);
	}
	

?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Chatwee Live Chat for Wordpress</title>
	
	<style>
		body{ margin:0; font:normal 12px  "Open Sans", Arial, Helvetica, sans-serif;}
		
		.main-wrapper{ width:100%;}
		.cwp-title { font:500 29px  "Open Sans", Arial, Helvetica, sans-serif;margin: 10px 0px; }
		.cwp-subtitle { font:normal 13px  "Open Sans", Arial, Helvetica, sans-serif; margin: 0px; }
		.cwp-small-title { font:500 19px  "Open Sans", Arial, Helvetica, sans-serif;margin: 7px 0px; }
		.cwp-note { padding: 20px 0px; margin: 40px 0px; color: #4bbaf7; border-left: 2px solid #4bbaf7; font: normal 11px  "Open Sans", Arial, Helvetica, sans-serif; background: white; width: 100%; text-indent: 20px; }
		.cwp-snippet-wrapper { width:840px;display:inline-block;margin-top:30px;}
			.cwp-instruction-bubble { background: white; padding: 20px; border-radius: 22px; position: relative; float:left; width: 370px; }		
			.cwp-instruction-bubble:after { content: '';position: absolute;border-style: solid;border-width: 9px 0 9px 31px;border-color: transparent #FFFFFF;display: block;width: 0;z-index: 1;right: -31px;top: 21px;}
			.cwp-embed-wrapper {float:right}
				.cwp-embed-wrapper textarea {width:380px; height:120px; border: 2px dashed #ddd; word-wrap:break-word; padding:5px; font-size:12px;resize:none;background:transparent;}
					.cwp-embed-wrapper textarea:focus {background: white;}
		.cwp-info li{ list-style-type:circle; margin-left:30px; line-height:20px; color:#000; }
		.cwp-info li span{color:#555; font-weight:bold;}
		.cwp-btn-wrapper{ margin-top:30px;}
		.cwp-btn {background-color: #21759B;
			background-image: linear-gradient(to bottom, #2A95C5, #21759B);
			border-color: #21759B #21759B #1E6A8D;
			box-shadow: 0 1px 0 rgba(120, 200, 230, 0.5) inset;
			color: #FFFFFF;
			text-decoration: none;
			text-shadow: 0 1px 0 rgba(0, 0, 0, 0.1);
			border-radius:3px;
			border:1px solid;
			cursor: pointer;
			display: inline-block;
			font-size: 12px;
			height: 24px;
			line-height: 23px;
			margin:0;
			padding:0 10px 1px;
			white-space:nowrap;
			border-color:#21759B #21759B #1E6A8D;}
			
		.cwp-btn:hover{ background-color:#278AB7;
			background-image: linear-gradient(to bottom, #2E9FD2, #21759B);
			border-color: #1B607F;
			box-shadow: 0 1px 0 rgba(120, 200, 230, 0.6) inset;
			color: #fff;
			text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.3);}

		.cwp-register-info { font:normal 15px  "Open Sans", Arial, Helvetica, sans-serif;margin-left:5px;vertical-align:-1px;}
	</style>
	<script>
	
	</script>
</head>

<body>
	<div class="main-wrapper">
		<img src="https://www.chatwee.com/public/images/media-kit/logo_fb_white_small.png" />
		<h1 class="cwp-title">Set up Chatwee Live Chat plugin</h1>
		<h2 class="cwp-subtitle">Congratulations on successfully installing the Chatwee WordPress plugin! Activate an account to start using Chatwee Live Chat.</h2>
			
		<form method="post" action="<?php echo $PHP_SELF;?>">				
			
		<div class="cwp-snippet-wrapper">		
			<div class="cwp-instruction-bubble">		
				Please paste your Chatwee code snippet here. You can get the free code by <a href="https://www.chatwee.com/social-chat-software/authorization/login" target="_blank">logging in to your Chatwee account</a>. If you don't have your own Chatwee account please <a target="_blank" href="https://www.chatwee.com/social-chat-software/register">Sign Up here</a>
			</div>	
			
			<div class="cwp-embed-wrapper">
				<textarea id="chatweesnippet" onclick="this.select()" name="chatweesnippet" ><?php  echo get_option('chatwee') ?></textarea>
			</div>
		</div>
		
	<?php 
	
	$checked1 = get_option( 'chatwee-settings-group[is_home]');
	$checked2 = get_option( 'chatwee-settings-group[is_search]');
	$checked3 = get_option( 'chatwee-settings-group[is_archive]');
	$checked4 = get_option( 'chatwee-settings-group[is_single]');
	$checked5 = get_option( 'chatwee-settings-group[is_page]');
	$checked6 = get_option( 'chatwee-settings-group[ssostatus]');

	?>
	    <div class="cwp-site-check"> 
		   Display chat on main page: <input type="checkbox" name="chatwee-settings-group[is_home]" <?php checked( $checked1, "on", "checked"); ?>/> <br/>
		   Display chat on search page: <input type="checkbox" name="chatwee-settings-group[is_search]" <?php checked( $checked2, "on", "checked"); ?>/><br/>
		   Display chat on archive page: <input type="checkbox" name="chatwee-settings-group[is_archive]" <?php checked( $checked3, "on", "checked"); ?>/> <br/>
		   Display chat on post page: <input type="checkbox" name="chatwee-settings-group[is_single]" <?php checked( $checked4,"on", "checked"); ?>/> <br/>
		   Display chat on single page: <input type="checkbox" name="chatwee-settings-group[is_page]" <?php checked( $checked5,"on", "checked"); ?>/> 
	    </div><br/>
		<div class="cwp-sso-login">
			Enable SSO login <input type="checkbox" name="chatwee-settings-group[ssostatus]"  <?php checked( $checked6,"on", "checked");?> /> <br/>
			ClientID <input type="text" name="chatwee-settings-group[clientid]" value="<?php echo get_option('chatwee-settings-group[clientid]'); ?>"/> <br/>
			Key Chatwee API <input type="text" name="chatwee-settings-group[keyapi]" value="<?php echo get_option('chatwee-settings-group[keyapi]'); ?>"/> <br/>
		</div>
			<div class="cwp-info">
				<h3 class="cwp-small-title">How to get Chatwee code snippet?</h3>				
				<ul>
					<li><a href="https://www.chatwee.com/social-chat-software/authorization/login" target="_blank">Sign in</a> to your Chatwee control panel.</li>
					<li>Copy the code snippet that appears on the script page.</li>
					<li>Paste it above, and click 'Save Changes' button.</li>
					<li>Visit <a target="_blank" href="https://www.chatwee.com/social-chat-software/support">here</a> for more installation instructions.</li>
				</ul>
			</div>
			<div class="cwp-btn-wrapper">
				<input type="submit" name="chatweesubmit" class="cwp-btn" value="Save Changes" /><span class="cwp-register-info">Don't have a Chatwee account? <a target="_blank" href="https://www.chatwee.com/social-chat-software/register">Sign up now free.</a></span>
			</div>
		</form>
	</div>

</body>

</html>



