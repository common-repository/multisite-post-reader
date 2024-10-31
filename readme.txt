=== Multisite Post Reader ===

Contributors: Rick Hellewell
Donate link: http://cellarweb.com/wordpress-plugins/
Tags: Multisite Post Reader
Requires at least: 4.6
PHP Version: 7.2
Tested up to: 6.2
Version: 3.02
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Use shortcodes on a page/post to display/edit all posts from all multisite subsites. 

== Description ==

Multisite Post Reader allows you to use a shortcode on a page/post to display all posts from all sites in a multisite system. This allows you (as the SuperAdmin on network sites, or Admin on non-network sites) to monitor all posts on your multi-site system. Although meant for multisite systems by creating a page/post on the 'master' site, it will also work on standalone sites. You could use it to display all posts for visitors. It will even work in a widget (although you would want to use some of the optional parameters to limit the post count and post length).

If you are the SuperAdmin of the multisite, an 'edit' link will be shown on each post; shift-click to open in a new window/tab.

A "Read more" link is provided for all posts.

Each post has a clickable title, and also shows the date of the post.

== Installation ==

1. Install via the Add Plugin page. (On multisites, use the Network Admin Plugin page.) Or download the zip file, uncompress, then upload to `/wp-content/plugins/` directory. Or download, then upload/install via the Add Plugin page.

1. Activate the plugin through the 'Plugins' menu in WordPress.

1. Usage information in Settings, 'Multisite Post Reader Info/Usage'.

== Frequently Asked Questions ==

= What is the shortcodes used? =

Use the *[mpr_display]* shortcode to display all subsite posts on a post/page. 

= Where do I use the shortcodes? = 

Just place the *[mpr_display*] shortcode on a post/page.

= Will it work in a text widget? = 

Yes. Although you might want to limit the number of words and posts displayed, so you don't have a giant widget area. (See below and the Settings/Info screen for parameters info.)

= How are the posts displayed? = 

Each post title and date/time are shown, plus the post content. No CSS is used, so it will use your theme's post/page style. Look at the screenshot for an example.

= Will this work with any theme? =

Yes. We don't use any CSS (other than some bolding). Your theme gets to do all of the CSS stuff. Version 2.30 added CSS classes to all displayed post elements, so you can add CSS as needed. See changelog for CSS names.

= Are there any settings? = 

Nope. The 'Info/Usage' (Settings) screen just contains information on the plugin, and the available parameters (word count, post count, last x days, showing all posts, etc.).

= What are there optional parameters? =

This is a list of available optional parameters. Note the default values if the parameter is not used. All available parameters are shown on the Settings/Info page. Note that some parameters do not need a value, if specified, the value is 'true' or enabled.

	* items=x				show last x items (default = all items)
	* days=x				show last x days (default = all days)
	* datebefore=YYYYMMDD	show only items before the date (note required format of date value). Overridden by the 'days' parameter.
	* dateafter=YYYYMMDD		show only items after the dsate (note required format of date value). Overridden by the 'days' parameter.
	* nodate=yes			don't show the date stamp (default = no))
	* words=x				show the post extract: the 'manual' extract you entered in the post, or the automatic extract. (default = all post content)
	* extract				show the post extract: the 'manual' extract you entered in the post, or the automatic extract.  (default = all post content)
	* showall			show all posts (drafts, published) (default = only published)
	* showsiteinfo		do not show subsite info (only post) (default = yes)
	* disableheading=yes	do not show selection heading (default = no)
	* showempty 			do not show subsites with no results (default = yes). Note: will also suppress subsite info for a subsite without results.
	* showdivider 		do not show horizontal rule between posts (default = yes)
	* includesites=1,3,5	only include the indicated site id numbers (default = all subsites). The list of subsites to include must be separated by commas. 
	* excludesites=1,3,5	only exclude the indicated site id numbers (default = all subsites). The list of subsites to exclude must be separated by commas. 
	Note: you can use the includesites and excludesites together; the includesites list is processed first, then the sites in the excludesites list are removed.
	* debug 				Shows the SQL query used, and the number of records found by the query. Normally for development only.
	* showsql				Shows the SQL statement used to get the data. Normally for development only.
	* category='one, two, three'	only include categories 'one', 'two', and 'three'. These are category names, not IDs, and are separated by commas and all categories are enclosed with quotes.
	* type='x,y,z'			specify post type (separated by comma) (default = all published posts)
	* tag='x,y,z'			specify tag names (separated by comma) (default = all)

