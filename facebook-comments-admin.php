<?php
	if (FBCOMMENTS_ERRORS) {
		error_reporting(E_ALL); // Ensure all errors and warnings are verbose
	}
	
	// If the user submitted the form, update the database with the new settings
	if (isset($_POST['fbComments_update']) && $_POST['fbComments_update'] == 'true') {
		global $fbComments_defaults;
		$errors = false;
	
		$fbComments_settings['fbComments_appId'] = (isset($_POST['fbComments_appId']) && trim($_POST['fbComments_appId']) != '') ? esc_html(stripslashes(trim($_POST['fbComments_appId']))) : null;
		$response = wp_remote_get("https://www.facebook.com/apps/application.php?".http_build_query(array('id'=>$fbComments_settings['fbComments_appId'])),
					$args = array('method' => 'GET', 
								'timeout' => '5',
								'redirection' => '5',
								'user-agent' => 'WordPress facebook comments plugin',
								'blocking' => true,
								'compress' => false,
								'decompress' => true,
								'sslverify' => false
						));
		$response = $response[body];
		$needle = 'wall';
		if ( strpos($response, $needle) == false ) {
			update_option('fbComments_appId', '0');
			$fbComments_settings['fbComments_appId'] = 'INVALID APP ID';
			$errors = 'ERROR! Invalid application ID. Please double check to make sure it is correct. Note that this is not the same thing as your Facebook user ID';
		} else {
			update_option('fbComments_appId', $fbComments_settings['fbComments_appId']);
		}
		
		$fbComments_settings['fbComments_appSecret'] = (isset($_POST['fbComments_appSecret']) && trim($_POST['fbComments_appSecret']) != '') ? esc_html(stripslashes(trim($_POST['fbComments_appSecret']))) : null;
		update_option('fbComments_appSecret', $fbComments_settings['fbComments_appSecret']);
		
		$fbComments_settings['fbComments_xid'] = (isset($_POST['fbComments_xid']) && trim($_POST['fbComments_xid']) != '') ? esc_html(stripslashes(trim($_POST['fbComments_xid']))) : get_option('fbComments_xid');
		update_option('fbComments_xid', $fbComments_settings['fbComments_xid']);
		
		$fbComments_settings['fbComments_includeFbJs'] = (isset($_POST['fbComments_includeFbJs']) && $_POST['fbComments_includeFbJs'] == 'true') ? true : false;
		update_option('fbComments_includeFbJs', $fbComments_settings['fbComments_includeFbJs']);
		
		$fbComments_settings['fbComments_includeFbJsOldWay'] = (isset($_POST['fbComments_includeFbJsOldWay']) && $_POST['fbComments_includeFbJsOldWay'] == 'true') ? true : false;
		update_option('fbComments_includeFbJsOldWay', $fbComments_settings['fbComments_includeFbJsOldWay']);
		
		$fbComments_settings['fbComments_includeFbmlLangAttr'] = (isset($_POST['fbComments_includeFbmlLangAttr']) && $_POST['fbComments_includeFbmlLangAttr'] == 'true') ? true : false;
		update_option('fbComments_includeFbmlLangAttr', $fbComments_settings['fbComments_includeFbmlLangAttr']);
		
		$fbComments_settings['fbComments_includeOpenGraphLangAttr'] = (isset($_POST['fbComments_includeOpenGraphLangAttr']) && $_POST['fbComments_includeOpenGraphLangAttr'] == 'true') ? true : false;
		update_option('fbComments_includeOpenGraphLangAttr', $fbComments_settings['fbComments_includeOpenGraphLangAttr']);
		
		$fbComments_settings['fbComments_includeOpenGraphMeta'] = (isset($_POST['fbComments_includeOpenGraphMeta']) && $_POST['fbComments_includeOpenGraphMeta'] == 'true') ? true : false;
		update_option('fbComments_includeOpenGraphMeta', $fbComments_settings['fbComments_includeOpenGraphMeta']);
		
		$fbComments_settings['fbComments_includeFbComments'] = (isset($_POST['fbComments_includeFbComments']) && $_POST['fbComments_includeFbComments'] == 'true') ? true : false;
		update_option('fbComments_includeFbComments', $fbComments_settings['fbComments_includeFbComments']);
		
		$fbComments_settings['fbComments_hideWpComments'] = (isset($_POST['fbComments_hideWpComments']) && $_POST['fbComments_hideWpComments'] == 'true') ? true : false;
		update_option('fbComments_hideWpComments', $fbComments_settings['fbComments_hideWpComments']);
		
		$fbComments_settings['fbComments_combineCommentCounts'] = (isset($_POST['fbComments_combineCommentCounts']) && $_POST['fbComments_combineCommentCounts'] == 'true') ? true : false;
		update_option('fbComments_combineCommentCounts', $fbComments_settings['fbComments_combineCommentCounts']);
		
		$fbComments_settings['fbComments_notify'] = (isset($_POST['fbComments_notify']) && $_POST['fbComments_notify'] == 'true') ? true : false;
		update_option('fbComments_notify', $fbComments_settings['fbComments_notify']);
		
		$fbComments_settings['fbComments_language'] = (isset($_POST['fbComments_language'])) ? $_POST['fbComments_language'] : $fbComments_defaults['fbComments_language'];
		update_option('fbComments_language', $fbComments_settings['fbComments_language']);
		
		$fbComments_settings['fbComments_displayTitle'] = (isset($_POST['fbComments_displayTitle']) && $_POST['fbComments_displayTitle'] == 'true') ? true : false;
		update_option('fbComments_displayTitle', $fbComments_settings['fbComments_displayTitle']);
		
		$fbComments_settings['fbComments_title'] = esc_html(stripslashes($_POST['fbComments_title']));
		update_option('fbComments_title', $fbComments_settings['fbComments_title']);
		
		if (intval($_POST['fbComments_numPosts']) > 0) {
			$fbComments_settings['fbComments_numPosts'] = intval($_POST['fbComments_numPosts']);
			update_option('fbComments_numPosts', $fbComments_settings['fbComments_numPosts']);
		} else {
			$fbComments_settings['fbComments_numPosts'] = get_option('fbComments_numPosts');
		}
		
		if (intval($_POST['fbComments_width']) > 0) {
			$fbComments_settings['fbComments_width'] = intval($_POST['fbComments_width']);
			update_option('fbComments_width', $fbComments_settings['fbComments_width']);
		} else {
			$fbComments_settings['fbComments_width'] = get_option('fbComments_width');
		}
		
		$fbComments_settings['fbComments_displayLocation'] = (isset($_POST['fbComments_displayLocation'])) ? $_POST['fbComments_displayLocation'] : $fbComments_defaults['fbComments_displayLocation'];
		update_option('fbComments_displayLocation', $fbComments_settings['fbComments_displayLocation']);
		
		$fbComments_settings['fbComments_displayPagesOrPosts'] = $_POST['fbComments_displayPagesOrPosts'];
		update_option('fbComments_displayPagesOrPosts', $fbComments_settings['fbComments_displayPagesOrPosts']);
		
		$fbComments_settings['fbComments_publishToWall'] = (isset($_POST['fbComments_publishToWall']) && $_POST['fbComments_publishToWall'] == 'true') ? true : false;
	    update_option('fbComments_publishToWall', $fbComments_settings['fbComments_publishToWall']);
		
		$fbComments_settings['fbComments_reverseOrder'] = (isset($_POST['fbComments_reverseOrder']) && $_POST['fbComments_reverseOrder'] == 'true') ? true : false;
		update_option('fbComments_reverseOrder', $fbComments_settings['fbComments_reverseOrder']);
		
		$fbComments_settings['fbComments_hideFbLikeButton'] = (isset($_POST['fbComments_hideFbLikeButton']) && $_POST['fbComments_hideFbLikeButton'] == 'true') ? true : false;
		update_option('fbComments_hideFbLikeButton', $fbComments_settings['fbComments_hideFbLikeButton']);
		
		$fbComments_settings['fbComments_containerCss'] = esc_html(stripslashes(trim($_POST['fbComments_containerCss'])));
		update_option('fbComments_containerCss', $fbComments_settings['fbComments_containerCss']);
		
		$fbComments_settings['fbComments_titleCss'] = esc_html(stripslashes(trim($_POST['fbComments_titleCss'])));
		update_option('fbComments_titleCss', $fbComments_settings['fbComments_titleCss']);
		
		$fbComments_settings['fbComments_darkSite'] = (isset($_POST['fbComments_darkSite']) && $_POST['fbComments_darkSite'] == 'true') ? true : false;
		update_option('fbComments_darkSite', $fbComments_settings['fbComments_darkSite']);
		
		$fbComments_settings['fbComments_noBox'] = (isset($_POST['fbComments_noBox']) && $_POST['fbComments_noBox'] == 'true') ? true : false;
		update_option('fbComments_noBox', $fbComments_settings['fbComments_noBox']);
		
		if ($errors == false)
			echo '<div class="updated"><p><strong>' . __('Options saved.') . '</strong></p></div>';
		else
			echo '<div class="updated"><p><strong>' . __($errors) . '</strong></p></div>';
	} else {
		// Retrieve the settings array
		global $fbComments_settings;
	}
