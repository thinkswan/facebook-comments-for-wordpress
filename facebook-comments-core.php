<?php
/**********************************
Common functions
**********************************/

// Update database with default options upon plugin activation
function fbComments_init() {
	global $fbComments_defaults, $options;
	// delete_option('fbComments');
	add_option('fbComments', $fbComments_defaults);
	
	// If the plugin has been activated before and we already have the integral settings, cache all Facebook comment counts
	if (!empty($options['appId']) &&
		!empty($options['appSecret'])) {
			update_option('fbComments_displayAppIdWarning', false);
			fbComments_cacheAllCommentCounts();
	} else { update_option('fbComments_displayAppIdWarning', true); }
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