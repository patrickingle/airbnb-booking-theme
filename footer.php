		</div><!-- #main -->

	</div><!-- #page -->

	<div id="dialog-1" title="<?php echo get_bloginfo('name'); ?>" style="display:none;"></div>
	<div id="dialog-2" title="<?php echo get_bloginfo('name'); ?>" style="display:none;"></div>

		<script type="text/javascript">
		jQuery(document).ready(function($){
 			$( "#dialog-1" ).dialog({
               autoOpen: false, 
               buttons: {
                  OK: function() {
                  	$(this).dialog("close");
					$('.paypalform').submit();
                  },
                  CANCEL: function() {
                  	$(this).dialog("close");
				  }
               }, 
               width: 600,
            });	
 			$( "#dialog-2" ).dialog({
               autoOpen: false, 
               buttons: {
                  OK: function() {
                  	$(this).dialog("close");
                  }
               }, 
               width: 600,
            });	
            /*		
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
			*/
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
							var booking_info = "<table><tr><td>Check-in:</td><td>" + checkin + "</td></tr><tr><td>Check-out:</td><td>" + checkout + "</td></tr><tr><td>Number of guests:</td><td>" + guests + "</td></tr><tr><td>Price:</td><td>" + price + "</td></tr></table>";
							$('input[name="item_name"]').val("Booking for " + blog_name + " from " + checkin + " to " + checkout + " for " + guests + " guest(s).");
							$('input[name="amount"]').val(price);

							$('#dialog-1').html('The acommodation is available, would you like to book it?<br/>' + booking_info);
							$('#dialog-1').dialog('open');
							//if (confirm("The acommodation is available, would you like to book it?") == true) {
			
							//$('input[name="item_name"]').val("Booking for " + blog_name + " from " + checkin + " to " + checkout + " for " + guests + " guest(s).");
							//$('input[name="amount"]').val(price);
							//$('.paypalform').submit();
     						//return false;			

							//} 						
						} else {
							$('#dialog-2').html("Sorry, the studio is not available. Please try different dates");
							$('#dialog-2').dialog('open');
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
		<?php wp_footer(); ?>
	</body>
</html>
