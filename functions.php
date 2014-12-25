<?php
/**
* Theme support
*/
$args = array(
	'wp-head-callback' => 'airbnb_custom_background_cb',
	'default-color' => '000000',
	'default-image' => '%1$s/screenshot.png',
);
add_theme_support( 'custom-background', $args );
add_theme_support( 'automatic-feed-links' );

$args = array(
	'width'         => 980,
	'height'        => 60,
	'default-image' => '%1$s/screenshot.png',
);
add_theme_support( 'custom-header', $args );

function check_availability() {
		$_start = $_GET['checkin'];
		$_end = $_GET['checkout'];
		$guests = $_GET['guests'];

		switch(get_option('api_switcher')) {
			case 'airbnb':
				{
					require_once dirname(__FILE__) . '/api/AirBNB/AirBNBAutoload.php';
					
					$_apikey = get_option('myapi_key');
					$_listing_id = get_option('airbnb_listing_id');

					$airBNBServiceGet_calendar = new AirBNBServiceGet_calendar();
					// sample call for AirBNBServiceGet_calendar::get_calendar()
					if($airBNBServiceGet_calendar->get_calendar($_apikey,$_listing_id,$_start,$_end))
					    $availability = $airBNBServiceGet_calendar->getResult();
					else
					    $availability = $airBNBServiceGet_calendar->getLastError();

					if ($availability != '') {
				    	$calendar = json_decode( $availability );
				  
				  		$available = 'U';
						$price = 0;
						$last_price = 0;
						foreach($calendar->calendar->dates as $date) {
							if (!isset($date->price_native)) {
								$available = '0';
								break;
							} else {
								$available = '1';
								$price += $date->price_native;
								$last_price = $date->price_native;
							}
						}
						$price -= $last_price;
						$response = array('available' => $available, 'price' => $price, 'availability' => $availability);
					} else {
						$response = array('available' => 'no', 'price' => 0.00, 'availability' => '');
					}

				}
				break;
			case 'nineflats':
				{
					$nineflats_client_id = get_option('nineflats_client_id');
					$nineflats_listing_name = get_option('nineflats_listing_name');
					$nineflats_currency = get_option('nineflats_currency');
					
					$url = 'https://api.9flats.com/api/v4/places/'.$nineflats_listing_name.'/trip_price?currency='.$nineflats_currency.'&start_date='.$_start.'&end_date='.$_end.'&number_of_guests='.$guests.'&client_id='.$nineflats_client_id;
					$result = json_decode(file_get_contents($url));
					if (isset($result->error)) {
						$response = array('available' => false, 'price' => 0.00, 'availability' => '');
					} else {
						$price = 0.00;
						if (isset($result->total)) {
							$price = $result->total;
						}
						$response = array('available' => true, 'price' => $price, 'availability' => '');
					}
					
				}
				break;
			default:
				$availability = '';
		}

    	
    	echo json_encode($response);
    	exit();

}

add_action( 'wp_ajax_check_availability', 'check_availability' );
add_action( 'wp_ajax_nopriv_check_availability', 'check_availability' );

