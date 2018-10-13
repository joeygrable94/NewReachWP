<?php
/**
 * 
 * Functions which enhance the theme by hooking into WordPress
 * 
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
function wpjg_shortcode_content_filter($content) {
	$block = join("|", array(
		'scroller',
		'image_block',
		'nav',
		'fullscreen',
		'column_wrap',
		'column',
		'viewport'
	));
	$rep = preg_replace("/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/","[$2$3]",$content);
	$rep = preg_replace("/(<p>)?\[\/($block)](<\/p>|<br \/>)?/","[/$2]",$rep);
return $rep;
}
add_filter("the_content", "wpjg_shortcode_content_filter");





/**
 * Responsive images functions
 * 
 * @param string $html Html to parse out width & height atts
 */
function wpjg_remove_width_attribute($html) {
	$html = preg_replace('/(width|height)="\d*"\s/',"",$html);
	return $html;
}
add_filter('post_thumbnail_html', 'wpjg_remove_width_attribute', 10);
add_filter('image_send_to_editor', 'wpjg_remove_width_attribute', 10);





/** ====================================================================================================
 *  	HEADER & BODY
 ** ==================================================================================================== */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function wpjg_body_classes( $classes ) {
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
add_filter( 'body_class', 'wpjg_body_classes' );





/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function wpjg_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'wpjg_pingback_header' );





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
 * HELPER F(x) => returns the category of the current page
 * @returns string
 */
function get_current_category_class() {
	// ref this post
	global $post;
	// get category
	$categories = get_the_category($post->ID);
	// loop & print category slug
	foreach ($categories as $category) {
		echo $category->slug;
	}
}





/**
 * displays custom head content: logo, blog name, description, etc.
 */
function wpjg_custom_header_content() {
	// header content string
	$headerContent = '';
	// check parent theme support
	if (current_theme_supports('custom-header')) {
		// wrap content in a link
		$headerContent .= '<a href="' . esc_url( home_url( '/' ) ) . '" rel="home">';
		// custom logo image
		//$headerContent .= '<img class="custom-logo" src="' . get_template_directory_uri() . '/assets/svg/JoeyG-blue.svg">';
		// JoeyG logo text
		$headerContent .= '<div class="jg-logo-text-wrap">';
		$headerContent .= '<span class="jg-logo-text-joey">Joey</span><span class="jg-logo-text-g">G</span>';
		$headerContent .= '</div>';
		// close link wrap
		$headerContent .= '</a>';
		// custom description 
		$wpjg_description = get_bloginfo( 'description', 'display' );
		if ($wpjg_description || is_customize_preview()) {
			$headerContent .= '<p class="custom-description">' . $wpjg_description . '</p>';
		}
	}
	// return header content string
	return $headerContent;
}





/**
 * returns the pages current slug
 **/
function wpjg_get_page_slug() {
	// Get the queried object and sanitize it
	$current_page = sanitize_post($GLOBALS['wp_the_query']->get_queried_object());
	//var_dump($current_page);
	// Get the page slug
	$slug = $current_page->post_name;
	//$slug = $current_page->post_name ?: $current_page->name ?: NULL; // (default) NULL

	//var_dump($current_page->post_name);
	//var_dump($current_page);
	// return slug
	return $slug;
}

/**
 * returns a pages id, if given its slug
 * 
 * Usage: get_id_by_slug('any-page-slug');
 **/
function get_id_by_slug($page_slug) {
	$page = get_page_by_path($page_slug);
	if ($page) {
		return $page->ID;
	} else {
		return null;
	}
}





/** ====================================================================================================
 *  	NAVIGATION
 ** ==================================================================================================== */

/**
 * navigation builder
 */
