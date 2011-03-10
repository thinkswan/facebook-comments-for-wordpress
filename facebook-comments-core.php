<?php
/**********************************
Common functions
**********************************/

// Update database with default options upon plugin activation
function fbComments_init() {
	global $fbComments_defaults, $fbc_options;
	
	add_option('fbComments', $fbComments_defaults); // on first install
	
	$oldver = get_option('fbComments_ver');
	if (empty($oldver) || $oldver != FBCOMMENTS_VER) {
		fbComments_doUpdate();
	}
	update_option('fbComments_ver', FBCOMMENTS_VER);
	
	
	// If the plugin has been activated before and we already have the integral settings, cache all Facebook comment counts
	if (!empty($fbc_options['appId']) &&
		!empty($fbc_options['appSecret'])) {
			update_option('fbComments_displayAppIdWarning', false);
			if ($fbc_options['enableCache'] == true) { fbComments_cacheAllCommentCounts(); }
	} else { update_option('fbComments_displayAppIdWarning', true); }
}

 /**
 * Load settings from database on update.
 *
 * 3.1 changed activation hook firing on update. see: http://bit.ly/wp3_1noupdate
 *
 * @since 3.0.2
 */
function fbComments_doUpdate() {
	global $fbComments_defaults, $fbc_options;
	
	if (($_options = get_option('fbComments')) != false) $fbc_options = $_options;
	add_option('fbComments', $fbComments_defaults); //copy defaults to db
	
	$save_appId = $fbc_options['appId'];			// save id, secret, xid in case upgrading 
	$save_appSecret = $fbc_options['appSecret'];
	$save_xid = $fbc_options['xid'];
	
	$_appId = get_option('fbComments_appId');
	$_appSecret = get_option('fbComments_appSecret');
	if (strlen($_appId) > 1) $fbc_options['appId'] = $_appId; 
	else 					 $fbc_options['appId'] = $save_appId;
	
	if (strlen($_appSecret) > 1) $fbc_options['appSecret'] = $_appSecret;
	else 						 $fbc_options['appSecret'] = $save_appSecret;
	
	$fbc_options['xid'] = get_option('fbComments_xid');	// see if upgrading from v < 3
	if (strlen($fbc_options['xid']) < 1) { $fbc_options['xid'] = $save_xid; }
	
	
	
	$fbc_options['language'] = get_option('fbComments_language');
	if (strlen($fbc_options['dashNumComments']) < 0) $fbc_options['dashNumComments'] = 10; // if not set
	if (strlen($fbc_options['commentVersion']) < 1) $fbc_options['commentVersion'] = 'v1';
	
	// handle upgrading from <=2.1.2
	if (get_option('fbComments_includeFbJs') == true) { $fbc_options['includeFbJs'] = true; }
	if (get_option('fbComments_includeFbJsOldWay') == true) { $fbc_options['includeFbJsOldWay'] = true; }
	if (get_option('fbComments_includeFbmlLangAttr') == true) { $fbc_options['includeFbmlLangAttr'] = true; }
	if (get_option('fbComments_includeOpenGraphLangAttr') == true) { $fbc_options['includeOpenGraphLangAttr'] = true; }
	if (get_option('fbComments_includeOpenGraphMeta') == true) { $fbc_options['includeOpenGraphMeta'] = true; }
	if (get_option('fbComments_includeFbComments') == true) { $fbc_options['includeFbComments'] = true; }
	if (get_option('fbComments_hideWpComments') == true) { $fbc_options['hideWpComments'] = true; } 
	if (get_option('fbComments_combineCommentCounts') == true) { $fbc_options['combineCommentCounts'] = true; }
	if (get_option('fbComments_notify') == true) { $fbc_options['notify'] = true; }
	if (get_option('fbComments_displayTitle') == true) { $fbc_options['displayTitle'] = true; }
	if (get_option('fbComments_publishToWall') == true) { $fbc_options['publishToWall'] = true; }
	if (get_option('fbComments_reverseOrder') == true) { $fbc_options['reverseOrder'] = true; }
	if (get_option('fbComments_hideFbLikeButton') == true) { $fbc_options['hideFbLikeButton'] = true; }
	if (get_option('fbComments_darkSite') == true) { $fbc_options['darkSite'] = true; }
	if (get_option('fbComments_noBox') == true) { $fbc_options['noBox'] = true; }
	if (strlen($_title = get_option('fbComments_title')) > 1) $fbc_options['title'] = $_title;
	if (strlen($_numPosts = get_option('fbComments_numPosts')) > 1) $fbc_options['numPosts'] = $_numPosts;
	if (strlen($_width = get_option('fbComments_width')) > 1) $fbc_options['width'] = $_width;
	if (strlen($_displayPagesOrPosts = get_option('fbComments_displayPagesOrPosts')) > 1) $fbc_options['displayPagesOrPosts'] = $_displayPagesOrPosts;
	if (strlen($_containerCss = get_option('fbComments_containerCss')) > 1) $fbc_options['containerCss'] = $_containerCss;
	if (strlen($_titleCss = get_option('fbComments_titleCss')) > 1) $fbc_options['titleCss'] = $_titleCss;
	
		
	update_option('fbComments', $fbc_options);
}

