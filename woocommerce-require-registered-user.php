<?php

/**
 * Plugin Name: WooCommerce Require Registered User
 * Plugin URI: ...
 * Description: Prevent visitors accessing WooCommerce pages
 * Version: 1.0.0
 * Author: Sampo Virmasalo
 * Author URI: https://svirmasalo.fi
 * Developer: Sampo Virmasalo
 * Developer URI: https://svirmasalo.fi
 * Text Domain: woocommerce-rru
 * Domain Path: /lang
 *
 * WC requires at least: 3.1.2
 * WC tested up to: 3.1.2
 *
 * Copyright: © 2017 Sampo Virmasalo
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Check if WooCommerce is active
 **/
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

	/**
	* Translations
	*/
	add_action('plugins_loaded', 'WC_RRU_Translations');
	function WC_RRU_Translations() {
		load_plugin_textdomain( 'woocommerce-rru', false, dirname( plugin_basename(__FILE__) ) . '/lang/' );
	}

	/**
	 * Create the section beneath the products tab
	 **/
	include_once('includes/rru-settings-page.php');

	/**
	* Create admin notice for selected RRU setting
	*/
	include_once('includes/rru-admin-notice.php');

	/**
	* MAIN FUNCTIONALITY
	*
	* Watch for the page accessed
	*/
	function rru_page_access(){
		/**
		* Get RRU and user status
		*/
		$rruStatus = get_option('wcrru_enable');

		if($rruStatus === 'yes' && is_user_logged_in() == false){

			/**
			* Hide prices
			*/
			function WC_RRU_hide_prices( $price){
				$price = __('Only for registered users','woocommerce-rru');
				return $price;
			}
			add_filter( 'wc_price', 'WC_RRU_hide_prices');

			/**
			* Hide add-to-cart -button
			*/ 
			add_filter( 'woocommerce_is_purchasable', false );

			/**
			* Check if WooCommerce
			*/
			$curPost = get_post();
			if(is_woocommerce($curPost->ID) || is_cart($curPost->ID)){

				/**
				* Redirect user to my-account page if not registered
				*/ 
				$myAccount = get_permalink( get_option('woocommerce_myaccount_page_id') );
				wp_redirect($myAccount);
				exit;
			}

		}
	}
	add_action('wp','rru_page_access');

}

?>