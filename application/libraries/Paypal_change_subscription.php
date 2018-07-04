<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Paypal_change_subscription {

	function change_subscription_status( $profile_id, $action ) {
		 
	    $api_request = 'USER=' . urlencode( 'rj.pageone-facilitator_api1.yahoo.com' )
	                .  '&PWD=' . urlencode( 'GKNKAZS2757RNVWE' )
	                .  '&SIGNATURE=' . urlencode( 'AFcWxV21C7fd0v3bYYYRCpSSRl31Aecji9mnF2frWnhkxTpTwz2eDDTO' )
	                .  '&VERSION=93'
	                .  '&METHOD=ManageRecurringPaymentsProfileStatus'
	                .  '&PROFILEID=' . urlencode( $profile_id )
	                .  '&ACTION=' . urlencode( $action )
	                .  '&NOTE=' . urlencode( 'Subscription cancelled' );
	 
	    $ch = curl_init();
	    curl_setopt( $ch, CURLOPT_URL, 'https://api-3t.sandbox.paypal.com/nvp' ); // For live transactions, change to 'https://api-3t.paypal.com/nvp'
	    curl_setopt( $ch, CURLOPT_VERBOSE, 1 );
	 
	    // Uncomment these to turn off server and peer verification
	    // curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
	    // curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, FALSE );
	    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
	    curl_setopt( $ch, CURLOPT_POST, 1 );
	 
	    // Set the API parameters for this transaction
	    curl_setopt( $ch, CURLOPT_POSTFIELDS, $api_request );
	 
	    // Request response from PayPal
	    $response = curl_exec( $ch );
	 
	    // If no response was received from PayPal there is no point parsing the response
	    if( ! $response )
	        die( 'Calling PayPal to change_subscription_status failed: ' . curl_error( $ch ) . '(' . curl_errno( $ch ) . ')' );
	 
	    curl_close( $ch );
	 
	    // An associative array is more usable than a parameter string
	    parse_str( $response, $parsed_response );
	 
	    return $parsed_response;
	}
}