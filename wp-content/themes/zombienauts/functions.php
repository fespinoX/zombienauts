<?php

//MENU
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

//Exclude Mars from search
function SearchFilter($query) {
	if ($query->is_search) {
		$query->set('cat','-2');
	}
	return $query;
}
add_filter('pre_get_posts','SearchFilter'); 
 


//Extract limit
function get_excerpt($count){  
    $permalink = get_permalink($post->ID);
    $excerpt = get_the_content(); 
    $excerpt = strip_tags($excerpt);
    $excerpt = substr($excerpt, 0, $count);
    $excerpt = substr($excerpt, 0, strripos($excerpt, " "));
    $excerpt = $excerpt.'...';
    return $excerpt;
}
 
//Posts thumbnails
add_theme_support('post-thumbnails');
add_image_size('thumbnail',730,487,true);




