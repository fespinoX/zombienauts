<?php

//NAVBAR
//chequeamos que exista la función register_nav_menus y la definimos
if(function_exists('register_nav_menus')){		
	register_nav_menus(
		array(
          'navbar' => 'menu'
        )
	);
}

//SIDEBAR
if(function_exists('register_sidebar')){
	register_sidebar(
	    array( 
			'name' 			=> 'sidebar',  
			'id' 			=> 'sidebar',
			'description'	=> 'Sidebar de la sección Postres',
			'class' 		=> 'sidebar',
			'before_widget'	=> '<aside id="%1$s" class="widget %2$s">', 
			'after_widget'	=> '</aside>', 
			'before_title'	=> '<h2>', 
			'after_title'	=> '</h2>'
		)
	);
}

/*Excluyo la categoría TIPS del widget de CATEGORIAS de WordPress*/
function exclude_widget_categories($args) {
    $excluded = '6';
    $args['exclude'] = $excluded;
 
    return $args;
}
add_filter( 'widget_categories_args', 'exclude_widget_categories', 10, 1 ); // para el formato de lista

/*Excluyo la categoría TIPS del widget del BUSCADOR de WordPress*/
function SearchFilter($query) {
	if ($query->is_search) {
		$query->set('cat','-6');
	}
	return $query;
}
add_filter('pre_get_posts','SearchFilter'); 
 
//Limito la cantidad de caracteres del extracto
function get_excerpt($count){  
    $permalink = get_permalink($post->ID);
    $excerpt = get_the_content(); 
    $excerpt = strip_tags($excerpt);
    $excerpt = substr($excerpt, 0, $count);
    $excerpt = substr($excerpt, 0, strripos($excerpt, " "));
    $excerpt = $excerpt.'...';
    //$excerpt = $excerpt.'... <a href="'.$permalink.'">leer mas</a>';
    return $excerpt;
}
 
//POSTEOS
add_theme_support('post-thumbnails');
add_image_size('thumbnail',730,487,true);