function wpjg_build_navigation_menu( $menu, $build_nav_id, $close_nav ) {
	global $wp_query;
	$post_query = $wp_query->get_queried_object();
	$page_ID = $wp_query->get_queried_object_id();
	// vars
	$build_nav_toggle_id = $build_nav_id.'-toggle';
	$build_nav_toggle = '';
	$build_nav_menu = '';
	$menu_items;
	// add nav toggle
	$build_nav_toggle .= '<div class="';
	if (!$close_nav){ $build_nav_toggle .= 'active'; }
	$build_nav_toggle .= '" id="'.$build_nav_toggle_id.'" data-bind="click" data-event="toggler" data-toggle="#'. $build_nav_id .'">';
	$build_nav_toggle .= '<a><i class="site-nav-toggle-icon fa fa-caret-down"></i> <span class="site-nav-toggle-text">'.$menu->name.'</span></a>';
	$build_nav_toggle .= '</div>';
	// get nav items
	$menu_items = wp_get_nav_menu_items($menu->term_id);
	// start site nav block
	$build_nav_menu .= '<nav id="'. $build_nav_id . '" class="menu ';
	if (!$close_nav){ $build_nav_menu .= 'active'; }
	$build_nav_menu .= '">';
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
				$build_nav_menu .= '<div class="site-nav-submenu">' ."\n";
					$build_nav_menu .= '<a class="title submenu-dropdown-toggle" data-bind="click" data-event="toggler" data-toggle="#site-submenu-'.$menu_item->ID.'"><span class="caret fa fa-caret-down"></span><span class="title">'.$menu_item->title.'</span></a>' ."\n";
					$build_nav_menu .= '<nav id="site-submenu-'.$menu_item->ID.'" class="submenu-nav">' ."\n";
						$build_nav_menu .= implode( "\n", $menu_array );
					$build_nav_menu .= '</nav>' ."\n";
				$build_nav_menu .= '</div>' ."\n";

			// single menu item (no submenu)
			} else {
				$class_list = 'title';
				if ( $page_ID == $menu_item->object_id ) {
					$class_list .= ' current';
				}
				$build_nav_menu .= '<a href="' . $menu_item->url . '" class="'.$class_list.'"><span>'.$menu_item->title.'</span></a>' ."\n";
			}
		}
	}
	// close site nav block
	$build_nav_menu .= '</nav>';
	// return nav & nav toggle
	return $build_nav_toggle . $build_nav_menu;
}





/**
 * SITE NAV: PRIMARY or BACK
 */
function wpjg_get_site_navigation() {
	// configure page variabes
	$page = get_queried_object();
	// configure primary nav
	$primary_nav_string = '';
	$primary_nav_slug = 'site-navigation';
	$primary_nav_id = 'site-nav-primary';
	$primary_nav_menu = wp_get_nav_menu_object($primary_nav_slug);
	$close_primary_nav = false;
	// check if page has secondary navigation
	$secondary_nav_meta = get_field('header_navigation', $page->ID) ?: get_field('header_navigation', $page->taxonomy.'_'.$page->term_id);
	// check if page has back link
	$back_link = get_field('back_link', $page->ID, false) ?: get_field('back_link', $page->taxonomy.'_'.$page->term_id, false);

	// check is a shop page
	if (wpjg_check_is_wc_page()) {
		$secondary_nav_meta = get_field('header_navigation', get_option('woocommerce_shop_page_id'));
		$back_link = get_field('back_link', get_option('woocommerce_shop_page_id'), false);
		$close_primary_nav = true;
	}

	// if has secondary nav, close site nav
	if (!empty($secondary_nav_meta)) {
		$close_primary_nav = true;
	}

	// if secondary menu exists, close the site nav
	if (!empty($back_link)) {
		$primary_nav_string .= '<a class="post-back-link" href="'.$back_link['url'].'"><i class="post-back-link-icon fa fa-caret-down"></i> <span class="post-back-link-text">'.$back_link['title'].'</span></a>';
		$close_primary_nav = true;
	}

	// if no back link set AND on single page/post
	if (empty($back_link) && is_single()) {
		$primary_nav_string .= '<a class="post-back-link" href="'.wp_get_referer().'#content-post-'.get_queried_object_id().'"><i class="post-back-link-icon fa fa-caret-down"></i> <span class="post-back-link-text">'.'Go Back'.'</span></a>';
		$close_primary_nav = true;
	}

	// check primary menu exists
	if(is_object($primary_nav_menu)) {
		// get site navigation
		$primary_nav_string .= wpjg_build_navigation_menu( $primary_nav_menu, $primary_nav_id, $close_primary_nav);
	}

 	// return site navigation
	return $primary_nav_string;
}





/**
 * SECONDARY NAV
 */
function wpjg_get_secondary_navigation() {
	// configure page variabes
	$page = get_queried_object();
	// nav vars
	$secondary_nav_id = 'site-nav-secondary';
	$close_primary_nav = false;
	// check is a shop page
	if (wpjg_check_is_wc_page()) {
		$header_menu = get_field('header_navigation', get_option('woocommerce_shop_page_id'));
	// all other pages
	} else {
		$header_menu = get_field('header_navigation', $page->ID) ?: get_field('header_navigation', $page->taxonomy.'_'.$page->term_id);
	}

	// get nav menu
	if ( strlen($header_menu) > 0 ) {
		$secondary_nav = wp_get_nav_menu_object($header_menu);
	}
	// if nav exists, build menu
	if(is_object($secondary_nav)) {
		// return secondary navigation
		return wpjg_build_navigation_menu( $secondary_nav, $secondary_nav_id, $close_primary_nav);
	}
}





