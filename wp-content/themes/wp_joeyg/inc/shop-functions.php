<?php 
/**
 * 
 * Functions which enhance the WOOCOMMERCE SHOP by hooking into WordPress
 * 
 */



/**
 * outputs the current shop page
 */
function wpjg_check_is_wc_page() {
	// vars
	$output = false;
	// check WOOCOMMERCE page functions
	if (is_woocommerce() ||
		is_shop() ||
		is_product() ||
		is_product_category() ||
		is_product_tag() ||
		is_product_taxonomy() ||
		is_cart() ||
		is_checkout() ||
		is_add_payment_method_page() ||
		is_checkout_pay_page() ||
		is_order_received_page() ||
		is_view_order_page() ||
		is_account_page() ||
		is_edit_account_page() ||
		is_lost_password_page()
	) {
	 	$output = true;
 	}
	// return is WC page
	return $output;
}