?>

<link rel="stylesheet" type="text/css" href="<?php echo FBCOMMENTS_CSS_ADMIN; ?>" />

<div class="wrap">
	<?php screen_icon(); ?>
	<h2><?php _e('Facebook Comments for WordPress Options'); ?></h2>
	
	<?php
		if (version_compare(phpversion(), FBCOMMENTS_REQUIRED_PHP_VER) == -1) {
			echo '<div class="error"><p><strong>' . __('This plugin requires PHP v') . FBCOMMENTS_REQUIRED_PHP_VER . __(' or higher to run (you have PHP v') . phpversion() . __('). Please ask your webhost to install the latest version of PHP on your server.') . '</strong></p></div>';
		} elseif (!in_array('curl', get_loaded_extensions())) {
			echo '<div class="error"><p><strong>' . __('This plugin requires the PHP cURL extension to communicate with Facebook. Please ask your webhost to install the cURL extension on your server.') . '</strong></p></div>';
		} elseif (empty($fbComments_settings['fbComments_appId']) || empty($fbComments_settings['fbComments_appSecret'])) {
			echo '<div class="error"><p><strong>' . __('The Facebook comments box will not be included in your posts until you set a valid application ID and application secret.') . '</strong></p></div>';
		} elseif (isset($_POST['fbComments_update']) && $_POST['fbComments_update'] != 'true') {
			echo '<br class="gutter" />';
		}
	?>
	
	<form method="post" action="<?php echo str_replace('%7E', '~', $_SERVER['REQUEST_URI']); ?>">
		
		<div id="poststuff" class="postbox">
			<h3><?php _e('Core Settings'); ?></h3>
			
			<div class="inside">
				<p><?php _e('Application ID (<a href="http://grahamswan.com/facebook-comments/#install">Help</a>): '); ?><input type="text" name="fbComments_appId" value="<?php echo $fbComments_settings['fbComments_appId']; ?>" size="20"><em><?php _e(' (This can be retrieved from your <a href="http://www.facebook.com/developers/apps.php">Facebook application page</a>)'); ?></em></p>
				<p><?php _e('Application Secret (<a href="http://grahamswan.com/facebook-comments/#install">Help</a>): '); ?><input type="text" name="fbComments_appSecret" value="<?php echo $fbComments_settings['fbComments_appSecret']; ?>" size="20"><em><?php _e(' (This can be retrieved from your <a href="http://www.facebook.com/developers/apps.php">Facebook application page</a>)'); ?></em></p>
    			<p><?php _e('Comments XID: '); ?><input type="text" name="fbComments_xid" value="<?php echo $fbComments_settings['fbComments_xid']; ?>" size="20"><em><?php _e(" (Only change this if you know what you're doing. Must be a unique string. <a href='" . FBCOMMENTS_WEBPAGE . "#xid'>Learn more</a>)"); ?></em></p>
    			<p><input type="checkbox" id="fbComments_includeFbJs" name="fbComments_includeFbJs" value="true" <?php if ($fbComments_settings['fbComments_includeFbJs']) echo 'checked="checked"'; ?> size="20"><label for="fbComments_includeFbJs"><?php _e(' Include Facebook JavaScript SDK'); ?></label><em><?php _e(" (This should be checked unless you've manually included the SDK elsewhere)"); ?></em></p>
    			<p class="indent"><input type="checkbox" id="fbComments_includeFbJsOldWay" name="fbComments_includeFbJsOldWay" value="true" <?php if ($fbComments_settings['fbComments_includeFbJsOldWay']) echo 'checked="checked"'; ?> size="20"><label for="fbComments_includeFbJsOldWay"><?php _e(' The old way'); ?></label><em><?php _e(" (If the comments no longer load since updating the plugin, check this box to include the JavaScript SDK the old way. Combined comment counts and email notifications will not work with this option enabled)"); ?></em></p>
    			<p><input type="checkbox" id="fbComments_includeFbmlLangAttr" name="fbComments_includeFbmlLangAttr" value="true" <?php if ($fbComments_settings['fbComments_includeFbmlLangAttr']) echo 'checked="checked"'; ?> size="20"><label for="fbComments_includeFbmlLangAttr"><?php _e(' Include Facebook FBML reference'); ?></label><em><?php _e(" (This should be checked unless you have another plugin enabled that includes the FBML reference)"); ?></em></p>
    			<p><input type="checkbox" id="fbComments_includeOpenGraphLangAttr" name="fbComments_includeOpenGraphLangAttr" value="true" <?php if ($fbComments_settings['fbComments_includeOpenGraphLangAttr']) echo 'checked="checked"'; ?> size="20"><label for="fbComments_includeOpenGraphLangAttr"><?php _e(' Include OpenGraph reference'); ?></label><em><?php _e(" (This should be checked unless you have another plugin enabled that includes the OpenGraph reference)"); ?></em></p>
    			<p><input type="checkbox" id="fbComments_includeOpenGraphMeta" name="fbComments_includeOpenGraphMeta" value="true" <?php if ($fbComments_settings['fbComments_includeOpenGraphMeta']) echo 'checked="checked"'; ?> size="20"><label for="fbComments_includeOpenGraphMeta"><?php _e(' Include OpenGraph meta information'); ?></label><em><?php _e(" (This will add the following meta information to the page &lt;head&gt; to assist with Like button clicks: post/page title, site name, current URL and content type)"); ?></em></p>
			</div>
		</div>
		
		<div id="poststuff" class="postbox">
			<h3><?php _e('Application Settings'); ?></h3>
			
			<div class="inside">
    			<p><input type="checkbox" id="fbComments_includeFbComments" name="fbComments_includeFbComments" value="true" <?php if ($fbComments_settings['fbComments_includeFbComments']) echo 'checked="checked"'; ?> size="20"><label for="fbComments_includeFbComments"><?php _e(' Include Facebook comments on blog'); ?></label><em><?php _e(" (Uncheck this if you want to hide the Facebook comments without having to deactivate the plugin)"); ?></em></p>
    			<p><input type="checkbox" id="fbComments_hideWpComments" name="fbComments_hideWpComments" value="true" <?php if ($fbComments_settings['fbComments_hideWpComments']) echo 'checked="checked"'; ?> size="20"><label for="fbComments_hideWpComments"> <?php _e('Hide WordPress comments on posts/pages where Facebook commenting is enabled'); ?></label></p>
    			<p><input type="checkbox" id="fbComments_combineCommentCounts" name="fbComments_combineCommentCounts" value="true" <?php if ($fbComments_settings['fbComments_combineCommentCounts']) echo 'checked="checked"'; ?> size="20"><label for="fbComments_combineCommentCounts"> <?php _e('Combine WordPress and Facebook comment counts'); ?></label></p>
			</div>
		</div>
		
		<div id="poststuff" class="postbox">
			<h3><?php _e('Notification Settings'); ?></h3>
			
			<div class="inside">
				<p><input type="checkbox" id="fbComments_notify" name="fbComments_notify" value="true" <?php if ($fbComments_settings['fbComments_notify']) echo 'checked="checked"'; ?> size="20"><label for="fbComments_notify"><?php _e(' Email me whenever a comment is posted'); ?></label><em><?php _e(" (Email notifications will be sent to the following address: " . get_bloginfo('admin_email') . ". You can change this on the <a href='" .  admin_url('options-general.php') . "'>General Settings</a> page)"); ?></em></p>
			</div>
		</div>
		
		<div id="poststuff" class="postbox">
			<h3><?php _e('Language Settings'); ?></h3>
			
			<div class="inside">
				<p><?php _e('Language for comments: '); ?>
					<select name="fbComments_language">
						<option value="af_ZA"<?php if ($fbComments_settings['fbComments_language'] == 'af_ZA') echo ' selected="selected"'; ?>>Afrikaans</option>
						<option value="sq_AL"<?php if ($fbComments_settings['fbComments_language'] == 'sq_AL') echo ' selected="selected"'; ?>>Albanian</option>
						<option value="ar_AR"<?php if ($fbComments_settings['fbComments_language'] == 'ar_AR') echo ' selected="selected"'; ?>>Arabic</option>
						<option value="hy_AM"<?php if ($fbComments_settings['fbComments_language'] == 'hy_AM') echo ' selected="selected"'; ?>>Armenian</option>
						<option value="ay_BO"<?php if ($fbComments_settings['fbComments_language'] == 'ay_BO') echo ' selected="selected"'; ?>>Aymara</option>
						<option value="az_AZ"<?php if ($fbComments_settings['fbComments_language'] == 'az_AZ') echo ' selected="selected"'; ?>>Azeri</option>
						<option value="eu_ES"<?php if ($fbComments_settings['fbComments_language'] == 'eu_ES') echo ' selected="selected"'; ?>>Basque</option>
						<option value="be_BY"<?php if ($fbComments_settings['fbComments_language'] == 'be_BY') echo ' selected="selected"'; ?>>Belarusian</option>
						<option value="bn_IN"<?php if ($fbComments_settings['fbComments_language'] == 'bn_IN') echo ' selected="selected"'; ?>>Bengali</option>
						<option value="bs_BA"<?php if ($fbComments_settings['fbComments_language'] == 'bs_BA') echo ' selected="selected"'; ?>>Bosnian</option>
						<option value="bg_BG"<?php if ($fbComments_settings['fbComments_language'] == 'bg_BG') echo ' selected="selected"'; ?>>Bulgarian</option>
						<option value="ca_ES"<?php if ($fbComments_settings['fbComments_language'] == 'ca_ES') echo ' selected="selected"'; ?>>Catalan</option>
						<option value="ck_US"<?php if ($fbComments_settings['fbComments_language'] == 'ck_US') echo ' selected="selected"'; ?>>Cherokee</option>
						<option value="hr_HR"<?php if ($fbComments_settings['fbComments_language'] == 'hr_HR') echo ' selected="selected"'; ?>>Croatian</option>
						<option value="cs_CZ"<?php if ($fbComments_settings['fbComments_language'] == 'cs_CZ') echo ' selected="selected"'; ?>>Czech</option>
						<option value="da_DK"<?php if ($fbComments_settings['fbComments_language'] == 'da_DK') echo ' selected="selected"'; ?>>Danish</option>
						<option value="nl_BE"<?php if ($fbComments_settings['fbComments_language'] == 'nl_BE') echo ' selected="selected"'; ?>>Dutch (Belgi&euml;)</option>
						<option value="nl_NL"<?php if ($fbComments_settings['fbComments_language'] == 'nl_NL') echo ' selected="selected"'; ?>>Dutch</option>
						<option value="en_PI"<?php if ($fbComments_settings['fbComments_language'] == 'en_PI') echo ' selected="selected"'; ?>>English (Pirate)</option>
						<option value="en_GB"<?php if ($fbComments_settings['fbComments_language'] == 'en_GB') echo ' selected="selected"'; ?>>English (UK)</option>
						<option value="en_US"<?php if ($fbComments_settings['fbComments_language'] == 'en_US') echo ' selected="selected"'; ?>>English (US)</option>
						<option value="en_UD"<?php if ($fbComments_settings['fbComments_language'] == 'en_UD') echo ' selected="selected"'; ?>>English (Upside Down)</option>
						<option value="eo_EO"<?php if ($fbComments_settings['fbComments_language'] == 'eo_EO') echo ' selected="selected"'; ?>>Esperanto</option>
						<option value="et_EE"<?php if ($fbComments_settings['fbComments_language'] == 'et_EE') echo ' selected="selected"'; ?>>Estonian</option>
						<option value="fo_FO"<?php if ($fbComments_settings['fbComments_language'] == 'fo_FO') echo ' selected="selected"'; ?>>Faroese</option>
						<option value="tl_PH"<?php if ($fbComments_settings['fbComments_language'] == 'tl_PH') echo ' selected="selected"'; ?>>Filipino</option>
						<option value="fb_FI"<?php if ($fbComments_settings['fbComments_language'] == 'fb_FI') echo ' selected="selected"'; ?>>Finnish (test)</option>
						<option value="fi_FI"<?php if ($fbComments_settings['fbComments_language'] == 'fi_FI') echo ' selected="selected"'; ?>>Finnish</option>
						<option value="fr_CA"<?php if ($fbComments_settings['fbComments_language'] == 'fr_CA') echo ' selected="selected"'; ?>>French (Canada)</option>
						<option value="fr_FR"<?php if ($fbComments_settings['fbComments_language'] == 'fr_FR') echo ' selected="selected"'; ?>>French (France)</option>
						<option value="gl_ES"<?php if ($fbComments_settings['fbComments_language'] == 'gl_ES') echo ' selected="selected"'; ?>>Galician</option>
						<option value="ka_GE"<?php if ($fbComments_settings['fbComments_language'] == 'ka_GE') echo ' selected="selected"'; ?>>Georgian</option>
						<option value="de_DE"<?php if ($fbComments_settings['fbComments_language'] == 'de_DE') echo ' selected="selected"'; ?>>German</option>
						<option value="el_GR"<?php if ($fbComments_settings['fbComments_language'] == 'el_GR') echo ' selected="selected"'; ?>>Greek</option>
						<option value="gn_PY"<?php if ($fbComments_settings['fbComments_language'] == 'gn_PY') echo ' selected="selected"'; ?>>Guaran&iacute;</option>
						<option value="gu_IN"<?php if ($fbComments_settings['fbComments_language'] == 'gu_IN') echo ' selected="selected"'; ?>>Gujarati</option>
						<option value="he_IL"<?php if ($fbComments_settings['fbComments_language'] == 'he_IL') echo ' selected="selected"'; ?>>Hebrew</option>
						<option value="hi_IN"<?php if ($fbComments_settings['fbComments_language'] == 'hi_IN') echo ' selected="selected"'; ?>>Hindi</option>
						<option value="hu_HU"<?php if ($fbComments_settings['fbComments_language'] == 'hu_HU') echo ' selected="selected"'; ?>>Hungarian</option>
						<option value="is_IS"<?php if ($fbComments_settings['fbComments_language'] == 'is_IS') echo ' selected="selected"'; ?>>Icelandic</option>
						<option value="id_ID"<?php if ($fbComments_settings['fbComments_language'] == 'id_ID') echo ' selected="selected"'; ?>>Indonesian</option>
						<option value="ga_IE"<?php if ($fbComments_settings['fbComments_language'] == 'ga_IE') echo ' selected="selected"'; ?>>Irish</option>
						<option value="it_IT"<?php if ($fbComments_settings['fbComments_language'] == 'it_IT') echo ' selected="selected"'; ?>>Italian</option>
						<option value="ja_JP"<?php if ($fbComments_settings['fbComments_language'] == 'ja_JP') echo ' selected="selected"'; ?>>Japanese</option>
						<option value="jv_ID"<?php if ($fbComments_settings['fbComments_language'] == 'jv_ID') echo ' selected="selected"'; ?>>Javanese</option>
						<option value="kn_IN"<?php if ($fbComments_settings['fbComments_language'] == 'kn_IN') echo ' selected="selected"'; ?>>Kannada</option>
						<option value="kk_KZ"<?php if ($fbComments_settings['fbComments_language'] == 'kk_KZ') echo ' selected="selected"'; ?>>Kazakh</option>
						<option value="km_KH"<?php if ($fbComments_settings['fbComments_language'] == 'km_KH') echo ' selected="selected"'; ?>>Khmer</option>
						<option value="tl_ST"<?php if ($fbComments_settings['fbComments_language'] == 'tl_ST') echo ' selected="selected"'; ?>>Klingon</option>
						<option value="ko_KR"<?php if ($fbComments_settings['fbComments_language'] == 'ko_KR') echo ' selected="selected"'; ?>>Korean</option>
						<option value="ku_TR"<?php if ($fbComments_settings['fbComments_language'] == 'ku_TR') echo ' selected="selected"'; ?>>Kurdish</option>
						<option value="la_VA"<?php if ($fbComments_settings['fbComments_language'] == 'la_VA') echo ' selected="selected"'; ?>>Latin</option>
						<option value="lv_LV"<?php if ($fbComments_settings['fbComments_language'] == 'lv_LV') echo ' selected="selected"'; ?>>Latvian</option>
						<option value="fb_LT"<?php if ($fbComments_settings['fbComments_language'] == 'fb_LT') echo ' selected="selected"'; ?>>Leet Speak</option>
						<option value="li_NL"<?php if ($fbComments_settings['fbComments_language'] == 'li_NL') echo ' selected="selected"'; ?>>Limburgish</option>
						<option value="lt_LT"<?php if ($fbComments_settings['fbComments_language'] == 'lt_LT') echo ' selected="selected"'; ?>>Lithuanian</option>
						<option value="mk_MK"<?php if ($fbComments_settings['fbComments_language'] == 'mk_MK') echo ' selected="selected"'; ?>>Macedonian</option>
						<option value="mg_MG"<?php if ($fbComments_settings['fbComments_language'] == 'mg_MG') echo ' selected="selected"'; ?>>Malagasy</option>
						<option value="ms_MY"<?php if ($fbComments_settings['fbComments_language'] == 'ms_MY') echo ' selected="selected"'; ?>>Malay</option>
						<option value="ml_IN"<?php if ($fbComments_settings['fbComments_language'] == 'ml_IN') echo ' selected="selected"'; ?>>Malayalam</option>
						<option value="mt_MT"<?php if ($fbComments_settings['fbComments_language'] == 'mt_MT') echo ' selected="selected"'; ?>>Maltese</option>
						<option value="mr_IN"<?php if ($fbComments_settings['fbComments_language'] == 'mr_IN') echo ' selected="selected"'; ?>>Marathi</option>
						<option value="mn_MN"<?php if ($fbComments_settings['fbComments_language'] == 'mn_MN') echo ' selected="selected"'; ?>>Mongolian</option>
						<option value="ne_NP"<?php if ($fbComments_settings['fbComments_language'] == 'ne_NP') echo ' selected="selected"'; ?>>Nepali</option>
						<option value="se_NO"<?php if ($fbComments_settings['fbComments_language'] == 'se_NO') echo ' selected="selected"'; ?>>Northern S&aacute;mi</option>
						<option value="nb_NO"<?php if ($fbComments_settings['fbComments_language'] == 'nb_NO') echo ' selected="selected"'; ?>>Norwegian (bokmal)</option>
						<option value="nn_NO"<?php if ($fbComments_settings['fbComments_language'] == 'nn_NO') echo ' selected="selected"'; ?>>Norwegian (nynorsk)</option>
						<option value="ps_AF"<?php if ($fbComments_settings['fbComments_language'] == 'ps_AF') echo ' selected="selected"'; ?>>Pashto</option>
						<option value="fa_IR"<?php if ($fbComments_settings['fbComments_language'] == 'fa_IR') echo ' selected="selected"'; ?>>Persian</option>
						<option value="pl_PL"<?php if ($fbComments_settings['fbComments_language'] == 'pl_PL') echo ' selected="selected"'; ?>>Polish</option>
						<option value="pt_BR"<?php if ($fbComments_settings['fbComments_language'] == 'pt_BR') echo ' selected="selected"'; ?>>Portuguese (Brazil)</option>
						<option value="pt_PT"<?php if ($fbComments_settings['fbComments_language'] == 'pt_PT') echo ' selected="selected"'; ?>>Portuguese (Portugal)</option>
						<option value="pa_IN"<?php if ($fbComments_settings['fbComments_language'] == 'pa_IN') echo ' selected="selected"'; ?>>Punjabi</option>
						<option value="qu_PE"<?php if ($fbComments_settings['fbComments_language'] == 'qu_PE') echo ' selected="selected"'; ?>>Quechua</option>
						<option value="ro_RO"<?php if ($fbComments_settings['fbComments_language'] == 'ro_RO') echo ' selected="selected"'; ?>>Romanian</option>
						<option value="rm_CH"<?php if ($fbComments_settings['fbComments_language'] == 'rm_CH') echo ' selected="selected"'; ?>>Romansh</option>
						<option value="ru_RU"<?php if ($fbComments_settings['fbComments_language'] == 'ru_RU') echo ' selected="selected"'; ?>>Russian</option>
						<option value="sa_IN"<?php if ($fbComments_settings['fbComments_language'] == 'sa_IN') echo ' selected="selected"'; ?>>Sanskrit</option>
						<option value="sr_RS"<?php if ($fbComments_settings['fbComments_language'] == 'sr_RS') echo ' selected="selected"'; ?>>Serbian</option>
						<option value="zh_CN"<?php if ($fbComments_settings['fbComments_language'] == 'zh_CN') echo ' selected="selected"'; ?>>Simplified Chinese (China)</option>
						<option value="sk_SK"<?php if ($fbComments_settings['fbComments_language'] == 'sk_SK') echo ' selected="selected"'; ?>>Slovak</option>
						<option value="sl_SI"<?php if ($fbComments_settings['fbComments_language'] == 'sl_SI') echo ' selected="selected"'; ?>>Slovenian</option>
						<option value="so_SO"<?php if ($fbComments_settings['fbComments_language'] == 'so_SO') echo ' selected="selected"'; ?>>Somali</option>
						<option value="es_CL"<?php if ($fbComments_settings['fbComments_language'] == 'es_CL') echo ' selected="selected"'; ?>>Spanish (Chile)</option>
						<option value="es_CO"<?php if ($fbComments_settings['fbComments_language'] == 'es_CO') echo ' selected="selected"'; ?>>Spanish (Colombia)</option>
						<option value="es_MX"<?php if ($fbComments_settings['fbComments_language'] == 'es_MX') echo ' selected="selected"'; ?>>Spanish (Mexico)</option>
						<option value="es_ES"<?php if ($fbComments_settings['fbComments_language'] == 'es_ES') echo ' selected="selected"'; ?>>Spanish (Spain)</option>
						<option value="es_VE"<?php if ($fbComments_settings['fbComments_language'] == 'es_VE') echo ' selected="selected"'; ?>>Spanish (Venezuela)</option>
						<option value="es_LA"<?php if ($fbComments_settings['fbComments_language'] == 'es_LA') echo ' selected="selected"'; ?>>Spanish</option>
						<option value="sw_KE"<?php if ($fbComments_settings['fbComments_language'] == 'sw_KE') echo ' selected="selected"'; ?>>Swahili</option>
						<option value="sv_SE"<?php if ($fbComments_settings['fbComments_language'] == 'sv_SE') echo ' selected="selected"'; ?>>Swedish</option>
						<option value="sy_SY"<?php if ($fbComments_settings['fbComments_language'] == 'sy_SY') echo ' selected="selected"'; ?>>Syriac</option>
						<option value="tg_TJ"<?php if ($fbComments_settings['fbComments_language'] == 'tg_TJ') echo ' selected="selected"'; ?>>Tajik</option>
						<option value="ta_IN"<?php if ($fbComments_settings['fbComments_language'] == 'ta_IN') echo ' selected="selected"'; ?>>Tamil</option>
						<option value="tt_RU"<?php if ($fbComments_settings['fbComments_language'] == 'tt_RU') echo ' selected="selected"'; ?>>Tatar</option>
						<option value="te_IN"<?php if ($fbComments_settings['fbComments_language'] == 'te_IN') echo ' selected="selected"'; ?>>Telugu</option>
						<option value="th_TH"<?php if ($fbComments_settings['fbComments_language'] == 'th_TH') echo ' selected="selected"'; ?>>Thai</option>
						<option value="zh_HK"<?php if ($fbComments_settings['fbComments_language'] == 'zh_HK') echo ' selected="selected"'; ?>>Traditional Chinese (Hong Kong)</option>
						<option value="zh_TW"<?php if ($fbComments_settings['fbComments_language'] == 'zh_TW') echo ' selected="selected"'; ?>>Traditional Chinese (Taiwan)</option>
						<option value="tr_TR"<?php if ($fbComments_settings['fbComments_language'] == 'tr_TR') echo ' selected="selected"'; ?>>Turkish</option>
						<option value="uk_UA"<?php if ($fbComments_settings['fbComments_language'] == 'uk_UA') echo ' selected="selected"'; ?>>Ukrainian</option>
						<option value="ur_PK"<?php if ($fbComments_settings['fbComments_language'] == 'ur_PK') echo ' selected="selected"'; ?>>Urdu</option>
						<option value="uz_UZ"<?php if ($fbComments_settings['fbComments_language'] == 'uz_UZ') echo ' selected="selected"'; ?>>Uzbek</option>
						<option value="vi_VN"<?php if ($fbComments_settings['fbComments_language'] == 'vi_VN') echo ' selected="selected"'; ?>>Vietnamese</option>
						<option value="cy_GB"<?php if ($fbComments_settings['fbComments_language'] == 'cy_GB') echo ' selected="selected"'; ?>>Welsh</option>
						<option value="xh_ZA"<?php if ($fbComments_settings['fbComments_language'] == 'xh_ZA') echo ' selected="selected"'; ?>>Xhosa</option>
						<option value="yi_DE"<?php if ($fbComments_settings['fbComments_language'] == 'yi_DE') echo ' selected="selected"'; ?>>Yiddish</option>
						<option value="zu_ZA"<?php if ($fbComments_settings['fbComments_language'] == 'zu_ZA') echo ' selected="selected"'; ?>>Zulu</option>
					</select>
				</p>
			</div>
		</div>
		
		<div id="poststuff" class="postbox">
			<h3><?php _e('Comments Box Settings'); ?></h3>
			
			<div class="inside">
				<p><?php _e('Facebook Comments Section Title: '); ?><input type="text" name="fbComments_title" value="<?php echo $fbComments_settings['fbComments_title']; ?>" size="30"><em><?php _e(' (This is the title text displayed above the Facebook commenting section)'); ?></em></p>
				<p><input type="checkbox" id="fbComments_displayTitle" name="fbComments_displayTitle" value="true" <?php if ($fbComments_settings['fbComments_displayTitle']) echo 'checked="checked"'; ?> size="20"><label for="fbComments_displayTitle"><?php _e(' Display the Facebook comments title (set above)'); ?></label></p>
				<p><?php _e('Number of Posts to Display: '); ?><input type="text" name="fbComments_numPosts" value="<?php echo $fbComments_settings['fbComments_numPosts']; ?>" size="5" maxlength="3"></p>
				<p><?php _e('Width of Comments Box (px): '); ?><input type="text" name="fbComments_width" value="<?php echo $fbComments_settings['fbComments_width']; ?>" size="5" maxlength="4"></p>
				<p><?php _e('Display Facebook comments before or after WordPress comments? '); ?>
					<select name="fbComments_displayLocation" disabled="disabled">
						<option value="before"<?php if ($fbComments_settings['fbComments_displayLocation'] == 'before') echo ' selected="selected"'; ?>>Before</option>
						<option value="after"<?php if ($fbComments_settings['fbComments_displayLocation'] == 'after') echo ' selected="selected"'; ?>>After</option>
					</select>
					<em><?php _e(" (<strong>In development; <a href='" . FBCOMMENTS_WEBPAGE . "#comment_placement'>see here</a> for manual instructions</strong>)"); ?></em>
				</p>
				<p><?php _e('Display Facebook comments on pages only, posts only or both? '); ?>
					<select name="fbComments_displayPagesOrPosts">
						<option value="both"<?php if ($fbComments_settings['fbComments_displayPagesOrPosts'] == 'both') echo ' selected="selected"'; ?>>Both</option>
						<option value="pages"<?php if ($fbComments_settings['fbComments_displayPagesOrPosts'] == 'pages') echo ' selected="selected"'; ?>>Pages only</option>
						<option value="posts"<?php if ($fbComments_settings['fbComments_displayPagesOrPosts'] == 'posts') echo ' selected="selected"'; ?>>Posts only</option>
					</select>
				</p>
				<p><input type="checkbox" id="fbComments_publishToWall" name="fbComments_publishToWall" value="true" <?php if ($fbComments_settings['fbComments_publishToWall']) echo 'checked="checked"'; ?> size="20"><label for="fbComments_publishToWall"><?php _e(' Check the <strong>Post comment to my Facebook profile</strong> box by default'); ?></label></p>
				<p><input type="checkbox" id="fbComments_reverseOrder" name="fbComments_reverseOrder" value="true" <?php if ($fbComments_settings['fbComments_reverseOrder']) echo 'checked="checked"'; ?> size="20"><label for="fbComments_reverseOrder"><?php _e(' Reverse the order of the Facebook comments section'); ?></label><em><?php _e('  (Comments will appear in chronological order and the composer will be at the bottom)'); ?></em></p>
				<p><input type="checkbox" id="fbComments_hideFbLikeButton" name="fbComments_hideFbLikeButton" value="true" <?php if ($fbComments_settings['fbComments_hideFbLikeButton']) echo 'checked="checked"'; ?> size="20"><label for="fbComments_hideFbLikeButton"><?php _e(' Hide the Like button and text'); ?></label></p>
			</div>
		</div>
		
		<div id="poststuff" class="postbox">
			<h3><?php _e('Style Settings'); ?></h3>
			
			<div class="inside">
				<p><?php _e('Container Styles: '); ?><input type="text" name="fbComments_containerCss" value="<?php echo $fbComments_settings['fbComments_containerCss']; ?>" size="70"><em><?php _e(' (These styles will be applied to a &lt;div&gt; element wrapping the comments box)'); ?></em></p>
				<p><?php _e('Title Styles: '); ?><input type="text" name="fbComments_titleCss" value="<?php echo $fbComments_settings['fbComments_titleCss']; ?>" size="70"><em><?php _e(' (These styles will be applied to the title text above the comments box)'); ?></em></p>
				<p><input type="checkbox" id="fbComments_darkSite" name="fbComments_darkSite" value="true" <?php if ($fbComments_settings['fbComments_darkSite']) echo 'checked="checked"'; ?> size="20"><label for="fbComments_darkSite"><?php _e(' Use colors more easily visible on a darker website'); ?></label><em><?php _e('  (To modify the colors used for darker sites, manually edit the <strong>facebook-comments-darksite.css</strong> stylesheet)'); ?></em></p>
				<p><input type="checkbox" id="fbComments_noBox" name="fbComments_noBox" value="true" <?php if ($fbComments_settings['fbComments_noBox']) echo 'checked="checked"'; ?> size="20"><label for="fbComments_noBox"><?php _e(' Remove grey box surrounding Facebook comments'); ?></label></p>
			</div>
		</div>
		
		<div id="poststuff" class="postbox">
			<h3><?php _e('Dashboard Widget Settings'); ?></h3>
			
			<div class="inside">
				<p><?php _e('Number of Comments to Display: '); ?><input type="text" name="fbComments_dashNumComments" value="<?php echo $fbComments_settings['fbComments_dashNumComments']; ?>" size="5" maxlength="3"></p>
			</div>
		</div>
		
		<input type="hidden" name="fbComments_update" value="true" />
		
		<input type="submit" class="button-primary" value="<?php _e('Update Options'); ?>" />
		
	</form>
	
	<div id="poststuff" class="postbox gutter">
		<h3><?php _e('Donate'); ?></h3>
			
		<div class="inside contain-floats">		
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post" id="paypal">
				<input type="hidden" name="cmd" value="_xclick" />
				<input type="hidden" name="business" value="thinkswan@gmail.com" />
				<input type="hidden" name="item_name" value="Donation to Facebook Comments for WordPress plugin" />
				<input type="hidden" name="item_number" value="0" />
				<input type="hidden" name="notify_url" value="" />
				<input type="hidden" name="no_shipping" value="1" />
				<input type="hidden" name="return" value="<?php echo (!empty($_SERVER['HTTPS'])) ? 'https://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] : 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']; ?>" />
				<input type="hidden" name="no_note" value="1" />
				<input type="hidden" name="tax" value="0" />
				<input type="hidden" name="bn" value="PP-DonationsBF" />
				<input type="hidden" name="on0" value="Website" />
				
				<p>Currency:
				<select id="currency_code" name="currency_code">
				    <option value="USD">U.S. Dollars</option>
				    <option value="AUD">Australian Dollars</option>
				    <option value="CAD">Canadian Dollars</option>
				    <option value="EUR">Euros</option>
				    <option value="GBP">Pounds Sterling</option>
				    <option value="JPY">Yen</option>
				</select></p>

				<p>Amount:
				<input type="text" name="amount" size="16" title="The amount you wish to donate" value="10.00" /></p>
				
				<p><input class="ppimg donateButton" type="image" src="https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif" name="submit" style="border:0;" alt="Make a donation" />
				<span class="donateText">Please consider making a contribution towards future development of this plugin!</span></p>
			</form>
		</div>
	</div>
	
	<div id="icon-help"></div>
	<h2><?php _e('If you need help, please refer to the <a href="' . FBCOMMENTS_WEBPAGE . '#faq">official FAQ</a>.'); ?></h2>
    
    <br />
</div>
