<?php

function check_availability() {
		$_start = $_GET['checkin'];
		$_end = $_GET['checkout'];
		$guests = $_GET['guests'];


		ini_set('memory_limit','512M');
		ini_set('display_errors',true);
		error_reporting(-1);

		require_once dirname(__FILE__) . '/api/AirBNB/AirBNBAutoload.php';

		$_apikey = get_option('myapi_key');
		$_listing_id = get_option('airbnb_listing_id');

		$airBNBServiceGet_calendar = new AirBNBServiceGet_calendar();
		// sample call for AirBNBServiceGet_calendar::get_calendar()
		if($airBNBServiceGet_calendar->get_calendar($_apikey,$_listing_id,$_start,$_end))
		    $availability = $airBNBServiceGet_calendar->getResult();
		else
		    $availability = $airBNBServiceGet_calendar->getLastError();

    	$calendar = json_decode( $availability );

  		$available = 'U';
		$price = 0;
		foreach($calendar->calendar->dates as $date) {
			if (!isset($date->price_native)) {
				$available = '0';
				break;
			} else {
				$available = '1';
				$price += $date->price_native;
			}
		}
		$response = array('available' => $available, 'price' => $price);
    	echo json_encode($response);

    	exit();

}

add_action( 'wp_ajax_check_availability', 'check_availability' );
add_action( 'wp_ajax_nopriv_check_availability', 'check_availability' );

function airbnb_setup_theme_admin_menus() {
	add_submenu_page('themes.php',
        'AirBNB', 'AirBNB Settings', 'manage_options',
        'airbnb', 'theme_airbnb_settings');
}

function theme_airbnb_settings() {
	// Check that the user is allowed to update options
	if (!current_user_can('manage_options')) {
	    wp_die('You do not have sufficient permissions to access this page.');
	}

	if (isset($_POST["airbnb_update_settings"])) {
	    // Do the saving
	    $airbnb_listing_id = esc_attr($_POST['airbnb_listing_id']);
	    update_option('airbnb_listing_id',$airbnb_listing_id);

	    $myapi_key = esc_attr($_POST['myapi_key']);
	    update_option('myapi_key',$myapi_key);

	    $maximum_guests = esc_attr($_POST['maximum_guests']);
	    update_option('maximum_guests',$maximum_guests);

	    $paypal_email = esc_attr($_POST['paypal_email']);
	    update_option('paypal_email',$paypal_email);

	    if (isset(esc_attr($_POST['airbnb']))) {
	    	update_option('api_switcher','airbnb');
	    } elseif (isset(esc_attr($_POST['nineflats']))) {
	    	update_option('api_switcher','nineflats');
	    } else {
	    	update_option('api_switcher','none');
	    }
	}

	$airbnb_listing_id = get_option('airbnb_listing_id');
	$myapi_key = get_option('myapi_key');
	$maximum_guests = get_option('maximum_guests');
	$paypal_email = get_option('paypal_email');
	$api_switcher = get_option('api_switcher');

?>
	<div class="wrap">
		<form method="POST" action="">
			<h1>AirBNB Settings</h1>
			<table>
				<tr>
					<td>
						<label for="api_switcher">API Switcher</label>
					</td>
					<td>
						<input type="radio" name="airbnb">AirBNB&nbsp;<input type="radio" name="nineflats">9flats.com
					</td>
				</tr>
				<tr>
					<td>
						<label for="myapi_key">AirBNB API Key</label>
					</td>
					<td>
						<input type="text" name="myapi_key" id="myapi_key" value="<?php echo $myapi_key;?>">Get you API key by pressing
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="M5UYERPSWZJUA">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_subscribeCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
					</td>
				</tr>
				<tr>
					<td>
						<label for="airbnb_listing_id">AirBNB Listing ID</label>
					</td>
					<td>
						<input type="text" name="airbnb_listing_id" id="airbnb_listing_id" value="<?php echo $airbnb_listing_id;?>">
					</td>
				</tr>
				<tr>
					<td>
						<label for="nineflats_client_id">9Flats Client ID</label>
					</td>
					<td>
						<input type="text" name="nineflats_client_id" id="nineflats_client_id" value="">
					</td>
				</tr>
				<tr>
					<td>
						<label for="nineflats_listing_name">9Flats Listing Name</label>
					</td>
					<td>
						<input type="text" name="nineflats_listing_name" id="nineflats_listing_name" value="">
					</td>
				</tr>
				<tr>
					<td>
						<label for="nineflats_currency">9Flats Currency</label>
					</td>
					<td>
						<input type="text" name="nineflats_currency" id="nineflats_currency" value="">
					</td>
				</tr>
				<tr>
					<td>
						<label for="maximum_guests">Maximum Guests</label>
					</td>
					<td>
						<input type="text" name="maximum_guests" id="maximum_guests" value="<?php echo $maximum_guests;?>">
					</td>
				</tr>
				<tr>
					<td>
						<label for="paypal_email">Paypal Email</label>
					</td>
					<td>
						<input type="text" name="paypal_email" id="paypal_email" value="<?php echo $paypal_email; ?>">
					</td>
				</tr>
			</table>
			<input type="hidden" name="airbnb_update_settings" value="Y" />
			<br/>
			<input type="submit" name="submit" value="Save"/>
		</form>
	</div>
<?php
}

add_action("admin_menu", "airbnb_setup_theme_admin_menus");

?>