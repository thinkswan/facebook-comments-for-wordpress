<?php
	if (FBCOMMENTS_ERRORS) {
		error_reporting(E_ALL); // Ensure all errors and warnings are verbose
	}
	
	/**********************************
	 Common functions
	 **********************************/
	
	// Update database with default options upon plugin activation
	function fbComments_init() {
		global $fbComments_defaults, $fbComments_settings;
		
		foreach($fbComments_defaults as $key => $val) {
			// Only insert default value if option is not already in the database
			add_option($key, $val);
		}
		
		// If the plugin has been activated before and we already have the integral settings, cache all Facebook comment counds
		if (!empty($fbComments_settings['fbComments_appId']) &&
			!empty($fbComments_settings['fbComments_appSecret'])) {
				fbComments_cacheAllCommentCounts();
		}
	}
	
	// Remove database entries upon plugin deactivation
	function fbComments_uninit() {
		global $fbComments_optionKeys;
		
		foreach($fbComments_optionKeys as $key) {
			delete_option($key);
		}
	}
	
	// Retrieve array of plugin settings
	function fbComments_getSettings() {
		$settings = array();
		
		global $fbComments_optionKeys;
			
		foreach($fbComments_optionKeys as $key) {
			$settings[$key] = get_option($key);
		}
		
		// Retrieve the XID (since it's not in the options array)
		$settings['fbComments_xid'] = get_option('fbComments_xid');
		
		return $settings;
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
	
	// Log to the Apache error log (usually located in /var/log/apache2/error_log)
	function fbComments_log($msg) {
		if (FBCOMMENTS_ERRORS) {
			error_log('fbComments: ' . $msg);
		}
	}
	
	/**********************************
	 Combined comment counts (and caching)
	 **********************************/
	
	// The application ID and application secret must be set before calling this function
	function fbComments_getFbApi() {
		global $fbComments_settings;
		
		$fbApiCredentials = array(
		    'appId'	 => $fbComments_settings['fbComments_appId'],
		    'secret' => $fbComments_settings['fbComments_appSecret']
		);
		
		return new Facebook($fbApiCredentials);
	}
	
	// The application ID and application secret must be set before calling this function
	function fbComments_storeAccessToken() {
		fbComments_log('In ' . __FUNCTION__ . '()');
		global $fbComments_settings;
		
		if (!get_option('fbComments_accessToken')) {
			$accessToken = substr(file_get_contents("https://graph.facebook.com/oauth/access_token?type=client_cred&client_id={$fbComments_settings['fbComments_appId']}&client_secret={$fbComments_settings['fbComments_appSecret']}"), 13);
			
			if ($accessToken != '') {
				fbComments_log("    Storing an access token of $accessToken");
				update_option('fbComments_accessToken', $accessToken);
			} else {
				fbComments_log('    FAILED to obtain an access token');
			}
		}
	}
		
	function fbComments_getCachedCommentCount($xid, $wpCommentCount) {
		fbComments_log('In ' . __FUNCTION__ . "(xid=$xid, wpCommentCount=$wpCommentCount)");
		global $fbComments_settings;
		
		$fbCommentCount = get_option("fbComments_commentCount_$xid");
		
		return fbComments_getProperCommentCount($fbCommentCount, $wpCommentCount);
	}
	
	function fbComments_getProperCommentCount($fbCommentCount=0, $wpCommentCount=0) {
		fbComments_log('In ' . __FUNCTION__ . "(fbCommentCount=$fbCommentCount, wpCommentCount=$wpCommentCount)");
		global $fbComments_settings;
		
		// If the WordPress comments are hidden, just return the Facebook comments count
		if ($fbComments_settings['fbComments_hideWpComments']) {
			fbComments_log("    Returning a Facebook comment count of $fbCommentCount");
		    return $fbCommentCount;
		} else {
			fbComments_log(sprintf('    Returning a combined comment count of %d', $fbCommentCount+$wpCommentCount));
		    return $fbCommentCount + $wpCommentCount;
		}
	}
	
	/*
	 * Loops through all posts and caches the Facebook comment count
	 *
	 * Thanks to Almog Baku for help with the Facebook API calls (http://www.almogbaku.com/)
	 */
	function fbComments_cacheAllCommentCounts() {
		fbComments_log('In ' . __FUNCTION__ . '()');
		global $fbComments_settings;
		
		$fb = fbComments_getFbApi();
		$posts = get_posts(array('numberposts' => -1)); // Retrieve all posts
		
		if ($posts) {
			fbComments_log(sprintf('    Looping through %d posts', count($posts)));
			foreach ($posts as $post) {
				$xid = $fbComments_settings['fbComments_xid'] . "_post{$post->ID}";
	    		$query = array(
					'method' => 'fql.query',
					'query'	 => 'SELECT count FROM comments_info WHERE app_id="' . $fb->getAppId() . '" AND xid="' . $xid . '"'
				);
				
				try {
					fbComments_log("    Retrieving Facebook comment count for post with xid=$xid");
					$result = $fb->api($query);
					
					if ($result) {
						update_option("fbComments_commentCount_$xid", $result[0]['count']);
					}
				} catch (FacebookApiException $e) {
					fbComments_log("    FAILED to retrieve Facebook comment count for post with xid=$xid");
				}
			}
		}
	}
	 
	
	function fbComments_combineCommentCounts($value) {
		fbComments_log('In ' . __FUNCTION__ . "(value=$value)");
		global $fbComments_settings, $wp_query;
		
		$postId = $wp_query->post->ID;
	    $xid = $fbComments_settings['fbComments_xid'] . "_post$postId";
		
		// Return the cached comment count (if it exists)
		if (get_option("fbComments_commentCount_$xid")) {
			return fbComments_getCachedCommentCount($xid, $value);
		}
			
		$fb = fbComments_getFbApi();
		
	    $query = array(
			'method' => 'fql.query',
			'query'	 => 'SELECT count FROM comments_info WHERE app_id="' . $fb->getAppId() . '" AND xid="' . $xid . '"'
		);

		try {
			fbComments_log("    Comment count wasn't cached. Retrieving Facebook comment count for post with xid=$xid");
			$result = $fb->api($query);
			
			if ($result) {
				// Cache the Facebook comment count
				update_option("fbComments_commentCount_$xid", $result[0]['count']);
				
				return fbComments_getProperCommentCount($result[0]['count'], $value);
			}
		} catch (FacebookApiException $e) {}
		
		fbComments_log("    FAILED to retrieve Facebook comment count for post with xid=$xid");
		return fbComments_getProperCommentCount(0, $value);
	}

	/**********************************
	 Facebook comments box inclusion
	 **********************************/
	
	// Insert Facebook comments manually or into the comments array
	function facebook_comments($comments='') {
		global $fbComments_settings, $wp_query;

		$postId = $wp_query->post->ID;
	    $xid = $fbComments_settings['fbComments_xid'] . "_post$postId";
	    $postTitle = get_the_title($postId);
	    $postUrl = get_permalink($postId);
	    
	    // Decide which stylesheet to use
	    if (($fbComments_settings['fbComments_hideFbLikeButton']) && ($fbComments_settings['fbComments_darkSite'])) {
	    	$customStylesheet = FBCOMMENTS_CSS_HIDELIKEANDDARKSITE . '?' . fbComments_getRandXid();
	    } elseif ($fbComments_settings['fbComments_hideFbLikeButton']) {
	    	$customStylesheet = FBCOMMENTS_CSS_HIDELIKE . '?' . fbComments_getRandXid();
	    } elseif ($fbComments_settings['fbComments_darkSite']) {
	    	$customStylesheet = FBCOMMENTS_CSS_DARKSITE . '?' . fbComments_getRandXid();
	    } else {
	    	$customStylesheet = FBCOMMENTS_CSS_HIDEFBLINK . '?' . fbComments_getRandXid();
	    }
	    
	    // Return out of function if commenting is closed for this post
	    if (!comments_open()) {
	    	return $comments;
	    }
	    
	    // Return out of function if we're only supposed to display comments on pages OR posts
	    if (($fbComments_settings['fbComments_displayPagesOrPosts'] == 'pages') && (!is_page())) {
	    	return $comments;
	    }
	    
	    if (($fbComments_settings['fbComments_displayPagesOrPosts'] == 'posts') && (!is_single())) {
	    	return $comments;
	    }
		
		// Only insert the Facebook comments if both an application ID and an application secret has been set
		if (!empty($fbComments_settings['fbComments_appId']) && !empty($fbComments_settings['fbComments_appSecret'])) {
			// Store our access token if it hasn't already been saved
			fbComments_storeAccessToken();
			
			echo "\n<!-- Facebook Comments for WordPress v" . FBCOMMENTS_VER . " by " . FBCOMMENTS_AUTHOR . " (" . FBCOMMENTS_WEBPAGE . ") -->\n
<a name='facebook-comments'></a>\n";

	    	if ($fbComments_settings['fbComments_includeFbJs']) {
	    		if ($fbComments_settings['fbComments_includeFbJsOldWay']) {
	    			echo "\n<div id='fb-root'></div>
<script type='text/javascript'>
    window.fbAsyncInit = function() {
    	FB.init({
    		appId: '{$fbComments_settings['fbComments_appId']}',
    		status: true,
    		cookie: true,
    		xfbml: true
    	});
    };
    
    (function() {
    	var e = document.createElement('script'); e.async = true;
    	e.src = document.location.protocol + '//connect.facebook.net/{$fbComments_settings['fbComments_language']}/all.js';
    	document.getElementById('fb-root').appendChild(e);
    }());
</script>\n";
	    		} else {
	    			echo "\n<div id='fb-root'></div>
<script src='http://connect.facebook.net/{$fbComments_settings['fbComments_language']}/all.js#appId={$fbComments_settings['fbComments_appId']}&amp;xfbml=1' type='text/javascript'></script>\n";
				}
			}

			echo "
<script type='text/javascript'>
	j = jQuery.noConflict();
	
	var addedComment = function(response) {
		console.log('fbComments: Caught added comment');
		console.log('fbComments:     Making AJAX call to update Facebook comment count');
		j.post('" . FBCOMMENTS_PATH . "facebook-comments-ajax.php', { fn: 'addComment', xid: '$xid' }, function(resp) {
			if (resp === 'true') {
				console.log('fbComments:     Updated and cached Facebook comment count for post with xid=$xid');
			} else {
				console.log('fbComments:     FAILED to update Facebook comment count for post with xid=$xid');
			}
		});\n";
		
			if ($fbComments_settings['fbComments_notify']) {
				echo "
		console.log('fbComments:     Making AJAX call to send email notification');
		j.post('" . FBCOMMENTS_PATH . "facebook-comments-ajax.php', { fn: 'sendNotification', xid: '$xid', postTitle: '$postTitle', postUrl: '$postUrl' }, function(resp) {
			if (resp === 'true') {
				console.log('fbComments:     Sent email notification');
			} else {
				console.log('fbComments:     FAILED to send email notification');
			}
		});";
			}
		
			echo "
	};

	FB.Event.subscribe('comments.add', addedComment);
</script>\n";
	    	
	    	echo "\n<div id='fbComments' style='{$fbComments_settings['fbComments_containerCss']}'>\n";
	    	
	    	if ($fbComments_settings['fbComments_displayTitle']) {
	    		echo "\t<p style='{$fbComments_settings['fbComments_titleCss']}'>" . __($fbComments_settings['fbComments_title']) . "</p>\n";
	    	}
			
			echo "\t<fb:comments xid='$xid' numposts='{$fbComments_settings['fbComments_numPosts']}' width='{$fbComments_settings['fbComments_width']}' simple='{$fbComments_settings['fbComments_noBox']}' publish_feed='true' reverse='{$fbComments_settings['fbComments_reverseOrder']}' css='$customStylesheet' title='$postTitle' url='$postUrl' notify='true'></fb:comments>
</div>\n";

			// Hide the WordPress commenting form if requested
			if ($fbComments_settings['fbComments_hideWpComments']) {
			    return array(); // Must return an empty array so foreach() loops in certain themes don't produce errors
			}
		} else { // If no application ID or application secret are set, display a message asking the user to set one (if they have permission to do so)			
			get_currentuserinfo(); // Get user info to see if the currently logged in user (if any) has the 'manage_options' capability
		    
		    if (current_user_can('manage_options')) {		
		    	$optionsPage = admin_url('options-general.php?page=facebook-comments');
		    	
		    	echo "\n<!-- Facebook Comments for WordPress v" . FBCOMMENTS_VER . " by " . FBCOMMENTS_AUTHOR . " (" . FBCOMMENTS_WEBPAGE . ") -->
		
<div style='{$fbComments_settings['fbComments_containerCss']}'>\n";

				if ($fbComments_settings['fbComments_displayTitle']) {
					echo "\t<p style='{$fbComments_settings['fbComments_titleCss']}'>" . __($fbComments_settings['fbComments_title']) . "</p>\n";
				}
				
				echo "\t<div style='background-color: #ffebe8; border: 1px solid #c00; padding: 7px; font-weight: bold; border-radius: 5px; -moz-border-radius: 5px; -webkit-border-radius: 5px; -khtml-border-radius: 5px;'>" . __("Your Facebook comments would normally appear here, but you haven't set a valid application ID or application secret yet. <a href='$optionsPage' style='color: #c00;'>Go set them now</a>.") . "</div>
</div>\n";
		    }
		}
		
		return $comments;
	}
?>
