<?php
/**
* Template Name: AirBNB Check In Validator
*/
?>
<?php get_header(); ?>
<center>
	<label>Last Name</label>
	<input id="lastname" type="text" name="lastname" value=""><br/>
	<label>Confirmation #</label>
	<input id="confirmno" type="text" name="confirmno" value=""><br/>
	<input type="button" id="validate" name="valdate" value="Validate">
</center>
<div class="spinner"><center><img src="<?php bloginfo('template_directory'); ?>/images/spiffygif_164x164.gif" ></center></div>
<?php get_footer(); ?>