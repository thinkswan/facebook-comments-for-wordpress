=== Facebook Comments for WordPress ===
Contributors: thinkswan, AlmogBaku, sboddez
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=7QKHFXCNDTA5U&lc=CA&item_name=Graham%20Swan%20%28Facebook%20Comments%20for%20WordPress%20plugin%29&item_number=thinkswan&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donate_LG%2egif%3aNonHosted
Tags: comments, facebook, social graph, posts, pages, discussion, facebook comments
Requires at least: 2.9.2
Tested up to: 3.0.5
Stable tag: 2.1.2

Allows your visitors to comment on posts using their Facebook profile. Supports custom styles, notifications, combined comment counts, etc.

== Description ==

This plugin integrates the Facebook commenting system right into your website. If a reader is logged into Facebook while
viewing any comment-enabled page or post, they'll be able to leave a comment using their Facebook profile. Non-Facebook
users can post anonymously with a valid email address.

Features:

* Styles can all be customized to fit your site's theme
* Number of comments displayed can be adjusted
* Option to post comments directly to a user's Facebook profile page
* Comments can be included on pages only, posts only or both
* Comments can be shown in chronological order or with the most recent comments first
* Facebook comments can be attached to WordPress comments or inserted manually anywhere in your theme
* WordPress comments can be hidden on pages/posts where Facebook comments are enabled
* Comment counts on pages/posts reflect both the Facebook and WordPress comments
* Email notifications can be sent whenever a comment is posted
* Like button can be hidden if required

== Installation ==

1. Unzip `facebook-comments-for-wordpress.2.1.2.zip` to your `/wp-content/plugins/` directory
2. Activate the plugin through the `Plugins` menu in WordPress (depending on the number of posts on your site, activation may take a moment because the plugin is caching all of your comment counts)
3. Setup the plugin options by using the `Facebook Comments` page (located under the `Settings` menu)

* Note that a `Facebook application ID` is required. For details on how to get one, including a screenshot walkthrough,
  check out http://grahamswan.com/facebook-comments/#install
* In order to keep your comments through upgrades, you **must** set a unique `XID`. This `XID` will be maintained when you
  upgrade the plugin

== Frequently Asked Questions ==

If you need help, please refer to the official FAQ at http://grahamswan.com/facebook-comments/#faq.

== Changelog ==

