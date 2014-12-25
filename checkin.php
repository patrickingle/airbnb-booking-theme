<?php
/**
* Template Name: AirBNB Check In Validator
*/
?>
<?php get_header(); ?>
<center>
	<?php the_title(); ?>
	<label>Last Name</label>
	<input id="lastname" type="text" name="lastname" value=""><br/>
	<label>Confirmation #</label>
	<input id="confirmno" type="text" name="confirmno" value=""><br/>
	<input type="button" id="validate" name="valdate" value="Validate">
</center>
<div class="spinner"><center><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/spiffygif_164x164.gif" ></center></div>
<?php get_footer(); ?>