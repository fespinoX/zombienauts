<div id="SUBcover">
        <div id="SUBtitulo">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h1 class="wow bounceInUp">News</h1>
                        <p>But enough about us.. What's new with you?</p>
                    </div>
                </div>
            </div>
        </div>
</div> 

<div id="news">
        <div class="container">
            <div class="row">
            	<?php $custom_query = new WP_Query('cat=2'); // exclude category 9
				while($custom_query->have_posts()) : $custom_query->the_post(); ?>

                <div class="col-sm-6 col-md-4 col-xs-12">
                    <div class="portaImagenNoticia">
                        <a href="<?php the_permalink(); ?>" class="tituloNoticia"><h2 class="hover-barrido-der"><?php the_title(); ?></h2></a>
                        <a href="#" class="categoriaNoticia">Categoría</a>
                    </div>
                    <div class="portaTexto">
                        <?php echo get_excerpt(100); ?>
                    </div> 
                </div>

                <?php endwhile; ?>
<?php wp_reset_postdata(); // reset the query ?>

            </div>
        </div>
</div>
