<?php get_header(); ?>



    <main>

        <?php
            if(is_page('mars'))
                get_template_part("mars");
            elseif(is_page('news'))
                get_template_part("news");
            elseif(is_page('gogogo'))
                get_template_part("gogogo");
            elseif(is_page('about'))
                get_template_part("about");
            else
                get_template_part("inicio");
        ?>

        </main>




<?php get_footer(); ?>
