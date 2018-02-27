<?php get_header(); ?>


<!--RESULTADOS POSTRES-->
<div id="resultados">
	<div class="container">
		<div class="row">
			<div class="col-md-9">
				<div class="row">
					<div class="col-xs-12">
						<p class="page-title">Resultados para: <span><?php echo get_search_query(); ?></span></p>
					</div>
				</div>
				
				<div class="row cont-postres">
					<?php 
						if(have_posts()) : 
							while(have_posts()) : the_post(); 
					?>
						<div class="col-sm-6 col-md-4 unpost">
							<!--formato para mostrar el post-->
							<div class="row">	
								<div class="col-md-12">
								<?php
									if ( has_post_thumbnail() ) {
										the_post_thumbnail('full', array( 'class' => 'img-responsive' ));
									}else{
										echo wp_get_attachment_image(145, '', false, array( "class" => "img-responsive", "alt" => get_post_meta(145, '_wp_attachment_image_alt', true)));
									}
								?>
								</div>
							</div>
							<div class="row">	
								<div class="col-md-12 padre2">
									<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
								</div>
							</div>	
							<div class="row extracto">	
								<div class="col-md-12">
									<?php echo get_excerpt(100); ?>
								</div>
							</div>
						</div>
						<?php endwhile; ?>
					<?php else : ?>
						<div class="col-md-12 sin-resultado">
							<p>
								<?php _e( 'Lo sentimos, no hay resultados para esa búsqueda'); ?>
							</p>
						</div>	
					<?php endif; ?>
				</div>	
			</div>
			<div class="col-md-3 hidden-xs hidden-sm">
			<?php
				get_sidebar();
			?>
			</div>
		</div>
	</div>
</div>
	
<?php get_footer(); ?>