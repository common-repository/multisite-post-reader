<?php

/*
Plugin Name: Multisite Post Reader
Plugin URI: http://cellarweb.com/wordpress-plugins/
Description: Shows posts from all subsites on a multisite via a shortcode used on pages/posts. SuperAdmins get an edit link. Optional parameters can limit number of posts and post length. Can be used for public pages.
Version: 3.02
Author: Rick Hellewell / CellarWeb.com
Tested up to: 6.2
Requires at least: 4.6
PHP Version: 7.23
Text Domain:
Author URI: http://CellarWeb.com
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */

/*
Copyright (c) 2016-2019 by Rick Hellewell and CellarWeb.com
All Rights Reserved

email: rhellewell@gmail.com

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

 */
// ----------------------------------------------------------------
// ----------------------------------------------------------------
define('MPR_VERSION', "3.02");
define('MPR_VERSION_DATE', "(22 Mar 2023)");

global $atts; // used for the shortcode parameters
if (!mpr_is_requirements_met()) {
	add_action('admin_init', 'mpr_disable_plugin');
	add_action('admin_notices', 'mpr_show_notice');
	add_action('network_admin_init', 'mpr_disable_plugin');
	add_action('network_admin_notices', 'mpr_show_notice');
	mpr_deregister();
	return;
}
// Add settings link on plugin page
function mpr_settings_link($links) {
	$settings_link = '<a href="options-general.php?page=mpr_settings" title="Multisite Post Reader">Multisite Post Reader Info/Usage</a>';
	array_unshift($links, $settings_link);
	return $links;
}

$plugin = plugin_basename(__FILE__);
add_filter("plugin_action_links_$plugin", 'mpr_settings_link');

//  build the class for all of this
class mpr_Settings_Page {
// start your engines!

	public function __construct() {
		add_action('admin_menu', array($this, 'mpr_add_plugin_page'));
	}

	// add options page

	public function mpr_add_plugin_page() {
		// This page will be under "Settings"
		add_options_page('Multisite Post Reader Info/Usage', 'Multisite Post Reader Info/Usage', 'manage_options', 'mpr_settings', array($this, 'mpr_create_admin_page'));
	}

	// options page callback

	public function mpr_create_admin_page() {

		// Set class property
		$this->options = get_option('mpr_options');
		?>

<div align='center' class = 'mpr_header'>
     <img src="<?php echo plugin_dir_url(__FILE__); ?>assets/banner-1000x200.jpg" width="95%"  alt="" class='mpr_shadow'>
    <p align='center'><b>Version:</b> <?php echo MPR_VERSION . " " . MPR_VERSION_DATE; ?></p>
</div>
<!--<div class = 'mpr_header'>
    <h1 align="center" >Multisite Post Reader</h1>
</div>-->
<div >
    <div class="mpr_options">
        <?php mpr_info_top();?>
    </div>
    <div class='mpr_sidebar'>
        <?php mpr_sidebar();?>
    </div>
</div>
<!-- not sure why this one is needed ... -->
<div class="mpr_footer">
    <?php mpr_footer();?>
</div>
<?php
echo '</div>';
	}

	// print the Section text

	public function mpr_print_section_info() {
		print '<h3><strong>Information about Multisite Post Reader from CellarWeb.com</strong></h3>';
	}
}
// end of the class stuff