// Email the site owner the current XID upon plugin deactivation
function fbComments_deactivate() {
	global $fbc_options;
	
	$to = get_bloginfo('admin_email');
	$subject = "[Facebook Comments for WordPress] Your current XID";

	$message = "Thanks for trying out Facebook Comments for WordPress!\n\n" .
			   "We just thought you'd like to know that your current XID is: {$fbc_options['xid']}.\n\n" .
			   "This should be saved in your website's database, but in case it gets lost, you'll need this unique key to retrieve your comments should you ever choose to activate this plugin again.\n\n" .
			   "Have a great day!";

	// Wordwrap the message and strip slashes that may have wrapped quotes
	$message = stripslashes(wordwrap($message, 70));

	$headers = "From: Facebook Comments for WordPress <$to>\r\n" .
			   "Reply-To: $to\r\n" .
			   "X-Mailer: PHP" . phpversion();

	// Send the email notification
	fbComments_log("Sending XID via email to $to");
	if (wp_mail($to, $subject, $message, $headers)) {
		fbComments_log(sprintf('    Sent XID via email to %s', $to));
	} else {
		fbComments_log(sprintf('    FAILED to send XID via email to %s', $to));
	}
}

// Remove database entries upon the plugin being uninstalled
function fbComments_uninit() {
	delete_option('fbComments');
	delete_option('fbComments_ver');
}


// Generate a random alphanumeric string for the comments XID
function fbComments_getRandXid($length=15) {
	$chars = array_merge(range('A', 'Z'), range('a', 'z'), range(0, 9));
	$rand = '';

	for ($i = 0; $i < $length; $i++) {
		$rand .= $chars[mt_rand(0, count($chars)-1)];
	}

	return $rand;
}

// The application ID and application secret must be set before calling this function
function fbComments_getFbApi() {
	global $fbc_options;
	
	$fbApiCredentials = array(
		'appId'	 => $fbc_options['appId'],
		'secret' => $fbc_options['appSecret']
	);

	return new Facebook($fbApiCredentials);
}

// The application ID and application secret must be set before calling this function
function fbComments_storeAccessToken() {
	fbComments_log('In ' . __FUNCTION__ . '()');
	global $fbc_options;

	if (!$fbc_options['accessToken']) {
		$accessToken = substr(fbComments_getUrl("https://graph.facebook.com/oauth/access_token?type=client_cred&client_id={$fbc_options['appId']}&client_secret={$fbc_options['appSecret']}"), 13);
		fbComments_log("    got an access token of [$accessToken]");
		if ($accessToken != '') {
			fbComments_log("    Storing an access token of $accessToken");
			$fbc_options['accessToken'] = $accessToken;
			update_option('fbComments', $fbc_options);
		} else {
			fbComments_log('    FAILED to obtain an access token');
		}
	}
}

// sugar for calling wp_remote_get
function fbComments_getUrl($url) {

	$file_contents = wp_remote_get($url,
				  $args = array('method' 		=> 'GET',
								'timeout' 		=> '5',
								'redirection' 	=> '5',
								'user-agent' 	=> 'WordPress facebook comments plugin',
								'blocking'		=> true,
								'compress'		=> false,
								'decompress'	=> true,
								'sslverify'		=> false
						));
	// var_dump($file_contents['body']);
	$file_contents = $file_contents['body'];
	

	fbComments_log('In ' . __FUNCTION__ . "(url=$url)");

	if (!$file_contents) {
		fbComments_log('    FAILED to retrieve content via wp_remote_get');
	}

	return $file_contents;
}

// Log to the Apache error log (usually located in /var/log/apache2/error_log)
function fbComments_log($msg) {
	if (FBCOMMENTS_ERRORS) {
		error_log('fbComments: ' . $msg);
	}
}
?>