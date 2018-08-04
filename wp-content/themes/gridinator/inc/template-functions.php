<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 */





/** ====================================================================================================
 *  	MISC. HELPER F(X)
 ** ==================================================================================================== */





/**
 * Remove WP functionality that injects <p>tags around post content</p>
 * WARNING: must handle tagging in text editor and account for styles in CSS
 */
//remove_filter( 'the_content', 'wpautop' );
//remove_filter( 'the_excerpt', 'wpautop' );
/**
 * Filters <p> and <br> tags from WP wysiwyg
 * Do not to change the default behavior, but just filter the content
 * @param => @array of your shortcodes to filter
 */
function wp_gridinator_shortcode_content_filter($content) {
	$block = join("|", array(
		'scroller',
		'image_block',
		'nav',
		'view_fullscreen',
		'column_wrap',
		'column'
	));
	$rep = preg_replace("/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/","[$2$3]",$content);
	$rep = preg_replace("/(<p>)?\[\/($block)](<\/p>|<br \/>)?/","[/$2]",$rep);
return $rep;
}
add_filter("the_content", "wp_gridinator_shortcode_content_filter");





/**
 * Responsive images functions
 * 
 * @param string $html Html to parse out width & height atts
 */
function wp_gridinator_remove_thumbnail_dimensions($html) {
	$html = preg_replace("/(width|height)=\"\d*\"\s/","",$html);
	return $html;
}
add_filter('post_thumbnail_html', 'wp_gridinator_remove_thumbnail_dimensions', 10);
add_filter('image_send_to_editor', 'wp_gridinator_remove_thumbnail_dimensions', 10);





/** ====================================================================================================
 *  	HEADER & BODY
 ** ==================================================================================================== */





/**
 * HELPER F(x) => returns the an ID of the current page-type
 * @returns string
 */
function get_current_page_class() {
	// var
	$pageType = '';
	// Default homepage
	if ( is_front_page() && is_home() ) {
		$pageType = 'home-default';
	// static homepage
	} elseif ( is_front_page() ) {
		$pageType = 'home-static';
	// blog page
	} elseif ( is_home() ) {
		$pageType = 'page-blog';
	// blog post page
	} elseif ( is_single() ) {
		$pageType = 'page-post';
	// single pages
	} else {
		$pageType = 'page-single';
	}
	// return string
	return $pageType;
}





/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function wp_gridinator_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}
	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}
	// additional, custom classes
	$classes[] = 'sassy-body';
	// return classes
	return $classes;
}
add_filter( 'body_class', 'wp_gridinator_body_classes' );





/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function wp_gridinator_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'wp_gridinator_pingback_header' );





/**
 * displays custom head content: logo, blog name, description, etc.
 */
function wp_gridinator_custom_header_content() {
	// header content string
	$headerContent = '';
	// check parent theme support
	if (current_theme_supports('custom-header')) {
		// wrap content in a link
		$headerContent .= '<a href="' . esc_url( home_url( '/' ) ) . '" rel="home">';
		// custom logo image
		$headerContent .= '<img class="custom-logo" src="' . get_template_directory_uri() . '/assets/svg/JoeyG-blue.svg">';
		// close link wrap
		$headerContent .= '</a>';
		// custom description 
		$wp_gridinator_description = get_bloginfo( 'description', 'display' );
		if ($wp_gridinator_description || is_customize_preview()) {
			$headerContent .= '<p class="custom-description">' . $wp_gridinator_description . '</p>';
		}
	}
	// return header content string
	return $headerContent;
}





/**
 * returns the pages current slug
 **/
function wp_gridinator_get_page_slug() {
	// Get the queried object and sanitize it
	$current_page = sanitize_post($GLOBALS['wp_the_query']->get_queried_object());
	// Get the page slug
	$slug = $current_page->post_name;
	// return slug
	return $slug;
}





/** ====================================================================================================
 *  	NAVIGATION
 ** ==================================================================================================== */





/**
 * SITE navigation
 */
