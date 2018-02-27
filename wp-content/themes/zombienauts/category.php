<?php get_header(); ?>

<div id="SUBcover">
        <div id="SUBtitulo">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h1 class="wow bounceInUp">News</h1>
                        <p class="page-title">These are all the news related to <span><?php echo single_cat_title(); ?></span></p>
                    </div>
                </div>
            </div>
        </div>
</div> 

<div id="news">
        <div class="container">


					<div class="row">
						<?php 
					while (have_posts()) : the_post(); 
				?>
						
						<div class="col-sm-6 col-md-4 col-xs-12">
                    <div class="portaImagenNoticia">
                        <a href="<?php the_permalink(); ?>" class="tituloNoticia"><h2 class="hover-barrido-der"><?php the_title(); ?></h2></a>
                        <br>
						<div class="categoriaNoticia"><?php the_category(); ?></div>
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

<div class="sidebar">
					<?php
						get_sidebar();
					?>
</div>


<?php get_footer(); ?>