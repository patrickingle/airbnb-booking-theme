<?php get_header(); ?>

<div class="row">
	<div class="span2"><img src="<?php echo get_stylesheet_directory_uri(); ?>/logo.png" width="100" height="100"></div>
	<div class="span8">
		<center>
		<h1><?php echo get_bloginfo('name'); ?></h1>
		<h3><?php echo get_bloginfo('description'); ?></h3>
		</center>
	</div>
	<div class="span2">&nbsp;</div>
</div>
<div class="row">
	<div class="span2">&nbsp;</div>
	<div class="span8">
		<center>
		<input type="text" id="checkindate" name="checkindate" value="" size="10" placeholder="Check in date">
		<input type="text" id="checkoutdate" name="checkoutdate" value="" size="10" placeholder="Check out date">
		<?php
			$maximum_guests = intval(get_option('maximum_guests'));
			if ($maximum_guests == 0) {
				$maximum_guests = 4;
			} else {
				$maximum_guests++;
			}
		?>
		<select name="guests" id="guests">
			<option value="1">1 guest</option>
			<?php
				for($i=2;$i<$maximum_guests;$i++){
					echo '<option value="'.$i.'">'.$i.' guests</option>';
				}
			?>
		</select>
		<input type="button" id="search" name="search" value="Check Availability">
		</center>
	</div>
	<div class="span2">&nbsp;</div>
</div>
<div class="row">
	<div class="span12">
		<div class="spinner" style="display:none;">
			<center>
				<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/spiffygif_164x164.gif">
			</center>
		</div>		
	</div>
</div>

<div class="row"><div class="span12">&nbsp;</div></div>

<div class="row">
	<div class="span2">&nbsp;</div>
	<div class="span4">
		<?php
		$args = array (
			'post_type'              => 'post',
			'post_status'            => 'published',
			'category_name'          => 'home-page-left',
			'posts_per_page'         => '1'
		);
		$the_query = new WP_Query($args);
		
		if ($the_query->have_posts()) {
			echo '<h2><center>'.$the_query->post->post_title.'</center></h2>';
			echo $the_query->post->post_content;
		} else {
			
		}
		wp_reset_postdata();
		?>
	</div>
	<div class="span4">
		<?php
		$args = array (
			'post_type'              => 'post',
			'post_status'            => 'publish',
			'category_name'          => 'home-page-right',
			'posts_per_page'         => '1'
		);
		$the_query = new WP_Query($args);
		
		if ($the_query->have_posts()) {
			echo '<h2><center>'.$the_query->post->post_title.'</center></h2>';
			echo $the_query->post->post_content;
		} else {
		}
		wp_reset_postdata();
		?>
	</div>
	<div class="span2">&nbsp;</div>
</div>

<div class="row">
	<div class="span12 featured"></div>
</div>
<div id="search-results"></div>

<div class="row">
	<center>
	<div class="span3">
		&nbsp;
	</div>
	<div class="span3">
		<a href="http://cozyuppereastsidestudio.com/" target="_blank"><img src="http://cozyuppereastsidestudio.com/wp-content/themes/cozyuppereastsidestudio/screenshot.png" width="200" height="200"></a>
	</div>
	<div class="span3">
		<a href="http://inglehome.info/" target="_blank"><img src="http://inglehome.info/wp-content/themes/inglehome/screenshot.png" width="200" height="200"></a>
	</div>
	<div class="span3">
		<a href="http://privatecozymodernroomatyale.com/" target="_blank"><img src="http://inglehome.info/wp-content/themes/privatecozymodernroomatyale/screenshot.png" width="200" height="200"></a>
	</div>
	</center>	
</div>
<form style="display: none;" class="paypalform" name="_xclick" action="https://www.paypal.com/us/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="business" value="<?php echo get_option('paypal_email'); ?>">
<input type="hidden" name="currency_code" value="USD">
<input type="hidden" name="item_name" value="">
<input type="hidden" id="amount" name="amount" value="">
<input type="image" src="http://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
</form>

<?php get_footer(); ?>