/** ====================================================================================================
 *  	PAGES & POSTS CONTENT
 ** ==================================================================================================== */

function wpjg_gather_portfolio_categories() {
	global $not_portfolio_posts;
	return get_categories(array(
		'type'       => 'post',
		'orderby'    => 'name',
		'order'      => 'ASC',
		'hide_empty' => 1,
		'exclude'    => $not_portfolio_posts
	));
}





/**
 * Returns a modular list of posts filtered through a GET request
 */
function wpjg_get_filtered_posts() {
	// vars
	global $post;
	global $not_portfolio_posts;
	// check request
	$cat_req = $_GET['cat'];
	// gather categories and query
	$all_cats = wpjg_gather_portfolio_categories();
	$query_find = '';
	
	// write categories list
	echo '<nav id="nav-content-filter" class="categories-filter-list">';
		if (!isset($cat_req)) {
			echo '<a class="current" href="?cat=#content-post-modular">All Projects</a>';
		} else {
			echo '<a href="?cat=#content-post-modular">All Projects</a>';
		}
		foreach ($all_cats as $cat) {
			if ($cat->slug === $cat_req) {
				$query_find = $cat_req;
				echo '<a class="current" href="?cat='. $query_find .'#content-post-modular">'.$cat->name.'</a>';
			} else {
				echo '<a href="?cat='.$cat->slug.'#content-post-modular">'.$cat->name.'</a>';
			}
		}
	echo '</nav>';

	// get filtered posts
	$filtered_query = new WP_Query(array(
		'orderby' => 'date',
		'order' => 'DESC',
		'category_name' => $query_find,
		'category__not_in' => $not_portfolio_posts
	));
	// check posts exists
	if ($filtered_query->have_posts()) {
		echo '<div class="content-block content-block-modular">';
		while ($filtered_query->have_posts()) {
			$filtered_query->the_post();
			get_template_part('template-parts/content', 'modular');
		}
		echo '</div>';
	}
}





/**
 * gets the post headline and returns it as a header string
 */
function wpjg_post_headline($num) {
	// configure page variabes
	global $post;
	$page = get_queried_object();
	$headline_class = 'content-post-headline';
	$headline = get_field('headline', $post->ID) ?: get_field('headline', $page->taxonomy.'_'.$page->term_id);
	// check is a shop page
	if (wpjg_check_is_wc_page()) {
		$headline = get_field('headline', get_option('woocommerce_shop_page_id'));
	}
	// write headline
	if ( !empty($headline) ) {
		if ( isset($num) && is_int($num) ) {
			$output .= '<h'.$num.' class="'.$headline_class.'">' . $headline . '</h'.$num.'>';
		} else {
			$output .= '<h3 class="'.$headline_class.'">' . $headline . '</h3>';
		}
		return $output;
	}
	return null;
}





/**
 * gets the post headline and returns it as a header string
 */
function wpjg_post_categories() {
	global $post;
	$cat_list = get_the_category_list(' | ', '', $post->ID);
	$cat_string = '';
	if (strlen($cat_list) > 0) {
		$cat_string .= '<h4 class="content-post-categories">'.strip_tags($cat_list).'</h4>';
	}
	return $cat_string;
}





/**
 * custom excerpts wrapper
 */
function wpjg_add_class_to_excerpt( $excerpt ){
	return '<div class="content-post-excerpt">'.$excerpt.'</div>';
}
add_action('the_excerpt','wpjg_add_class_to_excerpt');

/**
 * Filter the except custom length
 */
function wpjg_custom_excerpt_length( $length ) {
    return 50;
}
add_filter( 'excerpt_length', 'wpjg_custom_excerpt_length', 999 );





/**
 * returns a link to the blog post
 */
function wpjg_read_more_link() {
	global $post;
	return '<a class="content-post-read-more" href="'. get_permalink($post->ID) . '">view project</a>';
}





/**
 * Displays featured images on the post page
 * => MUST be run in the loop
 */