function airbnb_setup_theme_admin_menus() {
	add_submenu_page('themes.php', 
        'AirBNB', 'Settings', 'manage_options', 
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

    	update_option('api_switcher',$_POST['api_switcher']);
		
		$nineflats_client_id = esc_attr($_POST['nineflats_client_id']);
		update_option('nineflats_client_id',$nineflats_client_id);
		
		$nineflats_listing_name = esc_attr($_POST['nineflats_listing_name']);
		update_option('nineflats_listing_name',$nineflats_listing_name);
		
		$nineflats_currency = esc_attr($_POST['nineflats_currency']);
		update_option('nineflats_currency',$nineflats_currency);		
	}
	
	$airbnb_listing_id = get_option('airbnb_listing_id');
	$myapi_key = get_option('myapi_key');
	$maximum_guests = get_option('maximum_guests');
	$paypal_email = get_option('paypal_email');
	$api_switcher = get_option('api_switcher');
	
	$nineflats_client_id = get_option('nineflats_client_id');
	$nineflats_listing_name = get_option('nineflats_listing_name');
	$nineflats_currency = get_option('nineflats_currency');

?>
	<script type="text/javascript">
		function airbnb_paypal_payment() {
			window.open("https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=M5UYERPSWZJUA");
			return false;
		}
	</script>
	<div class="wrap">
		<form method="POST" action="">
			<h1>Settings</h1>
			<table>
				<tr>
					<td>
						<label for="api_switcher">API Switcher</label>
					</td>
					<td>
						<input type="radio" name="api_switcher" value="airbnb" <?php echo ($api_switcher == 'airbnb' ? 'checked' : ''); ?>>AirBNB&nbsp;<input type="radio" name="api_switcher" value="nineflats" <?php echo ($api_switcher == 'nineflats' ? 'checked' : ''); ?>>9flats.com
					</td>
				</tr>
				<tr>
					<td>
						<label for="myapi_key">AirBNB API Key</label>
					</td>
					<td>
						<input type="text" name="myapi_key" id="myapi_key" value="<?php echo $myapi_key;?>">
<!--						Get you API key by pressing
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="M5UYERPSWZJUA">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_subscribeCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
-->
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
						<input type="text" name="nineflats_client_id" id="nineflats_client_id" width="80" size="80" value="<?php echo $nineflats_client_id; ?>">
					</td>
				</tr>
				<tr>
					<td>
						<label for="nineflats_listing_name">9Flats Listing Name</label>
					</td>
					<td>
						<input type="text" name="nineflats_listing_name" id="nineflats_listing_name" width="80" size="80" value="<?php echo $nineflats_listing_name; ?>">
					</td>
				</tr>
				<tr>
					<td>
						<label for="nineflats_currency">9Flats Currency</label>
					</td>
					<td>
						<input type="text" name="nineflats_currency" id="nineflats_currency" value="<?php echo $nineflats_currency; ?>">
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


function airbnb_custom_background_cb() {
	$background = get_background_image();
	
	if ( ! $background )
        return;
        
    $style = 'url('.$background.') no-repeat center center fixed';
?>
<style type="text/css">
body.background { <?php echo trim( $style ); ?> }
</style>
<?php
}

/**
 * Proper way to enqueue scripts and styles
 */
function airbnb_theme_name_scripts() {
	if (is_child_theme()) {
		wp_enqueue_style('jquery-te',get_template_directory_uri().'/css/jquery-te-1.4.0.css');
		wp_enqueue_style('bootstrap-style', get_template_directory_uri().'/bootstrap/css/bootstrap-responsive.css');
	} else {
		wp_enqueue_style('jquery-te', get_stylesheet_directory_uri().'/css/jquery-te-1.4.0.css');
		wp_enqueue_style('bootstrap-style', get_stylesheet_directory_uri().'/bootstrap/css/bootstrap-responsive.css');
	}

	wp_enqueue_style( 'jquery-ui' );
	wp_enqueue_style( 'wp-jquery-ui-dialog' );
	
	wp_enqueue_style('wp-jquery-ui-datepicker','//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css');
	
	wp_enqueue_script( 'jquery' );
	
	wp_deregister_script('jquery-ui-core');
	wp_deregister_script('jquery-ui-datepicker');
	wp_deregister_script('jquery-ui-dialog');
	
	if (file_exists(site_url().'/wp-includes/js/jquery/ui/jquery.ui.core.min.js')) {
		wp_enqueue_script('jquery-ui-core',site_url().'/wp-includes/js/jquery/ui/jquery.ui.core.min.js');
	} else {
		wp_enqueue_script('jquery-ui-core','//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js');
	}
	
	if (file_exists(dirname(__FILE__).'/../../../wp-includes/js/jquery/ui/jquery.ui.datepicker.min.js')) {
		wp_enqueue_script('jquery-ui-datepicker',site_url().'/wp-includes/js/jquery/ui/jquery.ui.datepicker.min.js');
	} else {
		
	}
	
	
	if (file_exists(dirname(__FILE__).'/../../../wp-includes/js/jquery/ui/jquery.ui.dialog.min.js')) {
		wp_enqueue_script('jquery-ui-dialog',site_url().'/wp-includes/js/jquery/ui/jquery.ui.dialog.min.js');
	} else {
		//wp_enqueue_script('jquery-ui-datepicker',);
	}
    	
	wp_enqueue_script('youtube-frame','https://www.youtube.com/iframe_api?ver=1.3.0');

	if (is_child_theme()) {
		wp_enqueue_script('bootstrap-min',get_template_directory_uri().'/bootstrap/js/bootstrap.min.js');
	} else {
		wp_enqueue_script('bootstrap-min',get_stylesheet_directory_uri().'/bootstrap/js/bootstrap.min.js');
	}
}

add_action( 'wp_enqueue_scripts', 'airbnb_theme_name_scripts' );

?>