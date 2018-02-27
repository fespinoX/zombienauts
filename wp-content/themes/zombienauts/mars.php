<div id="SUBcover2">
        <div id="SUBtitulo">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h1 class="wow bounceInUp">Mars</h1>
                        <p>See what the great red planet has in line for you</p>
                    </div>
                </div>
            </div>
        </div>
</div> 

<div id="mars">
    <div class="row">
        
        <?php $custom_query = new WP_Query('cat=2'); // exclude category 9
			while($custom_query->have_posts()) : $custom_query->the_post(); ?>

        <div>
            <div class="portaImagenMars">
                    <?php
                        if ( has_post_thumbnail() ) {
                            the_post_thumbnail('full', array( 'class' => 'img-responsive' ));
                        }else{
                            echo wp_get_attachment_image(145, '', false, array( "class" => "img-responsive", "alt" => get_post_meta(145, '_wp_attachment_image_alt', true)));
                        }
                    ?>        
            </div>
            <div class="portaTexto">
                <h2><?php the_title(); ?></h2>
                <p><?php the_content(); ?></p>
            </div> 
        </div>

                <?php endwhile; ?>
<?php wp_reset_postdata(); // reset the query ?>

    </div>
</div>
