<?php get_header(); ?>

<div id="SUBcover">
        <div id="SUBtitulo">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h1 class="wow bounceInUp">Results</h1>
                        <p>These are the posts related to <?php echo get_search_query(); ?></p>
                    </div>
                </div>
            </div>
        </div>
</div> 


<div id="news">
        <div class="container">
            <div class="row">
            	<?php 
					if(have_posts()) : 
						while(have_posts()) : the_post(); 
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
				<?php else : ?>
				<div class="col-md-12 sin-resultado">
					<p><?php _e( "Oops, we don't have any results for this search..." ); ?></p>
				</div>	
					<?php endif; ?>

            </div>
        </div>
</div>




<div class="sidebar">
					<?php
						get_sidebar();
					?>
</div>
	
<?php get_footer(); ?>