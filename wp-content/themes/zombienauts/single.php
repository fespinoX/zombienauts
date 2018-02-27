<?php get_header(); ?>

<!-- DETALLE -->
	<div id="detalle">
		<div class="container">
			<div class="row">
				<div class="col-md-8" id="detalle_postre">
					<?php
						while(have_posts()):
							the_post();
					?>
					<div class="row">
						<div class="col-md-12">
							<h2 class="entry-title"><?php the_title(); ?></h2>
						</div>
					</div>
					<div class="row detalle">	
						<div class="col-md-7 post-thumbnail">
							<?php
								if(has_post_thumbnail())
									the_post_thumbnail();
								else{
									echo wp_get_attachment_image(145, '', false, array( "class" => "img-responsive", "alt" => get_post_meta(145, '_wp_attachment_image_alt', true)));
								}
							?>	
						</div>
						<div class="col-md-5 post-contenido deco_top">
							<?php
								the_content();
							?>							
						</div>
					</div>	
					<?php
						endwhile;
					?>
					
					<div class="row">
						<div class="col-xs-12">
							<?php
								comments_template();
							?>
						</div>
					</div>	
				</div>
				
				<div class="col-md-3 hidden-xs hidden-sm col-md-offset-1">
				<?php
					get_sidebar();
				?>
				</div>
			</div>
		</div>
	</div>

<?php get_footer(); ?>