function wpjg_display_post_featured_image() {
	// post
	if (has_post_thumbnail()) {
		// start image tag
		$image_string = '<img class="content-post-thumbnail" ';
		$image_src = 'src="';
		// dynamic images
		if(class_exists('Dynamic_Featured_Image')) {
			global $dynamic_featured_image;
			// get post featured images
			$featured_images = $dynamic_featured_image->get_all_featured_images();
			// if a secondary image exists
			if (isset($featured_images[1])) {
				// update src to second featured image
				$image_src .= $featured_images[1]['full'];
			// otherwise
			} else {
				// update src to first featured image
				$image_src .= $featured_images[0]['full'];
			}
		// static images
		} else {
			// default image thumbnail src
			$image_src .= the_post_thumbnail_url();
		}
		// add image src
		$image_string .= $image_src . '" ';
		// end image tag
		$image_string .= '/>';
		// return stringified image tag
		return $image_string;
	}
}





/** ====================================================================================================
 *  	CUSTOM META
 ** ==================================================================================================== */

/** Featured posts
 ** ---------------------------------------------------------------------------------------------------- */
/**
// add meta box to admin
function wpjg_featured_post() {
	add_meta_box( 'sm_meta', __( 'Featured Post', 'sm-textdomain' ), 'wpjg_featured_post_callback', 'post' );
}
function wpjg_featured_post_callback($post) {
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
add_action( 'add_meta_boxes', 'wpjg_featured_post' );

// save featured post meta box on update
function wpjg_featured_post_save_meta($post_id) {
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
add_action('save_post', 'wpjg_featured_post_save_meta');

// displays feature post status in admin posts table
function wpjg_admin_post_columns($columns) {
	$columns = array(
		'cb'	 		=> '<input type="checkbox" />',
		'title' 		=> 'Title',
		'featured' 		=> 'Featured Post',
		'categories' 	=> 'Categories',
		'tags'			=> 'Tags',
		'author'		=> 'Author',
		'date'			=> 'Date',
	);
	return $columns;
}

// Display the column content
function wpjg_custom_post_columns($column, $post_id) {
	switch ( $column ) {
		case 'featured':
			$is_featured = get_post_meta(get_the_ID(), 'meta-checkbox-featured-post', true);
			if ( $is_featured ) {
				echo 'Yes';
			} else {
				echo 'No';
			}
			break;
	}
}
add_action('manage_posts_custom_column' , 'wpjg_custom_post_columns', 10, 2 );
add_filter("manage_edit-post_columns", "wpjg_admin_post_columns");
**/





/** SECONDARY NAVIGATION => HEADER_MENU
 ** ---------------------------------------------------------------------------------------------------- */
/**
// add meta box to admin
function wpjg_header_menu() {
	add_meta_box( 'sm_meta', __( 'Header Menu', 'sm-textdomain' ), 'wpjg_header_menu_callback', 'page' );
}
function wpjg_header_menu_callback($post) {
	$post_menu = get_post_meta($post->ID); ?>
	<p>
		<div class="sm-row-content">
			<label for="meta-text-header-menu">
				<input type="text" name="meta-text-header-menu" id="meta-text-header-menu" value="<?php if (isset($post_menu['meta-text-header-menu'])) { echo $post_menu['meta-text-header-menu'][0]; } else { echo '0'; } ?>" />
				<?php _e('Header Menu (Secondary Navigation)', 'sm-textdomain'); ?>
			</label>
		</div>
	</p><?php
}
add_action( 'add_meta_boxes', 'wpjg_header_menu' );

// save featured post meta box on update
function wpjg_header_menu_save_meta($post_id) {
	// Checks save status
	$is_autosave = wp_is_post_autosave( $post_id );
	$is_revision = wp_is_post_revision( $post_id );
	$is_valid_nonce = ( isset( $_POST[ 'sm_nonce' ] ) && wp_verify_nonce( $_POST[ 'sm_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
	// Exits script depending on save status
	if ($is_autosave || $is_revision || !$is_valid_nonce) {
		return;
	}
	// Checks for input and saves
	if( isset( $_POST[ 'meta-text-header-menu' ] ) ) {
		update_post_meta($post_id, 'meta-text-header-menu', $_POST[ 'meta-text-header-menu' ]);
	} else {
		update_post_meta($post_id, 'meta-text-header-menu', '0');
	}
}
add_action('save_post', 'wpjg_header_menu_save_meta');
**/





/** CATEGORIES
 ** ---------------------------------------------------------------------------------------------------- */
/**
 * Adds admin ability to give categoy pages a metadata attr
 */
