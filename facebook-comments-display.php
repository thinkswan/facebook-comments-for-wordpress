<?php
	/**********************************
	 Facebook comments box inclusion
	 **********************************/
	
	// Insert Facebook comments manually or into the comments array
	function facebook_comments($comments='') {
		global $fbComments_settings, $wp_query;
		
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

		$postId = $wp_query->post->ID;
	    $xid = $fbComments_settings['fbComments_xid'] . "_post$postId";
	    $postTitle = get_the_title($postId);
	    $postUrl = get_permalink($postId);
	    
	    // Decide which stylesheet to use
	    $customStylesheet = fbComments_getStylesheet();
		
		// Only insert the Facebook comments if both an application ID and an application secret has been set
		if (!empty($fbComments_settings['fbComments_appId']) && !empty($fbComments_settings['fbComments_appSecret'])) {
			// Store our access token if it hasn't already been saved
			fbComments_storeAccessToken();
			
			echo "\n<!-- Facebook Comments for WordPress v" . FBCOMMENTS_VER . " by " . FBCOMMENTS_AUTHOR . " (" . FBCOMMENTS_WEBPAGE . ") -->\n
<a name='facebook-comments'></a>\n";

	    	if ($fbComments_settings['fbComments_includeFbJs']) {
	    		fbComments_includeFbJs();
			}

			// Print out the JavaScript that will catch new comments in order to update comment counts and send notifications
			fbComments_printCommentCatchAndNotificationScripts($xid, $postTitle, $postUrl);
        	
        	echo "\n<div id='fbComments' style='{$fbComments_settings['fbComments_containerCss']}'>\n";
        	
        	if ($fbComments_settings['fbComments_displayTitle']) {
        		echo "\t<p style='{$fbComments_settings['fbComments_titleCss']}'>" . __($fbComments_settings['fbComments_title']) . "</p>\n";
        	}

    		// Print out the JavaScript for calculating the width of the comments box
    		fbComments_printFbCommentsTag($xid, $postTitle, $postUrl, $customStylesheet);

			// Hide the WordPress commenting form if requested
			if ($fbComments_settings['fbComments_hideWpComments']) {
			    return array(); // Must return an empty array so foreach() loops in certain themes don't produce errors
			}
		} else { // If no application ID or application secret are set, display a message asking the user to set one (if they have permission to do so)			
			fbComments_handleNoAppId();
		}
		
		return $comments;
	}
	
	/**********************************
	 Facebook comments box helpers
	 **********************************/
	
	function fbComments_getStylesheet() {
		global $fbComments_settings;
		
		if (($fbComments_settings['fbComments_hideFbLikeButton']) && ($fbComments_settings['fbComments_darkSite'])) {
	    	return FBCOMMENTS_CSS_HIDELIKEANDDARKSITE . '?' . fbComments_getRandXid();
	    } elseif ($fbComments_settings['fbComments_hideFbLikeButton']) {
	    	return FBCOMMENTS_CSS_HIDELIKE . '?' . fbComments_getRandXid();
	    } elseif ($fbComments_settings['fbComments_darkSite']) {
	    	return FBCOMMENTS_CSS_DARKSITE . '?' . fbComments_getRandXid();
	    } else {
	    	return FBCOMMENTS_CSS_HIDEFBLINK . '?' . fbComments_getRandXid();
	    }
	}
	
	function fbComments_handleNoAppId() {
		global $fbComments_settings;
		
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
	
	function fbComments_includeFbJs() {
		global $fbComments_settings;
	
		// Decide whether or not to include the Facebook JavaScript library the old way or the new way
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
	
	function fbComments_printCommentCatchAndNotificationScripts($xid, $postTitle, $postUrl) {
		global $fbComments_settings;
	
		echo "
<script type='text/javascript'>
	j = jQuery.noConflict();
	
	var addedComment = function(response) {
		//console.log('fbComments: Caught added comment');
		//console.log('fbComments:     Making AJAX call to update Facebook comment count');
		j.post('" . FBCOMMENTS_PATH . "facebook-comments-ajax.php', { fn: 'addComment', xid: '$xid' }, function(resp) {
			if (resp === 'true') {
				//console.log('fbComments:     Updated and cached Facebook comment count for post with xid=$xid');
			} else {
				//console.log('fbComments:     FAILED to update Facebook comment count for post with xid=$xid');
			}
		});\n";
		
		if ($fbComments_settings['fbComments_notify']) {
			echo "
		//console.log('fbComments:     Making AJAX call to send email notification');
		j.post('" . FBCOMMENTS_PATH . "facebook-comments-ajax.php', { fn: 'sendNotification', xid: '$xid', postTitle: '$postTitle', postUrl: '$postUrl' }, function(resp) {
			if (resp === 'true') {
				//console.log('fbComments:     Sent email notification');
			} else {
				//console.log('fbComments:     FAILED to send email notification');
			}
		});";
		}
		
		echo "
	};

	FB.Event.subscribe('comments.add', addedComment);
</script>\n";
	}
	
	function fbComments_printFbCommentsTag($xid, $postTitle, $postUrl, $customStylesheet) {
		global $fbComments_settings;
		
		// Since the 'publish_feed' option defaults to true, we need to pass it an explicit false if it's turned off
		$publishToWall = ($fbComments_settings['fbComments_publishToWall']) ? 'true' : 'false';
		
		echo "\t<fb:comments xid='$xid' numposts='{$fbComments_settings['fbComments_numPosts']}' width='{$fbComments_settings['fbComments_width']}' simple='{$fbComments_settings['fbComments_noBox']}' publish_feed='$publishToWall' reverse='{$fbComments_settings['fbComments_reverseOrder']}' css='$customStylesheet' title='$postTitle' url='$postUrl' notify='true'></fb:comments>
</div>\n";
	}