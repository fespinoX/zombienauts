<?php 
global $wpdb;
wp_register_style( 'swpt_help_css', plugins_url('css/main.css', __FILE__) );
wp_enqueue_style( 'swpt_help_css' );
?>
<h2><img src="<?php echo plugins_url('images/help_icon.png', __FILE__); ?>" class="title_img"/> Help for Testimonial</h2>
<!-- Information below is to know about how to wirte a shortcode -->
<div class="container-help">
	<div class="half-help">
		<p><h3>Widget Information</h3></p>
		<p>1. Widget for testimonial is available in widgets area. <p/>
		<p>2. You can drag and drop it in any widget area.</p>
		<p>3. It has settings to display on frontend. Settings are as follows: </p>
		<p>
			<ul class="parameters">
				<li class="list_parameter"><strong>Number of testimonials to show</strong> - how many testimonials you want to show in sidebar.</li>
				<li class="list_parameter"><strong>Order by</strong> - Either <strong>Ascending</strong> or <strong>Descending</strong>.</li>
				<li class="list_parameter"><strong>Speed</strong> - Slide/Fade animation speed(in milliseconds).</li>
			</ul>
		</p>
		<p><h3>How to add shortcode</h3></p>
		<p>1. The shortcode <strong>[swp-testimonial]</strong> is used to display testimonials on your post or page content.</p>  
		<p>2. It has following parameters: </p>  
		<p>
			<ul class="parameters">
				<li class="list_parameter"><strong>testimonials</strong> - Number of testimonials to show.</li>
				<li class="list_parameter"><strong>order</strong> - Either <strong>asc</strong> (Ascending) or <strong>desc</strong> (descending).</li>
				<li class="list_parameter"><strong>speed</strong> - Slide/Fade animation speed(in milliseconds).</li>
			</ul>
		</p>
		<p>3. When you add the shortcode without any parameters, it will show only one recently added testimonial.</p>

		<p><h3>How to re-order testimonials</h3></p>
		<p>1. From menu go to Re Order.</p>
		<p>2. Drag and drop your testimonial according to your desired order.</p>  
		<p>3. Click on update button and see changes on front end.</p>
	</div>
	<div class="half-help">
		<p><h3>How to add custom css</h3></p>
		<p>1. From menu go to Setting.</p>
		<p>2. Add your custom css in box and click on update css/</p>  
		<p>3. Your custom css will be applied to front end.</p>

		<p><h3>Examples - </h3>
			<ul class="display_effet">
				<li class="list_display" >[swp-testimonial testimonials=2 order=desc dots=false autoplay=false]</li>
				<li class="list_display" >[swp-testimonial testimonials=2 fields='website,client_desg,client_name,company,description']</li>
				<li class="list_display" >[swp-testimonial testimonials=desc speed=3000 num_words=0]</li>
				<li class="list_display" >[swp-testimonial testimonials=2 order=desc speed=3000 autoplay=true autoplaySpeed=1000]</li>
			</ul>
		</p> 
		<p><h3>Available Parameters-</h3> 
			<ul class="display_effet_list" style="width: 400px;">
				<li class="list_display" >dots ( default:true / false ) </li>
				<li class="list_display" >infinite ( true / default:false )</li>
				<li class="list_display" >fields ( default:All 'client_avtar,website,client_desg,client_name,company,description' )</li>
				<li class="list_display" >autoplay ( true / default:false )</li>
				<li class="list_display" >autoplaySpeed ( int in ms )</li>
				<li class="list_display" >speed ( int in ms )</li>
				<li class="list_display" >arrows ( default:true / false )</li>
				<li class="list_display" >draggable ( true / default:false )</li>
				<li class="list_display" >pauseOnHover ( true / default:false )</li>
				<li class="list_display" >adaptiveheight ( default:true / false )</li>
				<li class="list_display" >num_words ( default:30 / 0 for all words )</li>
			</ul>
		</p>  
	</div>
</div>