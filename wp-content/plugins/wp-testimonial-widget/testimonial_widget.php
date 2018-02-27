<?php 
/**
 * Class SWP_Testimonial_Widget is to display widget.
*/
class SWP_Testimonial_Widget extends WP_Widget {

	function SWP_Testimonial_Widget() {
		parent::__construct(false,$name="Testimonial Widget",array('description'=>'Display Testimonials'));
	}
	/**
	 * Function widget() contains data to show on frontend.
	 * @param array $args of widget area.  
	 * @param array $instance current settings of widget.
	*/
	function widget($args,$instance) {
		global $post;
		global $wp_query;
		
		$widget_title = $instance['widget_title'];
		$posts = $instance['post_no'];
		$order = $instance['post_sorting'];
		$order_by = $instance['order_by'];
		$time = (isset($instance['speed']))?$instance['speed']:500;
		$category = $instance['category_name'];
		$fields = $instance['fields'];

		$dots = (isset($instance['dots']))?$instance['dots']:'true';
		$infinite = (isset($instance['infinite']))?$instance['infinite']:'false';
		$autoplay = (isset($instance['autoplay']))?$instance['autoplay']:'true';
		$autoplaySpeed = (isset($instance['autoplaySpeed']))?$instance['autoplaySpeed']:4000;
		$arrows = (isset($instance['arrows']))?$instance['arrows']:'true';
		$draggable = (isset($instance['draggable']))?$instance['draggable']:'false';
		$pauseOnHover = (isset($instance['pauseOnHover']))?$instance['pauseOnHover']:'false';
		$fade = 'true';
		$num_words = (isset($instance['num_words']))?$instance['num_words']:30;
		$adaptiveheight = (isset($instance['adaptiveheight']))?$instance['adaptiveheight']:'true';

		$uniq ='_'.strtotime(date('D-m-Y')).'_'.rand(1,9999);
		?>
			<script type="text/javascript">
				jQuery(document).ready(function($) {
                	$('.content_display').slick({
                		dots: ('<?php echo $dots; ?>' == 'true'),
                		infinite: ('<?php echo $infinite; ?>' == 'true'),
                		autoplay : ('<?php echo $autoplay; ?>' == 'true'),
                		autoplaySpeed : parseInt('<?php echo $autoplaySpeed; ?>'),
                		speed: parseInt('<?php echo $time; ?>'),
                		fade:('<?php echo $fade; ?>' == 'true'),  // should be vise versa on vertical
					    cssEase: 'linear',
                		slidesToShow: 1,
                		adaptiveHeight: ('<?php echo $adaptiveheight; ?>' == 'true'),
					    arrows : ('<?php echo $arrows; ?>' == 'true'),
					    draggable : ('<?php echo $draggable; ?>' == 'true'),
					    pauseOnHover : ('<?php echo $pauseOnHover; ?>' == 'true'),
                	});
				});	
		    </script>
		<?php 
		if ( isset( $args['before_widget'] ) && !empty( $args['before_widget'] )) {
			echo $args['before_widget'];
		} elseif(isset($before_widget)) {
			echo $before_widget; 
		}
		

		if(!empty($widget_title)) {
			echo $before_title.$widget_title.$after_title;
		} 
		?>
		<div class='content_display' id="testi_slider<?php echo $uniq; ?>">	
			<?php 
				$output_data = swpt_widget_shortcode_output($posts,$order,$order_by,$category,$fields,$num_words);
				echo $output_data;
			?>
		</div>
		<?php 
		if ( isset($args['after_widget']) && !empty($args['after_widget'])) {
			echo $args['after_widget'];
		} else {
			echo $after_widget; 
		}
	}
	/**
	 * Function update() is to save inserted data.
	 * @param array $new_instance is to store updated values.
	 * @param array $old_instance contains old values.
	*/
	function update($new_instance,$old_instance){
		global $wpdb;
		
		$instance = $old_instance;
		$instance['widget_title'] = $new_instance['widget_title'];
		$instance['post_sorting'] = $new_instance['post_sorting'];
		$instance['order_by'] = $new_instance['order_by'];
		$instance['category_name'] = $new_instance['category_name'];
		$instance['fields'] = $new_instance['fields'];
		$instance['dots'] = $new_instance['dots'];
		$instance['infinite'] = $new_instance['infinite'];
		$instance['autoplay'] = $new_instance['autoplay'];
		$instance['autoplaySpeed'] = $new_instance['autoplaySpeed'];
		$instance['arrows'] = $new_instance['arrows'];
		$instance['draggable'] = $new_instance['draggable'];
		$instance['pauseOnHover'] = $new_instance['pauseOnHover'];
		$instance['adaptiveheight'] = $new_instance['adaptiveheight'];
		$instance['num_words'] = $new_instance['num_words'];

		if(!empty($new_instance['post_no'])) {
			$postCount = $new_instance['post_no'];
		} else{
			$postCount = 1;
		}
		$instance['post_no']=$postCount;

		if(!empty($new_instance['speed'])) {
			$effectSpeed = $new_instance['speed'];
		} else {
			$effectSpeed = 1000;
		}
		$instance['speed'] = $effectSpeed;

		if(!empty($new_instance['category_name'])) {
			$category = $new_instance['category_name'];
		} else {
			$category = 'all';
		}

		if(!empty($new_instance['fields'])) {
			$fields = implode(",",$new_instance['fields']);
		}
		$instance['fields']=$fields;
				
		return $instance;
	}

