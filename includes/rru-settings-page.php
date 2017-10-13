<?php

/**
 * Display an admin notice based on selected state of Require Registered Users
 * @since  1.0.0
 * @return void
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


/**
* Create the section beneath the products tab
**/
add_filter( 'woocommerce_get_sections_products', 'WC_RRU_add_section' );
function WC_RRU_add_section( $sections ) {
	
	$sections['wcrru'] = __( 'Require Registered User', 'woocommerce-rru' );
	return $sections;
	
}

add_filter( 'woocommerce_get_settings_products', 'WC_RRU_all_settings', 10, 2 );

function WC_RRU_all_settings( $settings, $current_section ) {
	/**
	 * Check the current section is what we want
	 **/
	if ( $current_section == 'wcrru' ) {

		$rruStatus = get_option('wcrru_enable');

		$settings_rru = array();
		// Add Title to the Settings
		$settings_rru[] = array( 'name' => __( 'Require Registered User Settings', 'woocommerce-rru' ), 'type' => 'title', 'desc' => __( 'The following options are used to configure Require Registered User. You might need to save data twice to make it effective.', 'woocommerce-rru' ), 'id' => 'wcrru' );
		// Add first checkbox option
		$settings_rru[] = array(
			'name'     => __( 'Prevent unregistered users to access WooCommerce pages', 'woocommerce-rru' ),
			'desc_tip' => __( 'If this is selected, users will be automatically redirected to registration form', 'woocommerce-rru' ),
			'id'       => 'wcrru_enable', //wcslider_auto_insert
			'type'     => 'checkbox',
			'css'      => 'min-width:300px;',
			'desc'     => __( 'Enable Require Registered User', 'woocommerce-rru' ),
		);
		$settings_rru[] = array( 
			'name' => __( 'Current status is', 'woocommerce-rru' ).' '.$rruStatus, 
			'type' => 'title', 
			'id' => 'wcrru_status' );
		
		$settings_rru[] = array( 'type' => 'sectionend', 'id' => 'wcrru' );
		return $settings_rru;
	
	/**
	 * If not, return the standard settings
	 **/
	} else {
		return $settings;
	}
}

?>