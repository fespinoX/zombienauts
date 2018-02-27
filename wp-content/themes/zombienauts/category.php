<?php get_header(); ?>


<!--POSTRES-->
<div id="categorias">
	<div class="container">
		<div class="row">
			<div class="col-md-9">
				<div class="row">
					<div class="col-xs-12">
						<p class="page-title">Estás viendo la categoría: <span><?php echo single_cat_title(); ?></span></p>
					</div>
				</div>	
				<div class="row cont-postres">
				<?php 
					while (have_posts()) : the_post(); 
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
						<div class="row post-titulo">	
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
				</div><!--/.row cont-postres-->
			</div><!--/ .col-md-9-->
			<div class="col-md-3 hidden-xs hidden-sm">
			<?php
				get_sidebar();
			?>
			</div>
		</div>
	</div>
</div>

<?php get_footer(); ?>