	/**
	 * Function form() displays form in the widget.
	 * @param array $instance current settings of widget.
	*/
	function form($instance) {
		global $wpdb;
		if(array_key_exists('widget_title', $instance)) {
			$widget_title = $instance['widget_title'];
		} else{
			$widget_title = '';	
		}
		
		if(array_key_exists('post_sorting', $instance)) {
			$order = $instance['post_sorting'];
		} else {
			$order = '';	
		}

		if(array_key_exists('category_name', $instance)) {
			$category = $instance['category_name'];
		} else {
			$category = '';	
		}

		if(array_key_exists('fields', $instance)) {
			$fields =  explode(",",$instance['fields']);
		} else {
			$fields = '';	
		}
		
		if(array_key_exists('order_by', $instance)) {
			$order_by = $instance['order_by'];
		} else {
			$order_by = '';	
		}
		
		if(!empty($instance['post_no'])) {
			$posts = $instance['post_no'];
		} else {
			$posts = 1;
		}
		
		if(!empty($instance['speed'])) {
			$time = $instance['speed'];
		} else {
			$time = 1000;
		}

		$adaptiveheight = $dots = $arrows = 'true';
		$infinite = $draggable = $pauseOnHover = $vertical = 'false';
		$autoplaySpeed = 3000;
		$num_words = 30;

		if(!empty($instance['dots']))
			$dots = $instance['dots'];

		if(!empty($instance['infinite']))
			$infinite = $instance['infinite'];

		if(!empty($instance['autoplay'])) {
			$autoplay = $instance['autoplay'];
		} else {
			$autoplay = 'true';
		}

		if(!empty($instance['arrows']))
			$arrows = $instance['arrows'];

		if(!empty($instance['draggable']))
			$draggable = $instance['draggable'];

		if(!empty($instance['pauseOnHover']))
			$pauseOnHover = $instance['pauseOnHover'];

		if(!empty($instance['autoplaySpeed']))
			$autoplaySpeed = $instance['autoplaySpeed'];

		if(!empty($instance['adaptiveheight']))
			$adaptiveheight = $instance['adaptiveheight'];

		if( isset($instance['num_words']) && (!empty($instance['num_words'])  || $instance['num_words'] == 0 ))
			$num_words	= $instance['num_words'];
		?>
		<p>
			<label for="<?php echo  $this->get_field_id('widget_title'); ?>">Title</label>
			<input type="text" name="<?php echo $this->get_field_name('widget_title'); ?>" id="<?php echo $this->get_field_id('widget_title'); ?>" value="<?php echo $widget_title; ?>" class="widefat">
		</p>
		<p class="helplink">
			<a href="<?php echo home_url('/wp-admin/admin.php?page=help'); ?>">Help</a>
		</p>
		<div>
			<p class="custom_widget_size">
				<label for="<?php echo $this->get_field_id('post_no'); ?>">Show</label>
				<input type="text" name="<?php echo $this->get_field_name('post_no'); ?>" id="<?php echo $this->get_field_id('post_no'); ?>" value="<?php echo $posts; ?>" >
			</p>
			<p class="custom_widget_size">
				<label for="<?php echo $this->get_field_id('num_words'); ?>">Show Words</label>
				<input type="text" name="<?php echo $this->get_field_name('num_words'); ?>" id="<?php echo $this->get_field_id('num_words'); ?>" value="<?php echo $num_words; ?>" size="5">
			</p>
			<p class="custom_widget_size">
				<label for="<?php echo $this->get_field_id('category_name'); ?>">Category </label>
				<select name="<?php echo $this->get_field_name('category_name'); ?>" id="<?php echo $this->get_field_id('category_name'); ?>">
					<option value="all">All</option>
					<?php $arrCats = getCategory(); ?>
					<?php foreach ($arrCats as $key => $value): ?>
					<option <?php if($category == $value['id']): ?> selected <?php endif; ?> value="<?php echo $value['id']; ?>"><?php echo $value['category_name']; ?></option>
					<?php endforeach ?>
				</select>
			</p>
			<p class="custom_widget_size ">
				<label for="<?php echo $this->get_field_id('post_sorting'); ?>">Order </label>
				<select name="<?php echo $this->get_field_name('post_sorting'); ?>" id="<?php echo $this->get_field_id('post_sorting'); ?>">
					<option value="asc" <?php if($order=='asc' || $order == "") { ?> selected=selected <?php } ?>>Ascending</option>
					<option value="desc" <?php if($order=='desc') { ?> selected=selected <?php } ?>>Descending</option>
				</select>
			</p>
			<p class="custom_widget_size">
				<label for="<?php echo $this->get_field_id('order_by'); ?>">Order by </label>
				<select name="<?php echo $this->get_field_name('order_by'); ?>" id="<?php echo $this->get_field_id('order_by'); ?>">
					<option value="id" <?php if($order_by=='id' || $order_by == "") { ?> selected=selected <?php } ?>>ID</option>
					<option value="company" <?php if($order_by=='company') { ?> selected=selected <?php } ?>>Company</option>
					<option value="description" <?php if($order_by=='description') { ?> selected=selected <?php } ?>>Description</option>
				</select>
			</p>		
			<p class="custom_widget_size">
				<label for="<?php echo $this->get_field_id('dots'); ?>">Dots</label>
				<select name="<?php echo $this->get_field_name('dots'); ?>" id="<?php echo $this->get_field_id('dots'); ?>">
					<?php
						$arrEffect = array("true","false"); 
						foreach($arrEffect as $strKey => $strValue)
						{
					?>
					<option value="<?php echo $strValue; ?>" <?php if($dots==$strValue) { ?> selected=selected <?php } ?>><?php echo ucfirst($strValue); ?></option>
					<?php } ?>
				</select>
			</p>
			<p class="custom_widget_size">
				<label for="<?php echo $this->get_field_id('infinite'); ?>">Infinite</label>
				<select name="<?php echo $this->get_field_name('infinite'); ?>" id="<?php echo $this->get_field_id('infinite'); ?>">
					<?php
						$arrEffect = array("true","false"); 
						foreach($arrEffect as $strKey => $strValue)
						{
					?>
					<option value="<?php echo $strValue; ?>" <?php if($infinite==$strValue) { ?> selected=selected <?php } ?>><?php echo ucfirst($strValue); ?></option>
					<?php } ?>
				</select>
			</p>
			<p class="custom_widget_size">
				<label for="<?php echo $this->get_field_id('autoplay'); ?>">Autoplay</label>
				<select name="<?php echo $this->get_field_name('autoplay'); ?>" id="<?php echo $this->get_field_id('autoplay'); ?>">
					<?php
						$arrEffect = array("true","false"); 
						foreach($arrEffect as $strKey => $strValue)
						{
					?>
					<option value="<?php echo $strValue; ?>" <?php if($autoplay==$strValue) { ?> selected=selected <?php } ?>><?php echo ucfirst($strValue); ?></option>
					<?php } ?>
				</select>
			</p>
			<p class="custom_widget_size">
				<label for="<?php echo $this->get_field_id('autoplaySpeed'); ?>">Autoplay Speed (ms)</label>
				<input type="text" name="<?php echo $this->get_field_name('autoplaySpeed'); ?>" id="<?php echo $this->get_field_id('autoplaySpeed'); ?>" value="<?php echo $autoplaySpeed; ?>" size="5">
			</p>
			<p class="custom_widget_size">
				<label for="<?php echo $this->get_field_id('arrows'); ?>">Arrows</label>
				<select name="<?php echo $this->get_field_name('arrows'); ?>" id="<?php echo $this->get_field_id('arrows'); ?>"> <?php
						$arrEffect = array("true","false"); 
						foreach($arrEffect as $strKey => $strValue)
						{ ?>
					<option value="<?php echo $strValue; ?>" <?php if($arrows==$strValue) { ?> selected=selected <?php } ?>><?php echo ucfirst($strValue); ?></option>
					<?php } ?>
				</select>
			</p>
			<p class="custom_widget_size">
				<label for="<?php echo $this->get_field_id('draggable'); ?>">Draggable</label>
				<select name="<?php echo $this->get_field_name('draggable'); ?>" id="<?php echo $this->get_field_id('draggable'); ?>"> <?php
					$arrEffect = array("true","false"); 
					foreach($arrEffect as $strKey => $strValue) { ?>
						<option value="<?php echo $strValue; ?>" <?php if($draggable==$strValue) { ?> selected=selected <?php } ?>><?php echo ucfirst($strValue); ?></option> <?php 
					} ?>
				</select>
			</p>
			<p class="custom_widget_size">
				<label for="<?php echo $this->get_field_id('pauseOnHover'); ?>">Pause On Hover</label>
				<select name="<?php echo $this->get_field_name('pauseOnHover'); ?>" id="<?php echo $this->get_field_id('pauseOnHover'); ?>"> <?php
						$arrEffect = array("true","false"); 
						foreach($arrEffect as $strKey => $strValue)
						{ ?>
					<option value="<?php echo $strValue; ?>" <?php if($pauseOnHover==$strValue) { ?> selected=selected <?php } ?>><?php echo ucfirst($strValue); ?></option>
					<?php } ?>
				</select>
			</p>
			<p class="custom_widget_size">
				<label for="<?php echo $this->get_field_id('adaptiveheight'); ?>">Adaptive Height</label>
				<select name="<?php echo $this->get_field_name('adaptiveheight'); ?>" id="<?php echo $this->get_field_id('adaptiveheight'); ?>"> <?php
					$arrEffect = array("true","false"); 
					foreach($arrEffect as $strKey => $strValue)
					{ ?>
					<option value="<?php echo $strValue; ?>" <?php if($adaptiveheight==$strValue) { ?> selected=selected <?php } ?>><?php echo ucfirst($strValue); ?></option>
					<?php } ?>
				</select>
			</p>
			<p class="custom_widget_size">
				<label for="<?php echo $this->get_field_id('speed'); ?>">Speed (ms)</label>
				<input type="text" name="<?php echo $this->get_field_name('speed'); ?>" id="<?php echo $this->get_field_id('speed'); ?>" value="<?php echo $time; ?>" size="5">
			</p>
			<p class="select-fields">
				<label>Select Fields To Show</label>
				<div class="checkbox-widget-group">
					<table style="width:100%">
						<tr>
							<td style="width:50%">
								<label for="fields">Testimonial</label>
							</td>
							<td style="width:50%">
								<input type="checkbox" checked disabled  name="<?php echo $this->get_field_name('fields'); ?>" id="<?php echo $this->get_field_id('fields'); ?>1" value="description">
							</td>
						</tr>
						<tr>
							<td style="width:50%">
								<label for="<?php echo $this->get_field_id('fields'); ?>2">Company Name</label>
							</td>
							<td style="width:50%">
								<input type="checkbox" <?php if(isset($fields) && (!empty($fields)) ): if(in_array("company",$fields)): ?>  checked <?php endif; else: ?> checked <?php endif; ?> name="<?php echo $this->get_field_name('fields'); ?>[]" id="<?php echo $this->get_field_id('fields'); ?>2" value="company" >
							</td>
						</tr>
						<tr>
							<td style="width:50%">
								<label for="<?php echo $this->get_field_id('fields'); ?>3">Author Name</label>
							</td>
							<td style="width:50%">
								<input type="checkbox" <?php if(isset($fields) && (!empty($fields)) ): if(in_array("client_name",$fields)): ?>  checked <?php endif; else: ?> checked <?php endif; ?> name="<?php echo $this->get_field_name('fields'); ?>[]" id="<?php echo $this->get_field_id('fields'); ?>3" value="client_name">
							</td>
						</tr>
						<tr>
							<td style="width:50%">
								<label for="<?php echo $this->get_field_id('fields'); ?>4">Designation</label>
							</td>
							<td style="width:50%">
								<input type="checkbox" <?php if(isset($fields) && (!empty($fields)) ): if(in_array("client_desg",$fields)): ?>  checked <?php endif; else: ?> checked <?php endif; ?> name="<?php echo $this->get_field_name('fields'); ?>[]" id="<?php echo $this->get_field_id('fields'); ?>4" value="client_desg">
							</td>
						</tr>
						<tr>
							<td style="width:50%">
								<label for="<?php echo $this->get_field_id('fields'); ?>5">Website</label>
							</td>
							<td style="width:50%">
								<input type="checkbox" <?php if(isset($fields) && (!empty($fields)) ): if(in_array("website",$fields)): ?>  checked <?php endif; else: ?> checked <?php endif; ?> name="<?php echo $this->get_field_name('fields'); ?>[]" id="<?php echo $this->get_field_id('fields'); ?>5" value="website">
							</td>
						</tr>
						<tr>
							<td style="width:50%">
								<label for="<?php echo $this->get_field_id('fields'); ?>6">Image</label>
							</td>
							<td style="width:50%">
								<input type="checkbox" <?php if(isset($fields) && (!empty($fields)) ): if(in_array("client_avtar",$fields)): ?>  checked <?php endif; else: ?> checked <?php endif; ?> name="<?php echo $this->get_field_name('fields'); ?>[]" id="<?php echo $this->get_field_id('fields'); ?>6" value="client_avtar">
							</td>
						</tr>
					</table>
				</div>
			</p>
		</div> <?php
	}
} ?>