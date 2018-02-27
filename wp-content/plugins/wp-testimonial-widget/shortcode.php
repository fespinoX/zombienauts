<?php
/**
 * Function swpt_testimonial_shortcode()  is used to create shortcode for plugin.
 * @param array $atts is to pass attributes to the function. 
*/
function swpt_testimonial_shortcode($atts){
	extract(shortcode_atts(array(
        'testimonials' => 2,
        'order' => '',  
        'orderby' => '',
        'category'=>'',
        'fields'=> 'client_avtar,website,client_desg,client_name,company,description',
        'speed' => 500,
        'dots' => 'true',
        'pauseOnHover' => 'false',
        'draggable' => 'false',
        'infinite' => 'false',
        'autoplay' => 'false',
        'arrows' => 'true',
        'autoplaySpeed' => 4000,
        'adaptiveheight' => 'true',
        'num_words' => 30,
    ), $atts));
    $fade = 'true';
    $shortcodeData = swpt_widget_shortcode_output($testimonials, $order, $orderby,$category,$fields,$num_words);
    $uniq ='_'.strtotime(date('D-m-Y')).'_'.rand(1,9999);
    ob_start();
    ?>
    <script type="text/javascript">  
        jQuery(document).ready(function($){
            $('.content_display_short').slick({
                dots: ('<?php echo $dots; ?>' == 'true'),
                infinite: ('<?php echo $infinite; ?>' == 'true'),
                autoplay : ('<?php echo $autoplay; ?>' == 'true'),
                autoplaySpeed : parseInt('<?php echo $autoplaySpeed; ?>'),
                speed: parseInt('<?php echo $speed; ?>'),
                fade:('<?php echo $fade; ?>' == 'true'),
                cssEase: 'linear',
                slidesToShow: 1,
                adaptiveHeight: ('<?php echo $adaptiveheight; ?>' == 'true'),
                arrows : ('<?php echo $arrows; ?>' == 'true'),
                draggable : ('<?php echo $draggable; ?>' == 'true'),
                pauseOnHover : ('<?php echo $pauseOnHover; ?>' == 'true'),
            });
        }); 
    </script>
    <div id="short_testi_slider<?php echo $uniq; ?>" class='content_display_short'>
        <?php
        echo $shortcodeData;
        ?>
    </div>
<?php
$shortcodeData = ob_get_contents();	
ob_end_clean();
return $shortcodeData;
}

/**
* Function swpt_register_shortcodes()  is used to register shortcode.
*/
function swpt_register_shortcodes(){
    add_shortcode('swp-testimonial', 'swpt_testimonial_shortcode');
}
add_action( 'init', 'swpt_register_shortcodes');
?>