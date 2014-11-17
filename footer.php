		</div><!-- #main -->

	</div><!-- #page -->

    	<script src="<?php echo site_url(); ?>/wp-includes/js/jquery/jquery.js"></script>
    	<script src="<?php echo site_url(); ?>/wp-includes/js/jquery/ui/jquery.ui.core.min.js"></script>
    	<script src="<?php echo site_url(); ?>/wp-includes/js/jquery/ui/jquery.ui.datepicker.min.js"></script>
    	<script src="<?php echo site_url(); ?>/wp-includes/js/jquery/ui/jquery.ui.dialog.min.js"></script>

    	<script src="<?php bloginfo('template_directory'); ?>/bootstrap/js/bootstrap.min.js"></script>

		<script type="text/javascript">
		jQuery(document).ready(function($){
			$('#validate').click(function(){
				var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
				
				$.ajax({
					url: ajaxurl,
					data: {
						action: 'grantPhysicalAccess',
						state: '1',
						lastname: $('#lastname').val(),
						confirmno: $('#confirmno').val()
					},
					beforeSend: function() {
						$('#validate').attr("disabled", "disabled");
						$('.spinner').show();
					},
					success: function(result){
						$('.spinner').hide();
						$('#validate').removeAttr("disabled");
						alert(result);
					},
					failure: function(error) {
						$('.spinner').hide();
						alert(error);
					}
				});
			});
			$('#checkindate').datepicker({  
            	inline: true,  
            	showOtherMonths: true,  
            	dayNamesMin: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],  
        	});
			$('#checkoutdate').datepicker({  
            	inline: true,  
            	showOtherMonths: true,  
            	dayNamesMin: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],  
        	});
        	$('#search').click(function(){
        		var checkin = $('#checkindate').val();
        		var checkout = $('#checkoutdate').val();
        		var guests = $('#guests').val();
				var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
				var blog_name = '<?php echo get_bloginfo('name'); ?>';
								
				$.ajax({
					url: ajaxurl,
					data: {
						action: 'check_availability',
						checkin: checkin,
						checkout: checkout,
						guests: guests
					},
					beforeSend: function() {
						$('#search').attr("disabled", "disabled");
						$('.spinner').show();
					},
					success: function(result){
						$('.spinner').hide();
						$('#search').removeAttr("disabled");
						var unit = $.parseJSON(result);
						var available = unit.available;
						var price = unit.price;
						console.log("Available: " + available);
						console.log("Price: " + price);
						if (available == '1') {
							if (confirm("The acommodation is available, would you like to book it?") == true) {
			
							$('input[name="item_name"]').val("Booking for " + blog_name + " from " + checkin + " to " + checkout + " for " + guests + " guest(s).");
							$('input[name="amount"]').val(price);
							$('.paypalform').submit();
     						return false;			

							} 						
						} else {
							alert("Sorry, the studio is not available. Please try different dates");
						}
					},
					failure: function(error) {
						$('.spinner').hide();
						alert(error);
					}
				});
        	});
		});
		</script>
	</body>
</html>
