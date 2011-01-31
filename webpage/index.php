<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<!-- All content, code and images written and created by Graham Swan (thinkswan@gmail.com), 2010. -->

<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml" xmlns:og="http://opengraphprotocol.org/schema/">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="keywords" content="graham, swan, graham, wordpress, plugin, plug-in, extension, facebook comments, social graph" />
<meta name="description" content="Facebook Comments for WordPress allows your visitors to comment on your WordPress content using their Facebook profile. Makes use of Facebook's new Social Graph plugins." />
<meta property="og:title" content="Facebook Comments for WordPress" />
<meta property="og:site_name" content="Graham Swan's Portfolio" />
<meta property="og:url" content="http://grahamswan.com/facebook-comments/" />
<meta property="og:image" content="http://grahamswan.com/facebook-comments/_images/fbcomments_icon.png" />
<meta property="og:type" content="product" />
<meta property="og:description" content="Facebook Comments for WordPress allows your visitors to comment on your WordPress content using their Facebook profile. Makes use of Facebook's new Social Graph plugins." />
<meta property="fb:app_id" content="112887758747965" />
<link rel="shortcut icon" href="_images/favicon.ico" type="image/x-icon" />
<link rel="stylesheet" type="text/css" href="_css/reset.css" />
<link rel="stylesheet" type="text/css" href="_css/tipsy.css" />
<link rel="stylesheet" type="text/css" href="_css/default.css" />
<script type="text/javascript" src="_scripts/jquery-1.4.1.min.js"></script>
<script type="text/javascript" src="_scripts/jquery.tipsy.js"></script>
<script type="text/javascript" src="_scripts/common.js"></script>
<title>Facebook Comments for WordPress | A WordPress plugin that enables visitors to comment on blog posts using their Facebook account</title>
</head>