function wp_gridinator_site_navigation( $post ) {
	$menuParameters = array(
		'menu'            => 'Site Navigation',
		'menu_id'         => 'site-navigation',
		'container'       => false,
		'echo'            => false,
		'items_wrap'      => '%3$s',
		'depth'           => 0,
	);
	return strip_tags(wp_nav_menu( $menuParameters ), '<a>' );
}





/**
 * HEADER navigation
 */
function wp_gridinator_header_navigation_dropdown($post) {
	
	// check header menu exists for this post/page/category
	$pageID = get_queried_object_ID();
	$page_menu_meta = get_metadata('post', $pageID, 'header_menu', true);
	$term = get_term($pageID);
	$term_menu_meta = get_term_meta($pageID, 'header_menu', true)['header_menu'];
	$menu;
	$menu_items;
	// configure header
	$header_nav_id = 'navigation-header';
	$header_nav_toggle = '';
	$header_nav = '';

	// build menu
	if ( strlen($page_menu_meta) > 0 ) {
		$menu = wp_get_nav_menu_object($page_menu_meta);
	}
	if ( strlen($term_menu_meta) > 0 ) {
		$menu = wp_get_nav_menu_object($term_menu_meta);
	}

	echo "<pre>";
	var_dump($menu);
	//var_dump(wp_get_nav_menu_object($page_menu_meta));
	//var_dump(wp_get_nav_menu_object($term_menu_meta));
	echo "</pre>";

	// check has menu
	if(is_object($menu)) {
		// add nav toggle
		$header_nav_toggle .= '<a class="header-nav-toggle" data-bind="click" data-event="toggler" data-toggle="#'. $header_nav_id .'" href="#">';
		$header_nav_toggle .= '<i class="fa fa-bars"></i>';
		$header_nav_toggle .= '</a>';
		// get nav items
		$menu_items = wp_get_nav_menu_items($menu->term_id);
		// start header nav block
		$header_nav .= '<nav id="'. $header_nav_id . '" class="menu">';
		// loop through menu items
		foreach($menu_items as $menu_item) {
			// if top level menu item
			if($menu_item->menu_item_parent == 0) {
				$parent = $menu_item->ID;
				$menu_array = array();
				// check if this menu item has subitems
				foreach( $menu_items as $submenu ) {
					if( $submenu->menu_item_parent == $parent ) {
						$bool = true;
						$menu_array[] = '<a class="sub-menu-item" href="' . $submenu->url . '"><span>'.$submenu->title.'</span></a>' ."\n";
					}
				}
				// submenu items
				if( $bool == true && count( $menu_array ) > 0 ) {
					$header_nav .= '<div class="header-nav-submenu">' ."\n";
						$header_nav .= '<a class="title submenu-dropdown-toggle" data-bind="click" data-event="toggler" data-toggle="#header-submenu-'.$menu_item->ID.'"><span class="caret fa fa-caret-down"></span><span class="title">'.$menu_item->title.'</span></a>' ."\n";
						$header_nav .= '<nav id="header-submenu-'.$menu_item->ID.'" class="submenu-nav">' ."\n";
							$header_nav .= implode( "\n", $menu_array );
						$header_nav .= '</nav>' ."\n";
					$header_nav .= '</div>' ."\n";
				// single menu item (no submenu)
				} else {
					$header_nav .= '<a href="' . $menu_item->url . '" class="title"><span>'.$menu_item->title.'</span></a>' ."\n";
				}
			}
		}
		// close header nav block
		$header_nav .= '</nav>';
	}
	return $header_nav_toggle . $header_nav;
}





/** ====================================================================================================
 *  	PAGES & POSTS CONTENT
 ** ==================================================================================================== */





/**
 * Featured posts
 */
