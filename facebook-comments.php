<?php
	/*
	Plugin Name: Facebook Comments for WordPress
	Plugin URI: http://www.grahamswan.com/facebook-comments
	Description: Allows your visitors to comment on posts using their Facebook profile. Supports custom styles, notifications, combined comment counts, etc.
	Author: Graham Swan
	Version: 2.1.2
	Author URI: http://www.grahamswan.com/
	*/
	
	define('FBCOMMENTS_ERRORS', false); // Set to true while developing, false for a release
	define('FBCOMMENTS_VER', '2.1.2');
	define('FBCOMMENTS_REQUIRED_PHP_VER', '5.0.0');
	define('FBCOMMENTS_AUTHOR', 'Graham Swan');
	define('FBCOMMENTS_WEBPAGE', 'http://grahamswan.com/facebook-comments/');
	define('FBCOMMENTS_PATH', plugins_url('facebook-comments-for-wordpress/'));
	define('FBCOMMENTS_CSS_ADMIN', FBCOMMENTS_PATH . 'css/facebook-comments.css');
	define('FBCOMMENTS_CSS_HIDEWPCOMMENTS', FBCOMMENTS_PATH . 'css/facebook-comments-hidewpcomments.css');
	define('FBCOMMENTS_CSS_HIDEFBLINK', FBCOMMENTS_PATH . 'css/facebook-comments-hidefblink.css');
	define('FBCOMMENTS_CSS_HIDELIKE', FBCOMMENTS_PATH . 'css/facebook-comments-hidelike.css');
	define('FBCOMMENTS_CSS_DARKSITE', FBCOMMENTS_PATH . 'css/facebook-comments-darksite.css');
	define('FBCOMMENTS_CSS_HIDELIKEANDDARKSITE', FBCOMMENTS_PATH . 'css/facebook-comments-custom.css');
	
	if (FBCOMMENTS_ERRORS) {
		error_reporting(E_ALL); // Ensure all errors and warnings are verbose
	}
	
	// Include common functions
	require_once 'facebook-comments-functions.php';
	require_once 'scripts/facebook.php'; // Facebook API wrapper
	wp_enqueue_script('jquery');
	
	/**********************************
	 Globals
	 **********************************/
	
	global $fbComments_defaults, $fbComments_optionKeys, $fbComments_settings;
	
	$fbComments_optionKeys = array(
		'fbComments_appId',
		'fbComments_appSecret',
		'fbComments_accessToken',
		'fbComments_includeFbJs',
		'fbComments_includeFbJsOldWay',
		'fbComments_includeFbmlLangAttr',
		'fbComments_includeOpenGraphLangAttr',
		'fbComments_includeOpenGraphMeta',
		'fbComments_includeFbComments',
		'fbComments_hideWpComments',
		'fbComments_combineCommentCounts',
		'fbComments_notify',
		'fbComments_language',
		'fbComments_displayTitle',
		'fbComments_title',
		'fbComments_numPosts',
		'fbComments_width',
		'fbComments_displayLocation',
		'fbComments_displayPagesOrPosts',
		'fbComments_publishToWall',
		'fbComments_reverseOrder',
		'fbComments_hideFbLikeButton',
		'fbComments_containerCss',
		'fbComments_titleCss',
		'fbComments_darkSite',
		'fbComments_noBox',
		'fbComments_displayAppIdWarning'
	);
	
	$fbComments_defaults = array(
		'fbComments_appId'						=> '',
		'fbComments_appSecret'					=> '',
		'fbComments_accessToken'				=> null,
		'fbComments_xid'						=> fbComments_getRandXid(),
		'fbComments_includeFbJs'				=> true,
		'fbComments_includeFbJsOldWay'			=> false,
		'fbComments_includeFbmlLangAttr'		=> true,
		'fbComments_includeOpenGraphLangAttr'	=> true,
		'fbComments_includeOpenGraphMeta'		=> true,
		'fbComments_includeFbComments'			=> true,
		'fbComments_hideWpComments'				=> false,
		'fbComments_combineCommentCounts'		=> true,
		'fbComments_notify'						=> true,
		'fbComments_language'					=> 'en_US',
		'fbComments_displayTitle'				=> true,
		'fbComments_title'						=> 'Facebook comments:',
		'fbComments_numPosts'					=> 10,
		'fbComments_width'						=> 500,
		'fbComments_displayLocation'			=> 'before',
		'fbComments_displayPagesOrPosts'		=> 'posts',
		'fbComments_publishToWall'				=> true,
		'fbComments_reverseOrder'				=> false,
		'fbComments_hideFbLikeButton'			=> false,
		'fbComments_containerCss'				=> 'margin: 20px 0;',
		'fbComments_titleCss'					=> 'margin-bottom: 15px; font-size: 140%; font-weight: bold; border-bottom: 2px solid #000; padding-bottom: 5px;',
		'fbComments_darkSite'					=> '',
		'fbComments_noBox'						=> false,
		'fbComments_displayAppIdWarning'		=> true
	);
	
	$fbComments_settings = fbComments_getSettings();
		
	/**********************************
	 Activation hooks/actions
	 **********************************/
	
	register_activation_hook(__FILE__, 'fbComments_init');
	register_deactivation_hook(__FILE__, 'fbComments_deactivate');
	register_uninstall_hook(__FILE__, 'fbComments_uninit');
	
	// Display a message prompting the user to enter a Facebook application ID and secret upon plugin activation (if they aren't already set)
	if ($fbComments_settings['fbComments_displayAppIdWarning']) {
		if (empty($fbComments_settings['fbComments_appId']) ||
			empty($fbComments_settings['fbComments_appSecret'])) {
			function fbComments_appIdWarning() {
			    echo "\n<div class='error'><p><strong>" . __('The Facebook comments box will not be included in your posts until you set a valid application ID and application secret. Please <a href="' . admin_url('options-general.php?page=facebook-comments') . '">set your application ID and secret now</a> using the options page.') . "</strong></p></div>\n";
			}
			
			add_action('admin_notices', 'fbComments_appIdWarning');
		}
		
		// Set the fbComments_displayWarning option to false so the message is only displayed once
		update_option('fbComments_displayAppIdWarning', false);
	}
	
	// Enqueue correct stylesheet if user wants to hide the WordPress commenting form
	if ($fbComments_settings['fbComments_hideWpComments']) {
		function fbComments_enqueueHideWpCommentsCss() {
			wp_register_style('fbComments_hideWpComments', FBCOMMENTS_CSS_HIDEWPCOMMENTS, array(), FBCOMMENTS_VER);
            wp_enqueue_style('fbComments_hideWpComments');
		}
	
		add_action('init', 'fbComments_enqueueHideWpCommentsCss');
	}
	
	// Add appropriate language attributes (must use get_option() because $fbComments_settings[] isn't available at this point)
	if (($fbComments_settings['fbComments_includeFbmlLangAttr']) || ($fbComments_settings['fbComments_includeOpenGraphLangAttr'])) {
		function fbComments_includeLangAttrs($attributes='') {
			if (get_option('fbComments_includeFbmlLangAttr')) {
				$attributes .= ' xmlns:fb="http://www.facebook.com/2008/fbml"';
			}
			
			if (get_option('fbComments_includeOpenGraphLangAttr')) {
				$attributes .= ' xmlns:og="http://opengraphprotocol.org/schema/"';
			}
			
			return $attributes;
		}
	
		add_filter('language_attributes', 'fbComments_includeLangAttrs');
	}
	
	// Add OpenGraph meta information
	if ($fbComments_settings['fbComments_includeOpenGraphMeta']) {
		function fbComments_addOpenGraphMeta() {
			global $wp_query;
			
			$postId = $wp_query->post->ID;
		    $postTitle = single_post_title('', false);
		    $postUrl = get_permalink($postId);
		    $siteName = get_bloginfo('name');
		    $appId = get_option('fbComments_appId');
		    
			echo "<meta property='og:title' content='$postTitle' />
<meta property='og:site_name' content='$siteName' />
<meta property='og:url' content='$postUrl' />
<meta property='og:type' content='article' />
<meta property='fb:app_id' content='$appId' />\n";
		}
		
		add_action('wp_head', 'fbComments_addOpenGraphMeta');
	}
	
	/**********************************
	 Settings page
	 **********************************/
	
	function fbComments_includeAdminPage() {
		include('facebook-comments-admin.php');
	}
	
	function fbComments_adminPage() {
		add_options_page(__('Facebook Comments for WordPress Options'), __('Facebook Comments'), 'manage_options', 'facebook-comments', 'fbComments_includeAdminPage');
	}
	
	function fbComments_settingsLink($actionLinks, $file) {
 		if (($file == 'facebook-comments-for-wordpress/facebook-comments.php') && function_exists('admin_url')) {
			$settingsLink = '<a href="' . admin_url('options-general.php?page=facebook-comments') . '">' . __('Settings') . '</a>';
		
			// Add 'Settings' link to plugin's action links
			array_unshift($actionLinks, $settingsLink);
		}
		
		return $actionLinks;
	}
	
	add_action('admin_menu', 'fbComments_adminPage');
	add_filter('plugin_action_links', 'fbComments_settingsLink', 0, 2);
	
	/**********************************
	 Dashboard recent comments widget
	 **********************************/
	 /**
	 * Display recent comments from facebook in a widget.
	 *
	 * @since 2.1.2
	 */
	function fbcomments_dashboard_widget_function() {
		global $fbComments_settings;
		$atoken =  get_option('fbComments_accessToken');
		$format = 'json';
		$query ="https://api.facebook.com/method/fql.multiquery".
		"?queries={'comments':+".
		  "'SELECT+fromid,+text,+id,+time,+username,+xid,+object_id+".
		  "FROM+comment+WHERE+xid+"."IN+(SELECT+xid+FROM+comments_info+WHERE+app_id+%3D+128167390587180)".
		  "ORDER+BY+time+desc',".
		"'users':+'SELECT+id,+name,+url,+pic_square+FROM+profile+".
		  "WHERE+id+IN+(SELECT+fromid+FROM+%23comments)'}".
		'&access_token='.$atoken.'&format='.$format;'&access_token='.$atoken.'&format='.$format;
		$result = fbComments_getUrl($query);
		
		// so json_decode doesn't return floats
		$result = preg_replace('/"fromid":([0-9]*)/', '"fromid":"\1"', $result);
		$result = preg_replace('/"id":([0-9]+)/', '"id":"\1"', $result);
		
		$commentsJson = json_decode($result);
		$comments = $commentsJson;
		$ncomms = sizeof($comments[0]->fql_result_set);
	
		
		if ($ncomms == 0) { echo 'No Comments!'; }
		else {
			$ncomms  = $ncomms < 10 ? $ncomms : 10;
			
			$htmlout = 
				// using the old api to make calling from js easier
				// the new graph api method is much cleaner, but it causes problems in opera 
				// since it returns a value, which opera then prompts the user to open or save
				"<div id=\"fb-root\"></div>
				<script>
				  window.fbAsyncInit = function() {
					FB.init({appId: '{$fbComments_settings['fbComments_appId']}', status: true, cookie: true,
							 xfbml: true});
				  };
				  (function() {
					var e = document.createElement('script'); e.async = true;
					e.src = document.location.protocol +
					  '//connect.facebook.net/en_US/all.js';
					document.getElementById('fb-root').appendChild(e);
				  }());
				</script>"
				// should probably change this to class so that it validates
				.'<div id="the-comment-list" class="list:comment" style="margin-top: -1em">';
			
			$parity = '';
			$users = $comments[1]->fql_result_set;
			$comments = $comments[0]->fql_result_set;
			
			for ($i=0;$i<$ncomms;$i++) {						
				$index = array_search($comments[$i]->fromid,$users);
				
				// Comment username and Link
				$username = $comments[$i]->fromid;
				if ($username == '1309634065') {	// if anon user
					$username = '<span class="aname">'+ $comments[$i]->username +'</span>';
				} else {
					$username = '<a target="_blank" href="https://www.facebook.com/profile.php?id='
						. $username
						.'">'. $users[$index]->name .'</a>';
				}
				
				// make pretty
				$commenttext = $comments[$i]->text;
				$order   = array("\r\n", "\n", "\r");
				$replace = '<br />';

				// Processes \r\n's first so they aren't converted twice.
				$commenttext = str_replace($order, $replace, $commenttext);
				
				// post url, linking directly to post possible?
				$commenturl = '../?p='.substr($comments[$i]->xid,20);
				
				// make pretty alternations
				$parity = ($i&1) 
					? "comment byuser comment-author-admin odd alt thread-odd thread-alt depth-1 comment-item approved": 
					"comment byuser comment-author-admin even thread-even depth-1 comment-item approved";

				$imgurl = $users[$index]->pic_square;
				
				// what will be written to the dashboard widget
				$htmlout .=
				'<div class="'.$parity.'">'.
					'<img alt="" src="'.$imgurl.'" class="avatar avatar-50 photo" height="50" width="50"/>'.
					'<div class="dashboard-comment-wrap">'.
						'<h4 class="comment-meta"> From '.
							'<cite class="comment-author"><a href="https://www.facebook.com/profile.php?id=100001765242194">'.$username.'</a></cite> on '.
							'<a href="'.$commenturl.'&action=edit">'.$commenturl.'</a>
							<abbr style="font-size:.8em" title="'.date('r',$comments[$i]->time).'"> '.date('d M Y',$comments[$i]->time).'</abbr>
							<span class="approve">[Pending]</span>'.
						'</h4>
						<blockquote>
							<p>'.$commenttext.'</p>
						</blockquote>
						<p class="row-actions">
							<span class="trash wallkit_actionset">
							
							<a id="deletecomm'.$i.'" href="#" class="delete vim-d vim-destructive" title="Delete this comment">
								delete
							</a>
							
							</span>
							<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
							<script>'.
							"$('#deletecomm".$i."').click(function(data) {
								FB.api({
										method: 'comments.remove',"
										.'comment_id: "'.$comments[$i]->id.'", '
										.'xid: "'.$comments[$i]->xid.'", '
										.'access_token: "'.$atoken.'", '
									."},
									function(response) {
										if (!response || response.error_code) {
											alert('ERROR: Failed to delete comment.');
										} else {
											alert('Comment Deleted');
											window.location.reload();
										}
									});
							});
							</script>
						</p>
					</div>
				</div>";
			}
			$htmlout .= '</div>';
			print_r($htmlout);
		}
	} 

	// Create the function used in the action hook
	function fbcomments_add_dashboard_widgets() {
		wp_add_dashboard_widget('fbcomments_dashboard_widget', 'Recent Facebook comments', 'fbcomments_dashboard_widget_function');	
	} 
	// Hook into the 'wp_dashboard_setup' action to register our other functions
	add_action('wp_dashboard_setup', 'fbcomments_add_dashboard_widgets' );
		
		
	/**********************************
	 Program entry point
	 **********************************/
	
	// Ensure we're able to display the comment box
	if ($fbComments_settings['fbComments_includeFbComments']) {		
		add_filter('comments_array', 'facebook_comments');
	}
	
	// Combine the Facebook and WordPress comment counts if desired
	if ($fbComments_settings['fbComments_combineCommentCounts'] &&
		!empty($fbComments_settings['fbComments_appId']) &&
		!empty($fbComments_settings['fbComments_appSecret'])) {			
			add_filter('get_comments_number', 'fbComments_combineCommentCounts');
	}

?>
