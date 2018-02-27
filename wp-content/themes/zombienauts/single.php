<?php get_header(); ?>

    <div id="SUBcover">
        <div id="SUBtitulo">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h1 class="wow bounceInUp postTitulo"><?php the_title(); ?></h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

	<div id="newsDetalle">
		<div class="container">
			<div class="row">
				<div class="col-md-12" id="">
					<?php
						while(have_posts()):
							the_post();
					?>
							
						<?php
							if(has_post_thumbnail())
								the_post_thumbnail();
							else{
								echo wp_get_attachment_image(145, '', false, array( "class" => "img-responsive", "alt" => get_post_meta(145, '_wp_attachment_image_alt', true)));
							}
						?>	

						<?php
							the_content();
						?>							
				</div>

				<?php
					endwhile;
				?>

				<div class="col-xs-12">
					<?php
						comments_template();
					?>
				</div>
			</div>	
		</div>

	</div>





<div class="sidebar">
					<?php
						get_sidebar();
					?>
</div>

<?php get_footer(); ?>
