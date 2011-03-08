<?php
/**********************************
Common functions
**********************************/

// Update database with default options upon plugin activation
function fbComments_init() {
	global $fbComments_defaults, $options;
	
	add_option('fbComments', $fbComments_defaults); // on first install
	
	$oldver = get_option('fbComments_ver');
	if (empty($oldver) || $oldver != FBCOMMENTS_VER) {
		fbComments_doUpdate();
	}
	update_option('fbComments_ver', FBCOMMENTS_VER);
	
	
	// If the plugin has been activated before and we already have the integral settings, cache all Facebook comment counts
	if (!empty($options['appId']) &&
		!empty($options['appSecret'])) {
			update_option('fbComments_displayAppIdWarning', false);
			fbComments_cacheAllCommentCounts();
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
	global $fbComments_defaults, $options;
	
	if (($_options = get_option('fbComments')) != false) $options = $_options;
	add_option('fbComments', $fbComments_defaults); //copy defaults to db
	
	$save_appId = $options['appId'];			// save id, secret, xid in case upgrading 
	$save_appSecret = $options['appSecret'];
	$save_xid = $options['xid'];
	
	$_appId = get_option('fbComments_appId');
	$_appSecret = get_option('fbComments_appSecret');
	if (strlen($_appId) > 1) $options['appId'] = $_appId; 
	else 					 $options['appId'] = $save_appId;
	
	if (strlen($_appSecret) > 1) $options['appSecret'] = $_appSecret;
	else 						 $options['appSecret'] = $save_appSecret;
	
	$options['xid'] = get_option('fbComments_xid');	// see if upgrading from v < 3
	if (strlen($options['xid']) < 1) { $options['xid'] = $save_xid; }
	
	$options['includeFbJs'] = true;
	$options['includeFbJsOldWay'] = false;
	$options['includeFbmlLangAttr'] = true;
	$options['includeOpenGraphLangAttr'] = true;
	$options['includeOpenGraphMeta'] = true;
	$options['language'] = get_option('fbComments_language');
	$options['dashNumComments'] = 10;
	
	// handle upgrading from <=2.1.2
	if (get_option('fbComments_includeFbComments') == true) { $options['includeFbComments'] = true; }
	if (get_option('fbComments_hideWpComments') == true) { $options['hideWpComments'] = true; } 
	if (get_option('fbComments_combineCommentCounts') == true) { $options['combineCommentCounts'] = true; }
	if (get_option('fbComments_notify') == true) { $options['notify'] = true; }
	if (get_option('fbComments_displayTitle') == true) { $options['displayTitle'] = true; }
	if (get_option('fbComments_publishToWall') == true) { $options['publishToWall'] = true; }
	if (get_option('fbComments_reverseOrder') == true) { $options['reverseOrder'] = true; }
	if (get_option('fbComments_hideFbLikeButton') == true) { $options['hideFbLikeButton'] = true; }
	if (get_option('fbComments_darkSite') == true) { $options['darkSite'] = true; }
	if (get_option('fbComments_noBox') == true) { $options['noBox'] = true; }
	if (strlen($_title = get_option('fbComments_title')) > 1) $options['title'] = $_title;
	if (strlen($_numPosts = get_option('fbComments_numPosts')) > 1) $options['numPosts'] = $_numPosts;
	if (strlen($_width = get_option('fbComments_width')) > 1) $options['width'] = $_width;
	if (strlen($_displayPagesOrPosts = get_option('fbComments_displayPagesOrPosts')) > 1) $options['displayPagesOrPosts'] = $_displayPagesOrPosts;
	if (strlen($_containerCss = get_option('fbComments_containerCss')) > 1) $options['containerCss'] = $_containerCss;
	if (strlen($_titleCss = get_option('fbComments_titleCss')) > 1) $options['titleCss'] = $_titleCss;
	
		
	update_option('fbComments', $options);
}

// Email the site owner the current XID upon plugin deactivation
function fbComments_deactivate() {
	global $options;
	
	$to = get_bloginfo('admin_email');
	$subject = "[Facebook Comments for WordPress] Your current XID";

	$message = "Thanks for trying out Facebook Comments for WordPress!\n\n" .
			   "We just thought you'd like to know that your current XID is: {$options['xid']}.\n\n" .
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
	global $options;
	
	$fbApiCredentials = array(
		'appId'	 => $options['appId'],
		'secret' => $options['appSecret']
	);

	return new Facebook($fbApiCredentials);
}

// The application ID and application secret must be set before calling this function
function fbComments_storeAccessToken() {
	fbComments_log('In ' . __FUNCTION__ . '()');
	global $options;

	if (!$options['accessToken']) {
		$accessToken = substr(fbComments_getUrl("https://graph.facebook.com/oauth/access_token?type=client_cred&client_id={$options['appId']}&client_secret={$options['appSecret']}"), 13);
		fbComments_log("    got an access token of [$accessToken]");
		if ($accessToken != '') {
			fbComments_log("    Storing an access token of $accessToken");
			$options['accessToken'] = $accessToken;
			update_option('fbComments', $options);
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
	var_dump($file_contents['body']);
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