= 2.1.2 =
* Bugfix: Pre-activation checks have been converted to warnings (if you receive a `Parse error` when activating, please ensure you're running PHP v5.0.0 or higher on your server)

= 2.1.1 =
* Bugfix: Replaced all `file_get_contents()` instances with cURL calls (since some web servers don't allow file fetching by URL for security reasons)
* Bugfix: Combined comment counts now work when comments are included manually (as long as the option is checked)
* The plugin now checks your PHP version (must be v5.0.0 or greater) and ensures you have the cURL extension installed before activating

= 2.1 =
* Bugfix: Removed the option to set widths as a percentage because the JavaScript was breaking the plugin for almost everyone (no more multiple inclusions)
* Bugfix: Switched from PHP's default mail() function to WordPress' built-in wp_mail() function for sending email notifications
* Bugfix: Removed JavaScript logging to ensure the plugin works in Firefox and IE again (these browsers do not have `console.log` defined unless Firebug is installed)
* Your current XID will now be emailed to you when you deactivate the plugin (this allows you to retrieve your site's comments should you ever activate the plugin again)

= 2.0 =
* Option: Send email notifications to the site admin whenever a Facebook comment is posted
* Option: Ability to load the JavaScript SDK the old way (for those of you who experienced issues with v1.6)
* Option: Ability to set the comment box width to `100%`
* Bugfix: Whitespace is now trimmed from the application ID, the application secret, all CSS styles and the XID to prevent loading issues
* Bugfix: Links on the plugin settings page have been updated to point to the correct information on the website now
* Bugfix: Cleaned up various parts of the code (no more PHP notices)
* Comment counts are now cached (no more slow load times on the main page). Depending on the number of posts you have on your site, it may take a few moments to activate the plugin because it retrieves the Facebook comment count for every post during activation for caching
* Added both PHP and JavaScript error logging to make troubleshooting easier
* Both a Facebook application ID **and** an application secret are required for the plugin to work now

= 1.6 =
* Comment inclusion code is now far more lightweight
* Facebook and WordPress comments are now counted together

= 1.5.2 =
* Bugfix: WordPress commenting form should now be properly hidden for most themes
* Bugfix: `type` attribute is now set in the script inclusion (so older browsers will render it properly)

= 1.5.1 =
* Bugfix: fixes the bug where hiding the WordPress comments caused errors in `foreach()` loops on certain themes
* Moves all stylesheets to `css/` folder and all images to `images/` folder for better organization

= 1.5 =
* Option: WordPress comments can be hidden on pages/posts where Facebook comments are enabled
* Option: Like button can be hidden
* Option: `Facebook Social Plugins` text and icon is hidden
* Option: custom stylesheet for darker websites can be included (as a result, ability to reference your own custom stylesheet was removed)
* Bugfix: comments now render properly in Internet Explorer (due to `FBML` reference)
* Added `title` and `url` attributes to the `<fb:comments>` tag so the Like button links to the correct page when clicked
* Facebook comments can now be linked to by appending `#facebook-comments` to the end of a post/page's URL
* Support for 100+ languages is now available (including Arabic, Hebrew, Spanish and all other requested languages)

= 1.4.1 =
* Bugfix: WordPress comments are no longer hidden when the Pages only or Posts only options are selected

= 1.4 =
* Option: include comments on pages only, posts only or both
* Tested and works properly with WordPress 3.0

= 1.3 =
* Bugfix: settings/XID are no longer lost when upgrading
* Bugfix: anonymous posting now works properly
* Option: allow user to hide the `Facebook comments:` title
* Added `Settings` link to plugin's action links on the `Plugins` page
* Redesigned settings page
* Refactored code to prepare for next release

= 1.2 =
* Bugfix: Facebook comments will be hidden on posts on which WordPress comments are disabled
* Bugfix: Facebook comments are retained through upgrades (you **must** set a XID to keep your comments)
* Feature: add Facebook comments anywhere in your theme by manually inserting `<?php if (function_exists('facebook_comments')) facebook_comments(); ?>` where you'd like them to show up
* Option: change `Facebook comments:` title to anything you want
* Option: allow user to reverse the order of the Facebook comments so they're in chronological order (like WordPress comments)
* Option: allow removal of the grey box behind the composer
* Option: allow use of external stylesheet to alter the appearance of the Facebook comments section
* Option: receive Facebook notifications whenever someone posts a comment
* Option: uncheck `Post comment to my Facebook profile` box by default
* Assorted code maintenance

= 1.1 =
* Fixed bug: plugin's settings are no longer reset/removed when activating/deactivating other plugins
* New option: ability to hide the Facebook comments box without having to deactivate the plugin (in case you want to keep
  your settings)
* Minor style changes

= 1.0 =
* Initial release

== Upgrade Notice ==

= 2.1.2 =
This update changes the pre-activation checks to notices to fix the activation issues some people were having. (If you receive a Parse error when activating, please ensure you're running PHP v5.0.0 or higher on your server.)

= 2.1.1 =
This update replaces all file_get_contents() instances with cURL calls. This should bring the plugin back to a healthy state for everyone who doesn't have file fetching by URL enabled on their web server (which was a surprising number of people). Combined comment counts now work when the comments are included manually as well.

= 2.1 =
This update fixes a bug that caused the plugin to break in Firefox, as well as a bug that caused the comments to be included multiple times on some themes. It also removes the width as a percentage feature because it crippled the plugin for nearly everyone.

= 2.0 =
This update introduces both comment count caching (no more slow load times on the main page) and email notifications whenever a Facebook comment is posted. It also includes an option to load the JavaScript SDK the old way (for those of you who experienced issues with v1.6) and an option to set the comment box width to 100%.

= 1.6 =
This update introduces the highly-anticipated combined comment counts feature.

= 1.5.2 =
This update fixes a bug where the WordPress commenting form couldn't be hidden.

= 1.5.1 =
This update fixes a bug where hiding the WordPress comments caused errors with `foreach()` loops.

= 1.5 =
This update provides options to hide the Like button and to hide the WordPress comments section on pages/posts
where Facebook comments are enabled. The comments also render properly in Internet Explorer now.

= 1.4.1 =
This update provides a simple bugfix where WordPress comments were being hidden if the Pages only or Posts only
option was selected.

= 1.4 =
This update ensures compatibility with WordPress 3.0, and also provides an option to include the comments on pages
only, posts only or both.

= 1.3 =
This update adds the option to remove the `Facebook comments:` title, fixes a bug where settings are lost, allows
anonymous posting and provides a brand new configuration page.

= 1.2 =
This update fixes a bug where the Facebook comments are not consistent across upgrades. Also provides new options.

= 1.1 =
This update fixes a critical bug where the plugin's settings are reset or removed every time any other plugin is
activated/deactivated. Also provides new options.

== Known Issues ==

For a short list of known issues, please refer to the official website at http://grahamswan.com/facebook-comments/#issues.

== Upcoming Features ==

For a list of upcoming features, please refer to the official website at http://grahamswan.com/facebook-comments/#upcoming.

== Screenshots ==

1. The Facebook commenting box, complete with comments.
2. Anonymous posting for users without a Facebook account.
3. Using a custom stylesheet.
4. The plugin settings page.