/**
function wpjg_edit_category_header_menu_field( $term ){
	$term_id = $term->term_id;
	$term_meta = get_option( "taxonomy_$term_id" );
	?>
	<!-- header menu -->
	<tr class="form-field">
		<th scope="row">
			<label for="term_meta[header_menu]"><?php echo _e('Category Header Menu (secondary nav)') ?></label>
			<td>
				<input name="term_meta[header_menu]" id="term_meta[header_menu]" type="text" value="<?php if (isset($term_meta['header_menu'])) { echo $term_meta['header_menu']; }; ?>" />
			</td>
		</th>
	</tr>
	<?php
}
// Add the dropdown to the Edit form
add_action( 'category_edit_form_fields', 'wpjg_edit_category_header_menu_field' );

// Save the field
function wpjg_save_category_header_menu_meta( $term_id ){ 
	if ( isset( $_POST['term_meta'] ) ) {
		$term_meta = array();
		// Be careful with the intval here.
		// If it's text you could use sanitize_text_field()
		$term_meta['header_menu'] = isset ( $_POST['term_meta']['header_menu'] ) ? sanitize_text_field( $_POST['term_meta']['header_menu'] ) : '';
		// Save the option array.
		//add_term_meta( $term_id, 'header_menu', $term_meta, false );
		update_option( "taxonomy_$term_id", $term_meta );
	}
}

// create an option when adding a new category
function wpjg_add_category_header_menu_field( $term ){
	$term_id = $term->term_id;
	$term_meta = get_option( "taxonomy_$term_id" );
	?>
	<div class="form-field">
		<label for="term_meta[header_menu]"><?php echo _e('Category Header Menu (secondary nav)') ?></label>
		<input name="term_meta[header_menu]" id="term_meta[header_menu]" type="text" value="<?php if (isset($term_meta['header_menu'])) { echo $term_meta['header_menu']; }; ?>" />
	</div><?php
}
// Add the dropdown to the Create form
add_action( 'category_add_form_fields', 'wpjg_add_category_header_menu_field' );
// save_tax_meta
add_action( 'edited_category', 'wpjg_save_category_header_menu_meta', 10, 2 ); 
add_action( 'create_category', 'wpjg_save_category_header_menu_meta', 10, 2 ); 

// displays category header_menu in admin table
// Add column to Category list
function wpjg_category_header_menu_columns($columns) {
	return array_merge( $columns, array('header_menu' =>  __('Header Menu')) );
}
add_filter('manage_edit-category_columns' , 'wpjg_category_header_menu_columns');

// Add the value to the column
function wpjg_category_header_menu_columns_values( $deprecated, $column_name, $term_id) {
	if($column_name === 'header_menu'){
		$term_meta = get_option( "taxonomy_$term_id" );
		if (isset($term_meta['header_menu'])) {
			echo _e($term_meta['header_menu']);
		} else {
			echo _e('none');
		}
	}
}
add_action( 'manage_category_custom_column' , 'wpjg_category_header_menu_columns_values', 10, 3 );
**/





/** ====================================================================================================
 *  	SEARCH
 ** ==================================================================================================== */

/**
 * Search form
 */
function wpjg_html5_search_form($form) {
	$form = '<section class="search"><form role="search" method="get" class="search-form" action="' . home_url( '/' ) . '" >
		<label class="screen-reader-text" for="s">' . __('',  'domain') . '</label>
		<input class="search-field" type="search" value="' . get_search_query() . '" name="s" id="s" placeholder="look through my archives" />
		<input class="search-submit" type="submit" id="searchsubmit" value="'. esc_attr__('search', 'domain') .'" />
		</form></section>';
	return $form;
}
add_filter( 'get_search_form', 'wpjg_html5_search_form' );





/**
 * Search Resource
 */
function wpjg_search_resources_query() {

	var_dump($_GET['fsr']);
	/*
	if ($search_query) {
		echo "<pre>";
		var_dump($search_query);
		echo "</pre>";
	}
	*/

	// get resources
	$resource_query = new WP_Query(array(
		'orderby' => 'date',
		'order' => 'DESC',
		'category_name' => 'resource'
	));
	if ($resource_query->have_posts()) {
		echo '<div id="content-resource-articles" class="content-block">';
		while ($resource_query->have_posts()) {
			$resource_query->the_post();
			get_template_part( 'template-parts/content', 'resource' );
		}
		echo "</div>";
	}
	wp_reset_postdata();

}

