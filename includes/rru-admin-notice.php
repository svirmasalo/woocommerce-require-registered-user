<?php
/**
 * Display an admin notice based on selected state of Require Registered Users
 * @since  1.0.0
 * @return void
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Load notices after plugins loaded
add_action('plugins_loaded','rru_notice');

function rru_notice(){

	// Display an admin notice based on selected RRU setting.
	add_action( 'admin_notices', 'maybe_display_admin_notices' );

	function maybe_display_admin_notices () {
		
		?>
	    
	    <div class="notice notice-success is-dismissible">
	    	<?php 

		    	$rruStatus = get_option('wcrru_enable');

		    	if($rruStatus == 'yes'){
		    		$rru_notice = __( 'Registered user is required to access WooCommerce pages', 'woocommerce-rru' );
		    	}else{
					$rru_notice = __( 'Registered user is not required to access WooCommerce pages', 'woocommerce-rru' );
		    	}

	    	?>
	        <p><?php echo $rru_notice; ?></p>
	    </div>

	    <?php

	}
}

?>