if (is_admin()) {
	$my_settings_page = new mpr_Settings_Page();

	// ----------------------------------------------------------------------------
	// supporting functions
	// ----------------------------------------------------------------------------
	//  display the top info part of the page
	// ----------------------------------------------------------------------------
	function mpr_info_top() {

		?>
<p><strong>Multisite Post Reader</strong> allows you to use a <strong>[mpr_display]</strong> shortcode on a page/post to display all posts from all sites in a multisite system.  This allows you (as the network SuperAdmin or non-network Admin) to monitor all posts on your multi-site system. Although meant for multisite systems by creating a page/post on the 'master' site, it will also work on standalone sites. It can be used on public pages. No CSS styling is added, so the posts will display using your theme's styling. Shortcode could also be used in a widget, but you would want to use parameters to limit count and length of displayed posts.</p>
<p>Each post has a clickable title, and also shows the publish date of the post. A "Read more" link is provided for all posts excerpts. Super-admins will see an Edit icon, which opens a new window/tab to edit the post. Each grouping of posts has a clickable link to the subsite's home page.</p>
<h2>Shortcode Options</h2>
<p>There are shortcode options/parameters for (adjust the values for your needs):</p>
<ul style="list-style-type: disc; list-style-position: inside;padding-left:20px;">
    <li><strong>items=10</strong>&nbsp;&nbsp;&nbsp;show only the last 10 items (default all items, option used will be shown above each sites' posts group).</li>
    <li><strong>days=4</strong>&nbsp;&nbsp;&nbsp;show only the last 4 days (default all dates, option used will be shown above each sites' picture group).</li>
    <li><b>beforedate=YYYYMMDD</b> will select posts before the date. Note the required formatting for the date value. <i>Overridden if you select the 'days' parameter.</i></li>
    <li><b>afterdate=YYYYMMDD</b> will select posts after the date. Note the required formatting for the date value. <i>Overridden if you select the 'days' parameter.</i></li>
    <li><strong>showdate</strong>&nbsp;&nbsp;&nbsp;Suppress showing the date stamp of the post. (Default shows the datestamp.)</li>
    <li><strong>excerpt</strong>&nbsp;&nbsp;&nbsp;will show the post excerpt, using the current word count for excerpt. (default is the entire post). The previous <b>words</b> option now functions like <b>excerpt</b>.</li>
    <li><strong>showall</strong>&nbsp;&nbsp;&nbsp;show all posts, including drafts, scheduled, private; (default is  only published posts, option used will be shown above each sites' posts group). Each post will show it's current status after the post publish date. This allows you to see all types of posts, including scheduled posts.</li>
    <li><strong>showsiteinfo</strong>&nbsp;&nbsp;&nbsp;do not show subsite info (id, path) (default is to show the site info)</li>
    <li><strong>disableheading</strong>&nbsp;&nbsp;&nbsp;do not show the selection criteria heading (default is to show selection criteria)</li>
    <li><strong>showempty</strong>&nbsp;&nbsp;&nbsp;do not show subsites with no results (default=yes, will show 'none found' if no results for that subsite). Note that if a subsite does not have results, the subsite info (ID, path) will not be shown.</li>
    <li><strong>showdivider</strong>&nbsp;&nbsp;&nbsp;Show the horizontal rule between posts (default will not show horizontal rule).</li>
    <li><strong>includesites=1,3</strong>&nbsp;&nbsp;&nbsp;show only site with site_id #1 and #3 (default is all sites). Numbers are the site ID number. Separate multiple site id numbers with a comma; do not include quote characters. </li>
    <li><strong>excludesites=2,4</strong>&nbsp;&nbsp;&nbsp;do not show sites with site_id of #2 and #4 (default is show all sites). Separate multiple site id numbers with a comma; do not include quote characters.</li>
    <ul style="list-style-type: disc; list-style-position: inside;padding-left:22px;">
        <li>You can use both includesites/excludesites parameters. The includesites list is processed first, then the excludesites list is processed.</li>
    </ul>
    <li><strong>category='one, two, three'</strong>&nbsp;&nbsp;&nbsp;Only include the categories 'one', 'two', and 'three'. These are category <strong>names</strong> (slugs), not category ID numbers (as names are more likely to be the same across multisites, but category ID number might be different). Default is all categories. Separate categories with a comma, but include the quote character around all the category names. Note that any 'children' of a category will also be included for a specified category.</li>
<li><strong>type='x,y,z'</strong>&nbsp;&nbsp;&nbsp;Only include the post types indicated. Example: if you have a custom post type called 'product', then use type='product'. Separate multiple custom post type names with commas, and surround the post type names with a quote. Default is to only show 'posts'. </li>
    <li><strong>debug</strong>&nbsp;&nbsp;&nbsp;Debugging mode: shows the SQL query, plus the number of records found in the query. Will show all shortcode parameters at the top of the output page. Not normally used in production, but helpful when you get strange results.</li>
    <li><b>showsql</b>   Shows the SQL statement used to query the data. For development only.</li>
</ul>
<p>The parameters can be combined, as in <strong>[mpr_display days=4 items=10]</strong>. The optional parameters will be shown above each site's group of posts unless you use the <strong>disableheading=yes</strong> parameter. If a parameter has a non-alphanumeric character other than a comma (like spaces), enclose the parameters in quotes, as in <b>category='red apples, blue sky'</b>.</p>
<p>The individual post content is wrapped in a <strong>mpr_content</strong> CSS class, so you can add your own CSS to style the post content element. </p>
<hr />
<h2>CSS Classes Used</h2>
<p>CSS classes are used for the elements of the posts being output. You can use these class names in your theme's Additional CSS, or in your custom-written theme. The plugin does not add any inline CSS. The CSS rules have no elements added by the plugin; you get to style the elements in your theme.</p>
<ul style="list-style-type: disc; list-style-position: inside;padding-left:20px;">
<li><strong>mpr_content</strong>: used around the entire post, including header, content, etc.</li>
<li><strong>mpr_the_permalink</strong>: for the link to the post - the output of <strong>the_permalink()</strong>.</li>
<li><strong>mpr_post_date</strong>: the post date/time stamp. Output can be disabled with the <b>showdate</b> parameter (see above).</li>
<li><strong>mpr_the_title</strong>: the post title - the output of <strong>the_title()</strong>.</li>
<li><strong>mpr_get_the_content</strong>: the post text/content, including read-more - the output of <strong>get_the_content()</strong>.</li>
</ul>
<hr>
<p><strong>Tell us how the Multisite Post Reader plugin works for you - leave a <a href="https://wordpress.org/support/plugin/multisite-post-reader/reviews/" title="Multisite Post Reader Reviews" target="_blank" >review or rating</a> on our plugin page.&nbsp;&nbsp;&nbsp;<a href="https://wordpress.org/support/plugin/multisite-post-reader" title="Help or Questions" target="_blank">Get Help or Ask Questions here</a>.</strong></p>
<hr />
<?php
}

	// ----------------------------------------------------------------------------
	// ``end of admin area
	//here's the closing bracket for the is_admin thing
}
// ----------------------------------------------------------------------------
// register/deregister/uninstall hooks
register_activation_hook(__FILE__, 'mpr_register');
register_deactivation_hook(__FILE__, 'mpr_deregister');
register_uninstall_hook(__FILE__, 'mpr_uninstall');

// register/deregister/uninstall options (even though there aren't options)
function mpr_register() {
	return;
}

function mpr_deregister() {
	return;
}

function mpr_uninstall() {
	return;
}

//  ----------------------------------------------------------------------------
// set up shortcodes
function mpr_shortcodes_init() {
	add_shortcode('mpr_display', 'mpr_setup_sites');
	// get some CSS loaded for the settings page
	wp_register_style('MPR_namespace', plugins_url('/css/settings.css', __FILE__), array(), MPR_VERSION);
	wp_enqueue_style('MPR_namespace'); // gets the above css file in the proper spot
}

add_action('init', 'mpr_shortcodes_init', 999);

// ----------------------------------------------------------------------------
// here's where we do the work!
// ----------------------------------------------------------------------------
function mpr_setup_sites($atts = array()) {
	ob_start(); // to get the shortcode output in the middle of the content.
	// see https://wordpress.stackexchange.com/questions/47062/short-code-output-too-early
	// sanitize any parameters using the sanitize_text_field callback
	if (!is_array($atts)) {$atts = array();} // just in case
	if (!empty($atts)) {
		$atts = array_map('sanitize_text_field', $atts);
		$atts = array_map('strtolower', $atts);
		// set defaults for all $atts
		// look for attributes without values (see  https://wordpress.stackexchange.com/a/123073/29416
		//  - sets the value of that attribute as true if the attribute exists without a value
		foreach ($atts as $item => $value) {
			if ((strlen($value))) {
				$new_value = explode(",", $value);
			} else { $new_value = $value;}
			if (NULL == $value) {
				$new_value = true;
			}
			$atts[$item] = $new_value;
		}} // $atts not empty
	// now need to fix $atts[0] = option_name; this looks for attributes that are numbers
	// see  https://wordpress.stackexchange.com/a/123073/29416
	foreach ($atts as $attribute => $value) {
		// echo "2nd loop $attribute  with value of " . implode("",$value) . " <br>";
		if (is_int($attribute)) {
			$atts[implode("", $value)] = true;
			unset($atts[$attribute]); // gets rid of the numeric item
		}
	}
	$args = array();
	$heading            = array(); // for text to display if disableheading false (default)
	$atts['datebefore'] = (isset($atts['datebefore'])) ? explode(',', $atts['datebefore']) : array();
	if (count($atts['datebefore'])) {$args['before'] = array(
		$atts['datebefore'][0], // YYYY
		$atts['datebefore'][1], // MM
		$atts['datebefore'][2], // DD
	);
		$heading[]          = "Items before " . $atts['datebefore'][0] . "/" . $atts['datebefore'][1] . "/" . $atts['datebefore'][2] . "(YYYY/MM/DD)";
		$args['date_query'] = array(
			array(
				'year' => $atts['datebefore'][0],
				'month' => $atts['datebefore'][1],
				'day' => $atts['datebefore'][2],
			),
		);
	}

	$atts['dateafter'] = (isset($atts['dateafter'])) ? explode(',', $atts['dateafter']) : array();
	if (count($atts['dateafter'])) {$args['after'] = array(
		$atts['dateafter'][0], // YYYY
		$atts['dateafter'][1], // MM
		$atts['dateafter'][2], // DD
	);
		$heading[]          = "Items after " . $atts['dateafter'][0] . "/" . $atts['dateafter'][1] . "/" . $atts['dateafter'][2] . "(YYYY/MM/DD)";
		$args['date_query'] = array(
			array(
				'year' => $atts['dateafter'][0],
				'month' => $atts['dateafter'][1],
				'day' => $atts['dateafter'][2],
			),
		);
	}

	$atts['days'] = (isset($atts['days'])) ? $atts['days'] : 0;
	if ($atts['days'] > 0) {
		// get current date - days
		$newDate = date('Y-m-d', strtotime(' - ' . $atts['days'] . ' days'));
		// computer 'days' ago from current date
		// set that date string as the dateafter
		$args['after'] = $newdate;
		$heading[]     = "Including sites " . implode(", ", $atts['includesites']);
		if ((isset($atts['dateafter'])) OR (isset($atts['dateafter']))) {
			unset($args['date_query']);
			$heading[] = "(The 'days' option is overriding the 'datebefore' and 'dateafter' options.)";
		}
	}

// convert following to array output
	$atts['includesites'] = (isset($atts['includesites'])) ? $atts['includesites'] : array();
	if (count($atts['includesites']) > 0) {
		$heading[] = "Including sites " . implode(", ", $atts['includesites']);
	}

	$atts['excludesites'] = (isset($atts['excludesites'])) ? explode(",", $atts['excludesites']) : array();
	if (count($atts['excludesites']) > 0) {
		$heading[] = "Including sites " . implode(", ", $atts['excludesites']);
	}

	$atts['category'] = (isset($atts['category'])) ? $atts['category'] : array();
	if (count($atts['category'])) {
		$args['category_name'] = implode(",", $atts['category']);
		//$args['category_name'] =  "red";
	}

	$atts['type']      = (isset($atts['type'])) ? explode(",", $atts['type']) : "post";
	$atts['post_type'] = (isset($atts['post_type'])) ? explode(",", $atts['post_type']) : "any";
	// set all the atts to default or settings value
	$atts['items']          = (isset($atts['items'])) ? $atts['items'] : 0;
	$atts['words']          = (isset($atts['words'])) ? $atts['words'] : 0;
	$atts['excerpt']        = (isset($atts['excerpt'])) ? 1 : 0;
	$atts['showall']        = (isset($atts['showall'])) ? 1 : 0;
	$atts['showsiteinfo']   = (isset($atts['showsiteinfo'])) ? 1 : 0;
	$atts['disableheading'] = (isset($atts['disableheading'])) ? 1 : 0;
	$atts['showempty']      = (isset($atts['showempty'])) ? 1 : 0;
	$atts['showdivider']    = (isset($atts['showdivider'])) ? 1 : 0;
	$atts['showdate']       = (isset($atts['showdate'])) ? 1 : 0;
	$atts['debug']          = (isset($atts['debug'])) ? 1 : 0;
	$atts['category']       = (isset($atts['category'])) ? $atts['category'] : array();
	//  $atts['type']           = (isset($atts['type'])) ? $atts['type'] : 0;
	$atts['tag']     = (isset($atts['tag'])) ? $atts['tag'] : 0;
	$atts['nodate']  = (isset($atts['nodate'])) ? $atts['nodate'] : 0;
	$atts['showsql'] = (isset($atts['showsql'])) ? 1 : 0; // new in version 2.50
	if ($atts['debug'] == true) {
		echo "<strong>Debug:</strong> Shortcode Attributes array<br>";
		mpr_show_array($atts);
		echo "<hr>";
	}
	$args['post_type'] = $atts['type'];
	// process all sites
	mpr_get_sites_array($atts, $args, $heading); // get the sites array, and loop through them in that function
	// this will flush the output, putting shortcode content where it belongs
	//      don't ob_flush/etc anywhere else
	return ob_get_clean();
}

// --------------------------------------------------------------------------------
// ===============================================================================
//  functions to display all posts
// ===============================================================================
/*
Styles and code 'functionated' for displaying all posts files
adapted from http://alijafarian.com/responsive-image-grids-using-css/
 */
// --------------------------------------------------------------------------------
/*
- $atts     = shortcode attributes
- $args     = args for the wp_query object
- $heading  = text to show is 'disableheading' is set false (default is true)
 */
function mpr_get_sites_array($atts = array(), $args = array(), $heading = "") {
	global $posts; // need to ensure post data available to any called functions in here
	?>
<div class='mpr_heading'>
    <?php
if (!$atts['disableheading']) { // building and displaying heading text
		if ($atts['showempty']) {
			$atts['showempty'] = false;
			//    $heading[]         = "Subsites without entries not shown";
		}
	}
	?>
</div>
<?php
$subsites_object = get_sites();
	$subsites        = mpr_objectToArray($subsites_object);
	$subsites_copy   = array();
	// headings created and shown at top of all posts
	$heading = array();
	if ($atts['includesites']) {
		$heading[] = "Including subsites: " . implode(", ", $atts['includesites']);
		foreach ($subsites as $subsite) {
			$found_include = in_array($subsite['blog_id'], $atts['includesites']);
			if ($found_include) {
				$subsites_copy[] = $subsite; // add site
			}
		}
		$subsites = $subsites_copy;
	}
	if ($atts['excludesites']) {
		$heading[] = "Excluding subsites: " . implode(", ", $atts['excludesites']);
		foreach ($subsites as $subsite) {
			$found_exclude = in_array($subsite['blog_id'], $atts['excludesites']);
			// add if not excluded
			if (!$found_exclude) {
				$subsites_copy[] = $subsite; // add site
			}
		}
	}
	if (count($subsites_copy)) {
		$subsites = $subsites_copy;
	}

	if (isset($atts['showempty'])) {
		$heading[] = "Subsites without entries not shown";
	}
	if ($atts['items'] > 0) {
		$x = (is_array($atts['items'])) ? implode(", ", $atts['items']) : "All ";
		$heading[] = $x . " posts";
	}
	if ($atts['days'] > 0) {
		$heading[] = "Last " . $atts['days'] . " days";
	}
	if (($atts['words'] > 0) OR ($atts['excerpt'])) {
		$heading[] = "Showing the excerpt.";
	}
	if (isset($atts['category'])) {
		$heading[] = "Category: " . implode(", ", $atts['category']);
	}
	if ($atts['days']) {
		$daystring = $atts['days'] . " days ago";
	} // optional parameter
	/*     if ($atts['showall']) {
	$xpost_status = 'any';
	} else {
	$xpost_status = 'post';
	}*/
	// for post type
	if (!isset($args['post_type'])) {
		$args['post_type'] = 'post';
	}
	if ($atts['showall']) {
		$heading[]         = " All posts";
		$args['post_type'] = "any";
	}
	if ($atts['type']) {
		$heading[]         = 'Post Type = ' . $atts['type'];
		$args['post_type'] = $atts['type'];
	}
	/* not needed, previously set as default = post
	if ((!count($atts['type'])) AND (!$args['post_type'])) {
	$args['post_type'] = "post";
	}*/
	if ($atts['tag']) {
		$heading[] = 'Tag(s) = ' . $atts['tag'];
	}
	if (count($heading)) {
		if ($atts['showdivider']) {echo "<hr>";} else {echo "<br>";}
		foreach ($heading as $item) {
			echo " - " . $item . "<br>";
		}
	}

	foreach ($subsites as $subsite) {
		$subsite_id     = $subsite['blog_id'];
		$subsite_name   = get_blog_details($subsite_id)->blogname;
		$subsite_path   = $subsite['path'];
		$subsite_domain = $subsite['domain'];
		switch_to_blog($subsite_id);
		if ($atts['showsiteinfo']) {
			$heading     = "<hr>Site:<strong> $subsite_id - '$subsite_name'</strong> -  <strong>";
			$thesite_url = site_url();
			$heading .= "<a href='" . $thesite_url . "' target='_blank'>" . $thesite_url . "</a>";
			$heading .= "</strong><hr>";
		} else {
		}
		$xsiteurl = "https://" . $subsite_domain . $subsite_path;
		mpr_site_show_posts($xsiteurl, $atts, $heading, $args);
		// don't ob_flush, that's taken care of elsewhere
		restore_current_blog();
	}
	if ($atts['showdivider']) { echo "<hr>";}	// last entry, show divider if enabled
	return;
}

// --------------------------------------------------------------------------------
//   list all posts on all multisite sites
//      inspired by https://wisdmlabs.com/blog/how-to-list-posts-from-all-blogs-on-wordpress-multisite/
// --------------------------------------------------------------------------------
// display posts on all sites

function mpr_site_show_posts($xsiteurl = "", $atts = array(), $heading = array(), $args = array()) {
	global $post;
	// ensure args are set with at least the post type parameter, otherwise, query results will be empty
	if (!is_array($args)) {$args = array();$args['post_type'] = "post";}
	//  see https://developer.wordpress.org/reference/classes/wp_query/#tag-parameters
	//      - for syntax of query element and value type (string, comma string, array)

	$query = new WP_Query($args);
	if ($atts['showsql']) {
		$query->store_result();
		$records_found = $query->post_count;
		echo "<br><b>SQL Query:</b><br>" . $query->request . "<br>";
		echo "<strong>Found:</strong> " . $records_found . " records<br>";
	}
	if (!$query->have_posts()) {
		if (isset($atts['debug'])) {echo "<strong>Debug: </strong> (none found)<br>";}
		if (isset($atts['showempty'])) {
			echo "(none found)";
			return;
		}
	}

	if ($query->have_posts()) {
		while ($query->have_posts()) {
			$query->the_post();
			$x = get_post();
			if ($atts['showdivider']) {echo "<hr>";} else {echo "<br>";}

			?>
<div class="mpr_content"> <strong> <a href="<?php the_permalink();?>" title="<?php the_title_attribute();?>" class="mpr_the_permalink">
    <div class="mpr_the_title"><?php the_title();?></div>
    </a></strong>&nbsp;&nbsp;&nbsp;
    <?php
//echo "569 nodate = " . $atts['nodate'] . " <br>";
			if (!($atts['nodate'])) {
//echo "date format = " . get_option('date_format') . "<br>";
				//echo "post date = " . $x->post_date . "<br>";
				$date_format = get_option('date_format');
				echo '<span class="mpr_post_date">' . date_format(date_create($x->post_date), $date_format) . "</span>";}
			if (current_user_can('editor') || current_user_can('administrator')) // then they are admin/superadmin/editor
			{
				$xlink = get_edit_post_link($x->id);
				echo '&nbsp;&nbsp;<a href="' . $xlink . '" target="_blank" title="Edit Post" class="dashicons dashicons-edit"></a>&nbsp;&nbsp;';
			}
			if ($atts['showall']) {
				echo "<em>(status = " . $x->post_status . ")</em>";
			}
			echo "<br>";
			// new 'excerpt' option replaces 'words' option
			if (($atts['words'] > 0) OR ($atts['excerpt'])) {
				$text = make_clickable(get_the_excerpt());
				echo "<div class='mpr_get_the_content'>";
				echo $text;
				echo "</div>";
			} else {
				echo "<div class='mpr_get_the_content'>";
				the_content("  (Read more ...)");
				echo "</div>";
			}
			if (!$atts['showdivider']) {
				echo "<br><br>";}

			?>
</div>
<?php
}
		wp_reset_postdata();
	}
	return;
}

// --------------------------------------------------------------------------------
/**
(from http://stackoverflow.com/questions/40833184/how-do-i-truncate-post-loop-content-in-wordpress )
 * Truncate the incoming string of text to a set number of words.
 * It preserves the HTML markup.
 *
 * @since 1.0.0
 *
 * NOTE: This function is adapted from WordPress Core's `wp_trim_words()`
 * function.  It does the same functionality, except it does not strip out
 * the HTML tag elements.
 *
 * @param string $text
 * @param int $words_limit
 * @param string $more_text
 *
 * @return string
 */
function mpr_truncate_text($text, $words_limit = 55, $more_text = '&hellip;') {
	$separator = ' ';

	/*
	 * translators: If your word count is based on single characters (e.g. East Asian characters),
	 * enter 'characters_excluding_spaces' or 'characters_including_spaces'. Otherwise, enter 'words'.
	 * Do not translate into your own language.
	 */
	if (strpos(_x('words', 'Word count type. Do not translate!'), 'characters') === 0 && preg_match('/^utf\-?8$/i', get_option('blog_charset'))) {
		$text = trim(preg_replace("/['\n\r\t ']+/", ' ', $text), ' ');
		preg_match_all('/./u', $text, $words_array);
		$words_array = array_slice($words_array['0'], 0, $words_limit + 1);
		$separator   = '';
	} else {
		$words_array = preg_split("/['\n\r\t ']+/", $text, $words_limit + 1, PREG_SPLIT_NO_EMPTY);
	}
	if (!count($words_array) > $words_limit) {
		return implode($separator, $words_array);
	}
	array_pop($words_array);
	$text      = implode($separator, $words_array);
	$more_text = '<a class="more-link" href="' . get_permalink() . '">' . $more_text . '</a>';
	return $text . $more_text;
}

// --------------------------------------------------------------------------------
function mpr_objectToArray($object) { // convert object to array, required for get_sites() loop
	if (!is_object($object) && !is_array($object)) {
		return $object;
	}

	return array_map('mpr_objectToArray', (array) $object);
}

// ===============================================================================
//  end functions to display all posts
// ===============================================================================
// ----------------------------------------------------------------------------
// debugging function to show array values nicely formatted
function mpr_show_array($xarray = array()) {
	echo "<pre>";
	print_r($xarray);
	echo "</pre>";
	return;
}

// check if at least WP 4.6
// based on https://www.sitepoint.com/preventing-wordpress-plugin-incompatibilities/
function mpr_is_requirements_met() {
	$min_wp  = '4.6';
	$min_php = '7.2';

	// Check for WordPress version
	if (version_compare(get_bloginfo('version'), $min_wp, '<')) {
		return false;
	}

	// Check the PHP version
	if (version_compare(PHP_VERSION, $min_php, '<')) {
		return false;
	}

	return true;
}

function mpr_disable_plugin() {
//    if ( current_user_can('activate_plugins') && is_plugin_active( plugin_basename( __FILE__ ) ) ) {
	if (is_plugin_active(plugin_basename(__FILE__))) {
		deactivate_plugins(plugin_basename(__FILE__));

		// Hide the default "Plugin activated" notice
		if (isset($_GET['activate'])) {
			unset($_GET['activate']);
		}
	}
}

function mpr_show_notice() {
	echo '<div class="notice notice-error is-dismissible"><p><strong>Multisite Post Reader</strong> cannot be activated - requires at least WordPress 4.6 and PHP 5.3.&nbsp;&nbsp;&nbsp;Plugin automatically deactivated.</p></div>';
	return;
}

// ============================================================================
// show the logo in the sidebar
// ----------------------------------------------------------------------------
function mpr_cellarweb_logo() {
	?>
 <p align="center"><a href="https://www.cellarweb.com" target="_blank" title="CellarWeb.com site"><img src="<?php echo plugin_dir_url(__FILE__); ?>assets/cellarweb-logo-2022.jpg"  width="90%" class="CWICM_shadow" ></a></p>
 <?php
return;
}

// ============================================================================
//  settings page sidebar content
// ----------------------------------------------------------------------------
function mpr_sidebar() {
	?>
<h3 align="center">But wait, there's more!</h3>
<p>There's our plugin that will automatically add your <strong>Amazon Affiliate code</strong> to any Amazon links - even links entered in comments by others!&nbsp;&nbsp;&nbsp;Check out our nifty <a href="https://wordpress.org/plugins/amazolinkenator/" target="_blank">AmazoLinkenator</a>! It will probably increase your Amazon Affiliate revenue!</p>
<p>We've got a <a href="https://wordpress.org/plugins/simple-gdpr/" target="_blank"><strong>Simple GDPR</strong></a> plugin that displays a GDPR banner for the user to acknowledge. And it creates a generic Privacy page, and will put that Privacy Page link at the bottom of all pages.</p>
<p>How about our <strong><a href="https://wordpress.org/plugins/url-smasher/" target="_blank">URL Smasher</a></strong> which automatically shortens URLs in pages/posts/comments?</p>
<p><a href="https://wordpress.org/plugins/blog-to-html/" target="_blank"><strong>Blog To HTML</strong></a> : a simple way to export all blog posts (or specific categories) to an HTML file. No formatting, and will include any pictures or galleries. A great way to convert your blog site to an ebook.</p>
<hr />
<p><strong>To reduce and prevent spam</strong>, check out:</p>
<p><b>The ultimate contact form spam preventer</b>: <a href="https://www.formspammertrapc.om" target="_blank" title="Contact Form Spam Preventer">FormSpammerTrap</a>. You can put your contact form on any page by modifying a template from your theme - just add three lines of code. It is also great for non-WP site. Very easy to implement - and it's free!. Check the <a href="https://www.formspammertrapc.om" target="_blank" title="Prevent Contact Form Spam for Free!">site</a> for details. </p>
<p><a href="https://wordpress.org/plugins/formspammertrap-for-comments/" target="_blank"><strong>FormSpammerTrap for Comments</strong></a>: reduces spam without captchas, silly questions, or hidden fields - which don't always work. </p>
<p><a href="https://wordpress.org/plugins/formspammertrap-for-contact-form-7/" target="_blank"><strong>FormSpammerTrap for Contact Form 7</strong></a>: reduces spam when you use Contact Form 7 forms. All you do is add a little shortcode to the contact form.</p>
<hr />
<p>For <strong>multisites</strong>, we've got:
<ul>
    <li><strong><a href="https://wordpress.org/plugins/multisite-comment-display/" target="_blank">Multisite Comment Display</a></strong> to show all comments from all subsites.</li>
    <li><strong><a href="https://wordpress.org/plugins/multisite-post-reader/" target="_blank">Multisite Post Reader</a></strong> to show all posts from all subsites.</li>
    <li><strong><a href="https://wordpress.org/plugins/multisite-media-display/" target="_blank">Multisite Media Display</a></strong> shows all media from all subsites with a simple shortcode. You can click on an item to edit that item. </li>
</ul>
</p>
<hr />
<p><strong>They are all free and fully featured!</strong></p>
<hr />
<p>I don't drink coffee, but if you are inclined to donate because you like my WordPress plugins, go right ahead! I'll grab a nice hot chocolate, and maybe a blueberry muffin. Thanks!</p>
<div align="center">
    <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
        <input type="hidden" name="cmd" value="_s-xclick">
        <input type="hidden" name="hosted_button_id" value="SKSN99LR67WS6">
        <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_paynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
        <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
    </form>
</div>
<hr />
<p><strong>Privacy Notice</strong>: This plugin does not store or use any personal information or cookies.</p>
<?php mpr_cellarweb_logo();
	return;
}

function mpr_footer() {
	?>
<p align="center"><strong>Copyright &copy; 2016- <?php echo date('Y'); ?> by Rick Hellewell and <a href="http://CellarWeb.com" title="CellarWeb" >CellarWeb.com</a> , All Rights Reserved. Released under GPL2 license. <a href="http://cellarweb.com/contact-us/" target="_blank" title="Contact Us">Contact us page</a>.</strong></p>
<?php
return;
}

// ----------------------------------------------------------------------------
// all done!
// ----------------------------------------------------------------------------