The available parameters are also shown on the Settings screen. We don't recommend using the includesites and excludesites parameter at the same time; weird things happen.

= What is an example of using optional parameters? = 

Here's an example:

    [mpr_display  items=4   days=45 showall  ]
	
This will show only the last 4 items (newest are always first) of entries from the last 45 days. If there are more than 4 items in the last 45 days, only 4 are shown. It will also show all items: draft, published, etc. You may want to limit the public use of the 'showall' parameter, so your non-published items will not be shown.

= Can I limit the number of posts displayed, and show the last 6 days? = 

Yes. Just use a shortcode similar to *[mpr_display days=6 items=10]*. These options will be shown above the posts: 'Showing last 6 days, last 10 posts. See the plugin's Info/Usage page in the Admin Settings menu for all the available parameters.

= What about CSS styles for the content output? = 

Version 1.20 adds a <div class="mpr_content"> around each extracted posts' content, including title, date, and content. You can add your own CSS for that class to style the output content.

Version 2.30 adds a 'class' to all output elements. The settings screen details the class names used. No CSS is supplied for the classes; you can supply your own via theme Customization, Additional CSS.

= Are there known issues? = 

Earlier versions did not plut the shortcode content in the content where the shortcode occurred. This would cause the shortcode content to always appear at the top of the page/post. Version 1.21 fixed that.

Prior versions also didn't play nicely with PHP 8.x, causing excessive warning messages in the error.log. That issue has been resolved.

= What if I have problems or suggestions? =

Just contact us via the plugin's <a href='https://wordpress.org/support/plugin/multisite-post-reader/'>Support page</a>. Or via www.CellarWeb.com . 

= Do you have other plugins? = 

Yes! 
* **Simple GDPR** : a simple popup message added for GDPR compliance. Will create a generic Privacy page that can optionally be added as a link in the page footer. Also does server-side Google Analytics (with uour GA code) so that visitors with ad-blocking will be tracked.

* **Multisite Media Display** : shows all media from all subsites. SuperAdmins can click on a picture to edit it. Great for ensuring all media conforms to your site's standards.

