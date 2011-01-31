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
			<div id="navbar">
				<a href="#what">What Is It?</a>
				<a href="#demo">Live Demo</a>
				<a href="#screenshots">Screenshots</a>
				<a href="#install">How to Install</a>
				<a href="#remove">How to Remove</a>
				<a href="#contact">Contact</a>
				<a href="#donate">Donate</a>
				<a href="http://wordpress.org/extend/plugins/facebook-comments-for-wordpress/">WordPress.org</a>
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
			<strong>&raquo;</strong> Insert the comments anywhere on your site</p>	
			
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
			
			<!-- How to Install and Setup -->
			<br class="clear" />
			<a name="install"></a><h2 class="topMargin">How to Install and Setup<a href="#top">&uarr;Top</a></h2>
			
			<span class="number">1.</span>
			<span class="instruction"><a href="http://wordpress.org/extend/plugins/facebook-comments-for-wordpress/">Download the plugin</a> and unzip it to <pre>&lt;wordpress&gt;/wp-content/plugins/</pre>.</span>
			
			<span class="number clear">2.</span>
			<span class="instruction">From your WordPress Dashboard, go to the <strong>Plugins</strong> section.</span>
			
			<span class="number clear">3.</span>
			<span class="instruction">Find the <strong>Facebook Comments for WordPress</strong> row and click the <strong>Activate</strong> link.</span>
			<img src="_images/activate.png" alt="" width="715" height="68" class="center clear" />
			
			<span class="number clear">4.</span>
			<span class="instruction">Add the <a href="http://www.facebook.com/developers/">Facebook Developer application</a> to your Facebook account.</span>
			
			<span class="number clear">5.</span>
			<span class="instruction">Click the <strong>+ Set Up New Application</strong> button.</span>
			<img src="_images/fbapp1.png" alt="" width="764" height="41" class="center clear" />
			
			<span class="number clear">6.</span>
			<span class="instruction">Enter an <strong>Application Name</strong> (the name of your website) and <strong>agree to the terms</strong>.</span>
			<img src="_images/fbapp2.png" alt="" width="691" height="199" class="center clear" />
			
			<span class="number clear">7.</span>
			<span class="instruction">Copy the <strong>Application ID</strong> from the Settings page that comes up.</span>
			<img src="_images/fbapp3.png" alt="" width="691" height="166" class="center clear" />
			
			<span class="number clear">8.</span>
			<span class="instruction">From your WordPress Dashboard, go to the <strong>Facebook Comments</strong> section under <strong>Settings</strong>.</span>
			<img src="_images/settings_menu.png" alt="" width="145" height="229" class="center clear" />
			
			<span class="number clear">9.</span>
			<span class="instruction">Enter your <strong>Facebook application ID</strong> in the first textbox. Adjust the styles and other options if needed.</span>
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
			
			<span class="instruction indent">You can get in touch with me via <strong><a href="mailto:thinkswan@gmail.com">email</a></strong>, <strong><a href="http://facebook.com/thinkswan">Facebook</a></strong>, <strong><a href="http://twitter.com/thinkswan">Twitter</a></strong> or the <strong><a href="http://grahamswan.com/#contact">contact form</a></strong> on my website.</span>
			
			<!-- Donate -->
			<br class="clear" />
			<a name="donate"></a><h2 class="topMargin">Donate<a href="#top">&uarr;Top</a></h2>
			
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
				<input type="hidden" name="cmd" value="_s-xclick">
				<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----">
				<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!" class="donateButton">
				<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
			</form>
			
			<span class="instruction donate">Please consider making a contribution towards future development of this plugin.</span>
			
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
