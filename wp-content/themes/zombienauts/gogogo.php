<?php get_header(); ?>

    <div id="SUBcover">
        <div id="SUBtitulo">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h1 class="wow bounceInUp">Go Go Go</h1>
                        <p>I want to go to Mars! Take me there!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="form">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2 col-sm-12">

                    <p>So... you've decided you want to come with us to the great red planet. That's awesome! We'll take you there! Just let us know a little bit about yourself right here below:</p>
						<div>
							<!-- do_shortcode: devuelve el contenido de etiquetas shortcode-->
							<?php echo do_shortcode('[contact-form-7 id="76" title="Contact form 1"]'); ?>
						</div>
					</div>

					</div>				
				</div>
		</div>
		
<?php get_footer(); ?>