* **FormSpammerTrap for Comments** : enhances comment forms so that bots can't spam your comments. Uses a more clever technique than just hidden fields or captchas or other things that don't always work. Also lets you change the text/headings of the comment form. (We also have a free standalone version; take a look at www.FormSpammerTrap.com (that's the page that comment bots will see, but also contains all the info about the 'trap').

* **FormSpammerTrap for Contact Form 7** : adds our FormSpammerTrap technique to Contact Form 7 forms with a simple shortcode.

* **URL Smasher** : automatically shortens URLs on all URLs in pages/posts.

* **AmazoLinkenator** : adds your Amazon Affiliate ID to any Amazon product link in pages/posts/comments. It's your site, so use your Amazon Affiliate ID. 

All plugins are free and full-functioned. No premium features. Just search for them on the Add Plugins page.

== Screenshots ==

1. An example display of posts from a multisite installation.  Shows the first site's posts, along with the selection criteria on top. The edit icon is only visible to super-admins. 

== Changelog ==

= 3.02 (22 Mar 2023) =
* Fixed PHP warning if the 'items' attribute is specified.

= 3.01 (20 Mar 2023) =
* Fixed improper conversion of string to number.

= 3.00 (14 Mar 2023) (Happy 'Pi Day') =
* Major changes to how shortcode attributes are processed for more efficiency, and compatibility with PHP 8.x .
* THe 'debug' option now show message if no records found, plus a list of all shortcode attributes; usually for development only.
* A new 'showsql' option will show SQL query and record count before each subsite; usually for development only.
* Note that most attributes do not require a value; specifying the attribute will enable that option.
* Note that attributes that have multiple values separated by commas should have the values enclosed in single quotes.
* Note that there is minimal formatting of the output, but CSS classes are used on output. See the settings screen for those CSS class names. Add your changes to those CSS rules to your theme.
* Changed the Settings page documentation of optional parameter.
* Fixed an error with the version number shown on the Settings screen.
* Minimimum PHP changed to 7.2 .
* Adjusted code to remove multiple warnings with PHP 8.x (undeclared variables and array elements) that were cluttering up the error log.
* Tested on WP 6.1 .

= 2.41 (15 Aug 2019) = 
* added documentation to show you can select custom post types. No code changes, just show that option in the plugin information page. (Thanks to 'Jason' for the alert. In my defense, that option was detailed in this readme file.)

= 2.40 (7 July 2019) =
* changed all references to array elements to include the quote character in the array element name; required by PHP 7.x (caused an ' Use of undefined constant ' warning message, although the program still works)

= 2.30 (4 Jun 2019) = 
* added the 'showdate=no' option to suppress the post datestamp on output. Defaults to yes (to show date). (By request from user.)
* added CSS classes to all output items. The Settings/Info screen has details on the CSS class names.

= 2.21 (31 Oct 2018) = 
* Bug fix: missing global for $mpr_version in mpr_shortcodes_init() function, only showed the error 
	if you used the debug parameter. (Thanks 'Roman75' !)
	
= 2.20 (26 Jul 2018) = 
* Bug fixed: the 'includesites/excludesites' parameters weren't working properly (possibly at all). Reworked the code to properly process those parameters. (Thanks to @daveask42 for the alert - and patience while we figured this one out.)
* Added listing the include/exclude sites in the 'Showing' heading of the page output.
* If debug parameter used, the shortcode's parameter list is displayed at the top of the output.
* The heading of each site's output now includes a clickable link to the site; opens in a new window/tab.
* Minor changes to the heading text that shows the parameters used.
* Fixed a missing closing 'li' tag in the Settings page.
* Added external style sheet to Settings page; fixed some mis-named CSS items.
* Changes to the readme to allow both includesites/excludesites to be used. If both are specified, the includesites list is processed first, then the excludesites list.
* Updated the list of our other plugins in the readme.
* Minor text changed as needed in the Settings page. 
* Added a sidebar list of our other plugins on the Settings page.

= 2.12 (17 Sep 2017) = 
* fixed bug where 'none found' would display if no posts found even if the 'showempty=no' parameter specified. (Another one for Lynn D.)

= 2.11 (17 Sep 2017) = 
* fixed bug that only displayed site 1 info. (Silly extra quotes...) A genuine "SAF" (Smack Against Forehed) error. (Thanks to Lynn D for pointing this out.)

= 2.10 (15 Sep 2017) = 
* New parameter: category = 'one, two, three' will only include those posts with those category names.
* Edit icon will appear only if admin-level user views the results page.
* Removed some unneeded code.

= 2.01 (30 Aug 2017) =
* New parameter: debug=yes . Shows the SQL query used, plus the number of records found by the query. Useful when testing when you get unexpected results.
* Removed code no longer needed for WP < version 4.6. Function wp_get_sites is deprecated as of version 4.6; does not work in 4.81. No longer needed that code block since plugin now requires and checks for WP 4.6 minimum version. 
 
= 2.00 (29 Aug 2017)= 
* Requires at least WP 4.6, will not activate on prior versions. This is due deprecated functions for getting an array of sites.
* check for WP 4.6 on activation

= 1.23 (10 Aug 2017) = 
* fixed function that might cause errors on some systems depending on error settings.

= 1.22 )(10 Aug 2017) = 
* Fixed missing close parenthesis after the post date
* changed the priority of the plugin to '999' from the default of '10' to allow the shortcode processing after other things.

= 1.21 (9 Aug 2017) = 
* Fixed the problem of the shortcode content always appearing at the top of the post/page. Now the shortcode content appears in the spot where there shortcode is placed in the content.
* New parameter to specify sites to include: includesites="1,3,5"	only include the indicated site id numbers (default = all subsites). The list of subsites to include must be separated by commas.
* New parmeter to exclude sites: excludesites=3,6 . The list of subsites to include must be separated by commas.
* Note that includesites parameter overrides any excludesites parameter.
* Added a *div class = "mpr_header"* for the area above posts that shows selection criteria (if enabled) to allow user CSS styling of that text area.
* Additional text on the Settings screen for new parameters; also some spelling corrections.

= 1.20 (8 Aug 2017) = 

* added additional parameter (showdivider=no) to not show the horizontal rule between posts.
* added a *div class = "mpr_output"* around the post output (including post title and date) to allow user CSS styling of post content.

= 1.11(20 Feb 2017) = 

* added additional parameters per request; here's all of the parameters:
* *items=x*				show last x items (default = all items)
* *days=x*				show last x days (default = all days)
* *words=x*				show first x words (extracts) (default = all post content)
* *showall=yes*			show all posts (drafts, published) (default = only published)
* *showsiteinfo=no*		do not show subsite info (only post) (default = yes)
* *disableheading=yes*	do not show selection heading (default = no)
* *showempty=no*			do not show subsites with no results (default = yes). Note: will also suppress subsite info for a subsite without results.

* some code efficiencies (like converting all parameter values to lowercase for simpler test)

= 1.10 (14 Feb 2017)  (not released; see version 1.11) = 

* added parameter (showempty=no; default is  yes) to disable showing of subsites that have no entries according to other parameters used (user suggestion)
* added parameter 'disableheading' (default is yes) to disable showing the selection parameters
* added parameter 'showsiteinfo' (default is yes) to disable showing of site info (site name and path) above each sub-sites grouping of posts

= 1.09 (10 Feb 2017) = 

* ensured that shortcode parameters array have values if not speficied; removes error.log message if error reporting is on at site 

= 1.08 (8 Feb 2017) =

* fixed bug with page_init function call - not needed

= 1.07 (25 Jan 2017) =

* corrected the settings/info screen to remove statement about shortcode parameters needing to be in lower case. Doesn't matter, since standard WP functions always convert parameter names and values to lower case.
* added sanitation of the shortcode parameter values. (Parameter names are sanitized by WP functions.)
* fixed links to review and support pages on the settings/info page.
* on the settings/info page, clarified that non-network admins will see the Edit icon/link.
* removed unused functions, some minor code cleanup

= 1.06 (24 Jan 2017) = 

* moved the "Showing..." message to the top, rather than repeating it for each sub-site
* the post status message ("Status = ..") was italicized to make it easier to see
* fixed bug where the 'word' parameter wasn't truncating the post if used
* removed a function that wasn't needed.
* minor clarification of information on the info/usage screen
* some minor code efficiencies

= 1.05 (24 Jan 2017) = 

* added [showall=yes] parameter to show all posts, not just published posts. The status of each post will be shown (publish, future, etc). Default is to just show Published posts.
* corrections to plugin's Info/Usage screen.
* minor changes to the readme file.

= 1.04 (19 Jan 2017) = 

* added an empty H2 tag just before the settings/info screen header for any WP Admin status messages, which otherwise might overwrite the settings/info text.
* fixed the 'edit' link (which only super-admins see) to open the editor in a new tab/window (prior versions didn't open in new window/tab)
* added the 'edit' dash-icon (looks like a stubby pencil) to the edit link (visible for super-admins only), replacing a text link
* verified OK for WP 4.71
* updated the screenshot to show the edit icon
* minor fix to readme formatting

= 1.03 (12 Jan 2017, 13 Jan 2017) = 

* fixed repository problem (I should carefully read the part where it tells me where to put the distribution files...)
* tested for WP 4.71

= 1.02 (9 Jan 2017) = 

* the 1.01 update wasn't showing on WP Plugins site. Updated and re-submitted this version number to hopefully fix that.

= 1.01 (6 Jan 2017) =

* fixed strange install bug by upping the version (no code changes)

= 1.00 (4 Jan 2017) = 

* Initial Release 

== Upgrade Notice ==

See Changelog for new features/bug fixes.


