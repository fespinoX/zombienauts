<?php	
	global $wpdb;
	$strTbl = $wpdb->prefix."swp_testimonial";
	$arrTestimonails = $wpdb->get_results("SELECT id,client_name,orders FROM $strTbl ORDER BY orders",ARRAY_A);
?>
<h1>Testimonials Re-Order</h1>
<div id="ajax-response">
	
</div>
<div id="order-post-type">
	<ul id="sortable">
	<?php
	foreach ($arrTestimonails as $value) {
	?>
		<li id="testimonail_<?php echo $value['id']; ?>">
			<span><?php echo $value['client_name']; ?></span>
		</li>
	<?php
	}
	?>
	</ul>
</div>
<p class="submit">
	<a class="button-primary" id="save-order" href="javascript: void(0)">Update</a>
</p>
<script>
jQuery(document).ready(function($) {
	
	jQuery( "#sortable" ).sortable();
	jQuery( "#sortable" ).disableSelection();

	jQuery("#save-order").bind( "click", function() {
        jQuery("html, body").animate({ scrollTop: 0 }, "fast");
	        jQuery.post( ajaxurl, { action:'update-testimonail-order', order:jQuery("#sortable").sortable("serialize") }, function() {
	            jQuery("#ajax-response").html('<div class="message updated fade"><p>Testimonails Order Updated</p></div>');
	            jQuery("#ajax-response div").delay(3000).hide("slow");
	        });
    	});

});
</script>