// add meta box to admin
function wp_gridinator_featured_post() {
	add_meta_box( 'sm_meta', __( 'Featured Post', 'sm-textdomain' ), 'wp_gridinator_featured_post_callback', 'post' );
}
function wp_gridinator_featured_post_callback($post) {
	$featured = get_post_meta($post->ID); ?>
	<p>
		<div class="sm-row-content">
			<label for="meta-checkbox-featured-post">
				<input type="checkbox" name="meta-checkbox-featured-post" id="meta-checkbox-featured-post" value="1" <?php if (isset($featured['meta-checkbox-featured-post'])) checked($featured['meta-checkbox-featured-post'][0], '1'); ?> />
				<?php _e('Feature this post', 'sm-textdomain'); ?>
			</label>
		</div>
	</p><?php
}
add_action( 'add_meta_boxes', 'wp_gridinator_featured_post' );

// save featured post meta box on update
function wp_gridinator_featured_post_save_meta($post_id) {
	// Checks save status
	$is_autosave = wp_is_post_autosave( $post_id );
	$is_revision = wp_is_post_revision( $post_id );
	$is_valid_nonce = ( isset( $_POST[ 'sm_nonce' ] ) && wp_verify_nonce( $_POST[ 'sm_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
	// Exits script depending on save status
	if ($is_autosave || $is_revision || !$is_valid_nonce) {
		return;
	}
	// Checks for input and saves
	if( isset( $_POST[ 'meta-checkbox-featured-post' ] ) ) {
		update_post_meta($post_id, 'meta-checkbox-featured-post', '1');
	} else {
		update_post_meta($post_id, 'meta-checkbox-featured-post', '0');
	}
}
add_action('save_post', 'wp_gridinator_featured_post_save_meta');





/**
 * gets the post headline and returns it as a header string
 */
function wp_gridinator_post_headline($num) {
	global $post;
	$headline = get_post_meta(get_the_ID(), 'headline', true);
	$output = '';
	if ( !empty($headline) ) {
		if ( isset($num) && is_int($num) ) {
			$output .= '<h'.$num.' class="entry-headline">' . $headline . '</h'.$num.'>';
		} else {
			$output .= '<h2 class="entry-headline">' . $headline . '</h2>';
		}
		return $output;
	}
	return null;
}





/**
 * custom excerpts wrapper
 */
function wp_gridinator_add_class_to_excerpt( $excerpt ){
	return '<div class="entry-excerpt">'.$excerpt.'</div>';
}
add_action('the_excerpt','wp_gridinator_add_class_to_excerpt');





/**
 * returns a link to the blog post
 */
function wp_gridinator_read_more_link() {
	global $post;
	return '<a class="read-more" href="'. get_permalink($post->ID) . '">view project</a>';
}





/**
 * returns a link to go back to all blog posts page, at this posts #id-position
 */
function wp_gridinator_project_back_link() {
	global $post;
	$url = get_permalink( get_option('page_for_posts') );
	$url .= '#post-' . $post->ID;
	$back_link = "<a class='h1' href='$url'>Go To Portfolio <i class='fa fa-book'></i></a>";
	return $back_link;
}





/**
 * Displays featured images on the post page
 * => MUST be run in the loop
 */
function wp_gridinator_display_post_featured_image() {
	// post
	if (has_post_thumbnail()) {
		// start image tag
		$imageString = '<img class="entry-thumbnail" ';
		$imageSrc = 'src="';
		// dynamic images
		if(class_exists('Dynamic_Featured_Image')) {
			global $dynamic_featured_image;
			// get post featured images
			$featured_images = $dynamic_featured_image->get_all_featured_images();
			// if a secondary image exists
			if (isset($featured_images[1])) {
				// update src to second featured image
				$imageSrc .= $featured_images[1]['full'];
			// otherwise
			} else {
				// update src to first featured image
				$imageSrc .= $featured_images[0]['full'];
			}
		// static images
		} else {
			// default image thumbnail src
			$imageSrc .= the_post_thumbnail_url();
		}
		// add image src
		$imageString .= $imageSrc . '" ';
		// end image tag
		$imageString .= '/>';
		// return stringified image tag
		return $imageString;
	}
}





/** ====================================================================================================
 *  	CATEGORIES
 ** ==================================================================================================== */





/**
 * Adds admin ability to give categoy pages a header_menu metadata attr
 */
function wp_gridinator_edit_category_header_menu_field( $term ){
	$term_id = $term->term_id;
	$term_meta = get_option( "taxonomy_$term_id" );
	?>
	<tr class="form-field">
		<th scope="row">
			<label for="term_meta[header_menu]"><?php echo _e('Category Header Menu (secondary nav)') ?></label>
			<td>
				<input name="term_meta[header_menu]" id="term_meta[header_menu]" type="text" value="<?php if (isset($term_meta['header_menu'])) { echo $term_meta['header_menu']; }; ?>" />
			</td>
		</th>
	</tr><?php
}
// Add the dropdown to the Edit form
add_action( 'category_edit_form_fields', 'wp_gridinator_edit_category_header_menu_field' );





// Save the field
function wp_gridinator_save_category_header_menu_meta( $term_id ){ 
	if ( isset( $_POST['term_meta'] ) ) {
		$term_meta = array();
		// Be careful with the intval here.
		// If it's text you could use sanitize_text_field()
		$term_meta['header_menu'] = isset ( $_POST['term_meta']['header_menu'] ) ? sanitize_text_field( $_POST['term_meta']['header_menu'] ) : '';
		// Save the option array.
		add_term_meta( $term_id, 'header_menu', $term_meta, false );
		update_option( "taxonomy_$term_id", $term_meta );
	}
}





// create an option when adding a new category
function wp_gridinator_add_category_header_menu_field( $term ){
	$term_id = $term->term_id;
	$term_meta = get_option( "taxonomy_$term_id" );
	?>
	<div class="form-field">
		<label for="term_meta[header_menu]"><?php echo _e('Category Header Menu (secondary nav)') ?></label>
		<input name="term_meta[header_menu]" id="term_meta[header_menu]" type="text" value="<?php if (isset($term_meta['header_menu'])) { echo $term_meta['header_menu']; }; ?>" />
	</div><?php
}
// Add the dropdown to the Create form
add_action( 'category_add_form_fields', 'wp_gridinator_add_category_header_menu_field' );
// save_tax_meta
add_action( 'edited_category', 'wp_gridinator_save_category_header_menu_meta', 10, 2 ); 
add_action( 'create_category', 'wp_gridinator_save_category_header_menu_meta', 10, 2 ); 





/**
 * displays category header_menu in admin table
 */
// Add column to Category list
function wp_gridinator_category_header_menu_columns($columns) {
	return array_merge( $columns, array('header_menu' =>  __('Header Menu')) );
}
add_filter('manage_edit-category_columns' , 'wp_gridinator_category_header_menu_columns');

// Add the value to the column
function wp_gridinator_category_header_menu_columns_values( $deprecated, $column_name, $term_id) {
	if($column_name === 'header_menu'){
		$term_meta = get_option( "taxonomy_$term_id" );
		if (isset($term_meta['header_menu'])) {
			echo _e($term_meta['header_menu']);
		} else {
			echo _e('none');
		}
	}
}
add_action( 'manage_category_custom_column' , 'wp_gridinator_category_header_menu_columns_values', 10, 3 );



/** ====================================================================================================
 *  	SEARCH
 ** ==================================================================================================== */

/**
 * Search form
 */
function wp_gridinator_html5_search_form($form) { 
	$form = '<section class="search"><form role="search" method="get" class="search-form" action="' . home_url( '/' ) . '" >
		<label class="screen-reader-text" for="s">' . __('',  'domain') . '</label>
		<input class="search-field" type="search" value="' . get_search_query() . '" name="s" id="s" placeholder="look through my archives" />
		<input class="search-submit" type="submit" id="searchsubmit" value="'. esc_attr__('search', 'domain') .'" />
		</form></section>';
	return $form;
}
add_filter( 'get_search_form', 'wp_gridinator_html5_search_form' );