<body>

	<div id="container">
	
		<a name="top"></a><img src="_images/title.png" alt="Facebook Comments for WordPress" width="903" height="96" />
		
		<div id="mainBox">
			<div class="navbar">
				<a href="#what">What Is It?</a>
				<a href="#demo">Live Demo</a>
				<a href="#screenshots">Screenshots</a>
				<a href="#upcoming">Upcoming Features</a>
				<a href="#issues">Known Issues</a>
				<a href="#faq">FAQ</a>
			</div>
			
			<div class="navbar">
				<a href="#install">How To Install</a>
				<a href="#remove">How to Remove</a>
				<a href="#contact">Contact</a>
				<a href="#donate">Donate</a>
				<a href="http://wordpress.org/extend/plugins/facebook-comments-for-wordpress/">WordPress.org</a>
			</div>
			
			<!-- Alert Box -->
			<!--<br class="clear" />
			<div class="notice yellow">
				<img src="_images/alert_smiley.png" width="64" height="64" />
				<p>There's a bug in the comments box.</p>
				Facebook introduced a bug in their latest release of the comment box (it even appears on <a href="http://developers.facebook.com/docs/reference/plugins/comments">their own website</a>). When you try to post a comment, the textbox will flash red and will fail to save the comment.<br /><br />
				
				Facebook will fix this bug in their next update, though I'm not sure of an exact date. It's out of my control.
			</div>-->
			
			<!-- Notice Box -->
			<br class="clear" />
			<div class="notice">
				<img src="_images/notice_link.png" width="64" height="64" />
				<p>Version 2.0 is out!</p>
				At long last, the new version of the plugin has been released. Important changes in this release include:
				
				<ul>
					<li>Option to send email notifications to the site admin whenever a comment is posted</li>
					<li>Ability to load the JavaScript SDK the old way (for those of you who experienced issues with v1.6)</li>
					<li>Comment counts are now cached (no more slow load times on the main page)</li>
					<li>Ability to set the comment box width to 100%</li>
				</ul>
				
				You can <a href="http://wordpress.org/extend/plugins/facebook-comments-for-wordpress/">download the new version here</a> or directly through your WordPress backend.
			</div>
			
			<!-- What Is It? -->
			<br class="clear" />
			<a name="what"></a><h2>What Is It?<a href="#top">&uarr;Top</a></h2>
			
			<p class="twoCol gutter"><strong>It's a Way to Enable Your Visitors</strong><br />
			People get frustrated each and every time they're required to give their name and email to a website. After installing this simple plugin, your readers can interact with your site using their Facebook account.</p>
			
			<p class="twoCol"><strong>Features</strong><br />
			<strong>&raquo;</strong> Post comments using your Facebook name and photo<br />
			<strong>&raquo;</strong> Set the number of comments you want to display<br />
			<strong>&raquo;</strong> Style the comment box to match your site's theme<br />
			<strong>&raquo;</strong> Receive notifications when new comments are posted</p>	
			
			<!-- Live Demo -->
			<br class="clear" />
			<a name="demo"></a><h2 class="topMargin">Live Demo<a href="#top">&uarr;Top</a></h2>
			
			<!-- Facebook Comments for WordPress by Graham Swan (http://grahamswan.com/facebook-comments) -->
			
			<div id="fb-root"></div>
			<script>
				window.fbAsyncInit = function() {
					FB.init({appId: '112887758747965', status: true, cookie: true, xfbml: true});
				};
				(function() {
					var e = document.createElement('script'); e.async = true;
					e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
					document.getElementById('fb-root').appendChild(e);
				}());
			</script>
			
			<p class="comments">Facebook comments:</p>
			<fb:comments xid='f2059fjvg309568h' numposts='10' width='819' publish_feed='false'></fb:comments>
			
			<!-- Usage Screenshots -->
			<br class="clear" />
			<a name="screenshots"></a><h2 class="topMargin">Usage Screenshots<a href="#top">&uarr;Top</a></h2>
			
			<span class="number">1.</span>
			<span class="instruction">If you don't set a Facebook application ID, the following will appear in your comments (if you're an admin).</span>
			<img src="_images/screen_comments_error.png" alt="" width="531" height="96" class="center clear" />
			
			<span class="number clear">2.</span>
			<span class="instruction">This is the Facebook comments box, complete with comments.</span>
			<img src="_images/screen_comments.png" alt="" width="532" height="653" class="center clear" />
			
			<span class="number clear">3.</span>
			<span class="instruction">This is the anonymous posting form that non-Facebook users see.</span>
			<img src="_images/screen_anonymous.png" alt="" width="532" height="251" class="center clear" />
			
			<span class="number clear">4.</span>
			<span class="instruction">This is the comments box with the <strong>Reverse</strong> option enabled.</span>
			<img src="_images/screen_comments_reversed.png" alt="" width="534" height="491" class="center clear" />
			
			<span class="number clear">5.</span>
			<span class="instruction">This is the comments box using an external stylesheet (for dark sites).</span>
			<img src="_images/screen_comments_custom.png" alt="" width="536" height="490" class="center clear" />
			
			<span class="number clear">6.</span>
			<span class="instruction">This is the comments box with the <strong>Remove grey box</strong> option enabled.</span>
			<img src="_images/screen_comments_simple.png" alt="" width="532" height="188" class="center clear" />
			
			<span class="number clear">7.</span>
			<span class="instruction">Clicking the <strong>Administer Comments</strong> link allows you to block specific users from commenting.</span>
			<img src="_images/screen_comments_admin.png" alt="" width="540" height="455" class="center clear" />
			
			<!-- Upcoming Features -->
			<br class="clear" />
			<a name="upcoming"></a><h2 class="topMargin">Upcoming Features<a href="#top">&uarr;Top</a></h2>
			
			<span class="number clear">&bull;</span>
			<span class="instruction">Option to <strong>include Facebook comments in the Recent Comments list</strong></span>
			
			<span class="number clear">&bull;</span>
			<span class="instruction">Option to allow the Facebook comments box to be included before or after the WordPress comments</span>
			
			<span class="number clear">&bull;</span>
			<span class="instruction">Ability to <strong>import Facebook comments into the WordPress database</strong> and vice-versa</span>
			
			<span class="number clear">&bull;</span>
			<span class="instruction">Ability to <strong>moderate all comments</strong> against a profanity/spam list</span>
			
			<span class="number clear">&bull;</span>
			<span class="instruction">Option to specify an image to be used in the link that's generated on Facebook when the Like button is clicked</span>
			
			<span class="number clear">&bull;</span>
			<span class="instruction">Option to <strong>link to a landing page instead</strong> of to the post a comment was made on</span>
			
			<!-- Known Issues -->
			<br class="clear" />
			<a name="issues"></a><h2 class="topMargin">Known Issues<a href="#top">&uarr;Top</a></h2>
			
			<span class="number clear">&bull;</span>
			<span class="instruction"><strong>Post comment to my Facebook profile</strong> option can't be unchecked by default <em>(Facebook bug)</em></span>
			
			<span class="number clear">&bull;</span>
			<span class="instruction">After deleting a comment, all <strong>Delete</strong> links disappear <em>(Facebook bug; try refreshing the page)</em></span>
			
			<span class="number clear">&bull;</span>
			<span class="instruction">New comments may take a few minutes to show up <em>(Facebook bug due to latency on their servers)</em></span>
			
			<span class="number clear">&bull;</span>
			<span class="instruction">Comments don't appear in the Opera web browser <em>(Facebook's JavaScript library doesn't support Opera)</em></span>
			
			<!-- FAQ -->
			<br class="clear" />
			<a name="faq"></a><h2 class="topMargin">Frequently Asked Questions<a href="#top">&uarr;Top</a></h2>
			
			<h3>My comments aren't showing up. All I see is the <em>Facebook comments</em> title.</h3>
			<p>This plugin currently conflicts with the following Facebook-related plugins:</p>
			
			<ul>
        		<li>Digg Digg</li>
				<li>FaceBook Share (New)</li>
				<li>Simple Facebook Connect</li>
				<li>Simple Facebook Share Button</li>
			</ul>
			
			<p>This is because this plugin loads Facebook's new JavaScript library while other plugins load the old library. On pages where both libraries are loaded, only the first plugin will work properly. (The authors of the aforementioned plugins need to update their code.)</p>
			
			<p class="highlight">Please disable these plugins to see if they're conflicting <em>before</em> emailing me. Their implementation is beyond my control.</p>
			
			<h3>How can I resolve conflicts with the Facebook Like and Share buttons?</h3>
			<p>There are a few steps you can take to remedy these issues.</p>
			
			<p>First, check if your page is including the following script more than once:</p>
			<ul>
				<li><span class="code">&lt;script src="http://connect.facebook.net/en_US/all.js" type="text/javascript"&gt;&lt;/script&gt;</span></li>
			</ul>
			
			<p>If so, you'll need to manually remove the offending inclusion (either from your <strong>single.php</strong> file, your <strong>page.php</strong> or one of your plugins). Ensure you keep the inclusion that's attached to this plugin. It shows up in the following format:</p>
			<ul>
				<li><span class="code">&lt;script src="http://connect.facebook.net/en_US/all.js#appId=&lt;your_app_id&gt;&amp;xfbml=1" type="text/javascript"&gt;&lt;/script&gt;</span></li>
			</ul>
			
			<p>If that doesn't remedy the conflict, look for the following script on your page and remove it:</p>
			<ul>
				<li><span class="code">&lt;script src="http://static.ak.fbcdn.net/connect.php/js/FB.Share" type="text/javascript"&gt;&lt;/script&gt;</span></li>
			</ul>
			
			<p>If this causes your Facebook Like or Share button to stop working, you'll need to update your code as follows:</p>
			<ul>
				<li>Change this: <span class="code">&lt;a name="fb_share" type="box_count" share_url="&lt;your_webpage&gt;" href="http://www.facebook.com/sharer.php"&gt;Share&lt;/a&gt;</span></li>
				<li>...to this: <span class="code">&lt;fb:like-box href="&lt;your_webpage&gt;" width="200" connections="6" stream="true" header="false"&gt;&lt;/fb:like-box&gt;</span></li>
			</ul>
			
			<p>You can read more about the proper way to include Facebook Like and Share buttons on the <a href="http://developers.facebook.com/docs/reference/plugins/like">Facebook Developer website</a>.</p>
			
			<h3>The comments aren't showing up on my pages/posts at all (not even the <em>Facebook comments</em> title).</h3>
			<p>The Facebook comments attach themselves to the default WordPress comments, so you need to enable commenting on your pages and posts for this plugin to work.</p>
			
			<p>You can hide the default WordPress comments afterwards by checking the <em>Hide WordPress comments on posts/pages where Facebook commenting is enabled</em> option on the plugin's settings page.</p>

			<h3>I receive a syntax/fatal error when I activate the plugin.</h3>
			<p>If you receive either of the following errors, please contact your webhost and ask them to upgrade their servers to the latest version of PHP:</p>
			
			<ul>
			    <li>Syntax error (<span class="code">unexpected '{'</span>) in <span class="code">facebook-comments-functions.php</span> on <span class="code">line 81</span></li>
			    <li>Fatal error (<span class="code">cannot redeclare class FacebookApiException</span>) in <span class="code">scripts/facebook.php</span> on <span class="code">line 91</span></li>
			</ul>
			
			<p>If you receive the following error, please ask your webhost to install the PHP cURL extension (a common PHP library for communicating with other websites):</p>
			
			<ul>
				<li>Fatal error (<span class="code">Uncaught exception 'Exception' with message 'Facebook needs the CURL PHP extension.')</span> in <span class="code">scripts/facebook.php</span></li>
			</ul>
			
			<h3>Combined comment counts aren't working on my site.</h3>
			<p>The combined comment count is passed through WordPress' <span class="code">get_comments_number()</span> function.</p>

      <p>If you're using a custom theme, you may have to modify your <strong>comments.php</strong> file (located inside your theme's directory) to include a call to <span class="code">get_comments_number()</span> where your comments are being listed.</p>
			
			<h3>Can I see the names and profile pictures of the people who Like a post?</h3>
			<p>Facebook only allows you to see the names and pictures of people that you're friends with.</p>
			
			<p>If 100 people Like your post, but only 5 of them are your friends, you'll only see the names and pictures of those 5 people. The others will appear as <strong>"...and 95 others like this."</strong></p>

			<h3>I don't see the anonymous posting form when I'm not logged into Facebook.</h3>
			<p>You can enable anonymous comments as follows:</p>
			
			<ul>
				<li>Click the <strong>Administer Comments</strong> link under the commenting box</li>
				<li>Select the <strong>Yes</strong> radio button next to <strong>Allow Anonymous Comments</strong></li>
				<li>Click the <strong>Save Changes</strong> button</li>
			</ul>
			
			<h3>How do I add a margin around the comments?</h3>
			<p>Add the following to your <strong>Container Styles</strong> on the settings page: <span class="code">margin: 20px;</span></p>
			
			<h3>Why aren't all of the profile pics under the Like button displayed?</h3>
			<p>Facebook only displays profile pics for people with whom you're friends.</p>
			
			<h3>Can I display the comments on my homepage?</h3>
			<p>While some people have claimed success in this endeavor, it is not a currently supported feature of the plugin. I may add this functionality at a later time.</p>
			
			<h3>I'm receiving a <em>Database Down</em> error when I try to post a new comment. How do I fix this?</h3>
			<p>Try disabling any other Facebook-related plugins running on your site. They often cause conflicts that disrupt the communication between the comments and Facebook's servers.</p>
			
			<h3>How do I manually insert the Facebook comments in my theme?</h3>
			<p>Simply add the following code where you'd like the comments to show up: <span class="code">&lt;?php if (function_exists('facebook_comments')) facebook_comments(); ?&gt;</span></p>
			<p>Note that you'll still need a valid Facebook application ID and a unique XID for the comments to show up. Also, since the post ID is appended to the XID, the comments will still be unique for each page (so you can't use them as a shoutbox in your sidebar).</p>
			
			<a name="comment_placement"></a><h3>Can I have the Facebook comments show up <em>after</em> the WordPress comments?</h3>
			<ul>
				<li>From your WordPress Dashboard, go to <strong>Appearance -> Editor</strong></li>
				<li>Select the <strong>Single Post (single.php)</strong> template from the list on the right-hand side</li>
				<li>Insert the following code somewhere between <span class="code">&lt;?php comments_template(); ?&gt;</span> and <span class="code">&lt;?php endwhile; else: ?&gt;</span>: <span class="code">&lt;?php if (function_exists('facebook_comments')) facebook_comments(); ?&gt;</span></li>
				<li>Example:</li>
				<span class="code">
					...<br />
					&lt;div id="commentsContainer"&gt;<br />
					&nbsp;&nbsp;&lt;?php comments_template(); ?&gt;<br />
					&lt;/div&gt;<br />
					&lt;?php if (function_exists('facebook_comments')) facebook_comments(); ?&gt;<br />
					&lt;?php endwhile; else: ?&gt;<br />
					...
				</span>
			</ul>
			
			<a name="xid"></a><h3>What's an XID and why do I need one?</h3>
			<p>Every set of Facebook comments requires a unique XID so Facebook can keep track of which comments belong to which pages. This plugin takes your XID (which was randomly generated when you activated the plugin) and appends <span class="code">_post&lt;postId&gt;</span> to it, thereby ensuring a unique XID for each post.</p>
			<p>XIDs are maintained when you upgrade this plugin.</p>
			<p>Note that if you change the post ID manually, your Facebook comments will no longer show up because for that particular post because that also causes your XID to change.</p>
			
			<h3>The <em>Hide WordPress comments</em> feature isn't working.</h3>
			<p>Certain themes may name the <span class="code">&lt;div&gt;</span> element containing the WordPress comments differently. This plugin simply uses CSS to hide the following <span class="code">&lt;div&gt;</span> elements:</p>
			
			<ul>
				<li><span class="code">#respond</span></li>
				<li><span class="code">#commentform</span></li>
				<li><span class="code">#addcomment</span></li>
				<li><span class="code">.entry-comments</span></li>
			</ul>
			
			<p>If your WordPress comments aren't being hidden, you may need to add a new ID or class to <strong>&lt;plugin_dir&gt;/css/facebook-comments-hidewpcomments.css</strong> file.</p>
			
			<h3>The comments aren't appearing in Internet Explorer (but they work in other browsers).</h3>
			<p>Ensure the <strong>Include Facebook FBML reference</strong> and <strong>Include OpenGraph reference</strong> options are checked off on the settings page.</p>
			<p>If the comments <em>still</em> aren't appearing in IE, open up your theme's <strong>header.php</strong> file and add the following attributes to the <span class="code">&lt;html&gt;</span> tag: <span class="code">xmlns:fb="http://www.facebook.com/2008/fbml" xmlns:og="http://opengraphprotocol.org/schema/"</span></p>
			
			<h3>Can I send users to a landing page instead of to the page a comment was made on?</h3>
			<p>This feature has been requested a few times and will show up in a future release.</p>
			
			<h3>Can I share comment streams between my Facebook fanpage and my WordPress blog?</h3>
			<p>This feature has been requested several times but hasn't been implemented yet. (You can try the <a href="http://wordbooker.tty.org.uk/">WordBooker</a> plugin if you need this functionality.)</p>
			
			<h3>Why do my comments take a few seconds to show up?</h3>
			<p>The Facebook comments widget has to query Facebook's servers to retrieve the appropriate comments. This can take up to 10 seconds. IF they still haven't shown up after that time, refresh the page.</p>
			
			<!-- How to Install and Setup -->
			<br class="clear" />
			<a name="install"></a><h2 class="topMarginSmall">How to Install and Setup<a href="#top">&uarr;Top</a></h2>
			
			<span class="number">1.</span>
			<span class="instruction"><a href="http://wordpress.org/extend/plugins/facebook-comments-for-wordpress/">Download the plugin</a> and unzip it to <span class="code">&lt;wordpress&gt;/wp-content/plugins/</span>.</span>
			
			<span class="number clear">2.</span>
			<span class="instruction">From your WordPress Dashboard, go to the <strong>Plugins</strong> section.</span>
			
			<span class="number clear">3.</span>
			<span class="instruction">Find the <strong>Facebook Comments for WordPress</strong> row and click the <strong>Activate</strong> link.</span>
			<img src="_images/activate.png" alt="" width="715" height="68" class="center clear" />
			<p class="note">Depending on the number of posts on your site, activation may take a moment because the plugin is caching all of your comment counts.</p>
			
			<span class="number clear">4.</span>
			<span class="instruction">Add the <a href="http://www.facebook.com/developers/">Facebook Developer application</a> to your Facebook account.</span>
			
			<span class="number clear">5.</span>
			<span class="instruction">Click the <strong>+ Set Up New App</strong> button.</span>
			<img src="_images/fbapp1.png" alt="" width="764" height="41" class="center clear" />
			
			<span class="number clear">6.</span>
			<span class="instruction">Enter an <strong>Application Name</strong> (the name of your website) and <strong>agree to the terms</strong>.</span>
			<img src="_images/fbapp2.png" alt="" width="691" height="199" class="center clear" />
			
			<span class="number clear">7.</span>
			<span class="instruction">Click on the <strong>Website tab</strong> and copy the <strong>Application ID</strong> and <strong>Application Secret</strong> from the Settings page.</span>
			<img src="_images/fbapp3.png" alt="" width="691" height="83" class="center clear" />
			
			<span class="number clear">8.</span>
			<span class="instruction">From your WordPress Dashboard, go to the <strong>Facebook Comments</strong> section under <strong>Settings</strong>.</span>
			<img src="_images/settings_menu.png" alt="" width="145" height="229" class="center clear" />
			
			<span class="number clear">9.</span>
			<span class="instruction">Enter your <strong>Facebook application ID</strong> and <strong>application secret</strong> in the first two textboxes. Adjust options if needed.</span>
			<img src="_images/screen_options.png" alt="" width="600" height="407" class="center clear" />
			
			<!-- How to Remove -->
			<br class="clear" />
			<a name="remove"></a><h2 class="topMargin">How to Remove<a href="#top">&uarr;Top</a></h2>
			
			<span class="number">1.</span>
			<span class="instruction">From your WordPress Dashboard, go to the <strong>Plugins</strong> section.</span>
			
			<span class="number clear">2.</span>
			<span class="instruction">Find the <strong>Facebook Comments for WordPress</strong> row and click the <strong>Deactivate</strong> link.</span>
			<img src="_images/deactivate.png" alt="" width="715" height="68" class="center clear" />
			
			<!-- Contact the Author -->
			<br class="clear" />
			<a name="contact"></a><h2 class="topMargin">Contact the Author<a href="#top">&uarr;Top</a></h2>
			
			<span class="instruction indent">You can get in touch with me via <strong><a href="mailto:thinkswan@gmail.com">email</a></strong>, <strong><a href="http://facebook.com/thinkswan">Facebook</a></strong>, <strong><a href="http://twitter.com/thinkswan">Twitter</a></strong> or the <strong><a href="http://grahamswan.com/#contact">contact form</a></strong> on my website. If you're requesting assistance, <strong><em>please include a link to a page where the plugin is currently enabled in your message</em></strong>.</span>
			
			<!-- Donate -->
			<br class="clear" />
			<a name="donate"></a><h2 class="topMargin">Donate (Buy Graham A Beer!)<a href="#top">&uarr;Top</a></h2>
			
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post" id="paypal">
					<input type="hidden" name="cmd" value="_xclick" />
					<input type="hidden" name="business" value="thinkswan@gmail.com" />
					<input type="hidden" name="item_name" value="Donation to Facebook Comments for WordPress plugin" />
					<input type="hidden" name="item_number" value="0" />
					<input type="hidden" name="notify_url" value="" />
					<input type="hidden" name="no_shipping" value="1" />
					<input type="hidden" name="return" value="http://grahamswan.com/facebook-comments/" />
					<input type="hidden" name="no_note" value="1" />
					<input type="hidden" name="tax" value="0" />
					<input type="hidden" name="bn" value="PP-DonationsBF" />
					<input type="hidden" name="on0" value="Website" />
					
					Currency:<br />
					<select id="currency_code" name="currency_code">
						<option value="USD">U.S. Dollars</option>
						<option value="AUD">Australian Dollars</option>
						<option value="CAD">Canadian Dollars</option>
						<option value="EUR">Euros</option>
						<option value="GBP">Pounds Sterling</option>
						<option value="JPY">Yen</option>
					</select><br />

					Amount:<br />
					<input type="text" name="amount" size="16" title="The amount you wish to donate" value="10.00" /><br />
				
					<input class="ppimg donateButton" type="image" src="https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif" name="submit" style="border:0;" alt="Make a donation" />
			</form>
			
			<span class="instruction donate">Please consider donating towards future development of this plugin!</span>
			
			<div class="clear"></div>
		</div>
		
		<img src="_images/bottom.png" alt="" width="619" height="55" class="floatLeft" />
		<a href="http://grahamswan.com/"><img src="_images/grahamswan.png" alt="" width="284" height="55" title="Visit the author's website" class="floatRight tooltip" /></a>
	
	</div>

<!-- Google Analytics Code -->
<script type="text/javascript">
	var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
	document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>

<script type="text/javascript">
	try {
		var pageTracker = _gat._getTracker("UA-10936599-11");
		pageTracker._trackPageview();
	} catch(err) {}
</script>

</body>

</html>
