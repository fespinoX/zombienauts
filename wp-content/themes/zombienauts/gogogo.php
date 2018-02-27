<?php get_header(); ?>

<!--PRESENTACION CONTACTO-->
		<div id="presentacion-contacto">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<h2>Encontranos</h2>
					</div>
				</div>
			</div>
		</div>
		<!--CONTACTO-->
		<div id="contacto">
			<div class="container">
				<div class="row">
					<div class="col-md-6">
						<h3>Envianos tu consulta</h3>
						<div>
							<!-- do_shortcode: devuelve el contenido de etiquetas shortcode-->
							<?php echo do_shortcode('[contact-form-7 id="76" title="Contact form 1"]'); ?>
						</div>
					</div>
					<div class="col-md-6" id="locales">
						<div class="row">

						<div class="row">
							<div class="col-md-12 hidden-xs hidden-sm">
								<?php echo wp_get_attachment_image(94, '', false, array( "class" => "img-responsive", "alt" => get_post_meta(94, '_wp_attachment_image_alt', true)));?>
							</div>
						</div>
					</div>				
				</div>
			</div>
		</div>
		
<?php get_footer(); ?>