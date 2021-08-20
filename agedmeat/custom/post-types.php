<?php

add_action('init', 'recipes_post_type');
function recipes_post_type() {
    register_post_type('recipe', array(
	'labels' => array(
            'name' => 'Recipes',
            'singular_name' => 'recipe',
            'add_new' => 'Add New',
			      'add_new_item' => 'Add New Recipe',	
            'edit_item' => 'Edit Recipe',
            'new_item' => 'New Recipe',
            'view_item' => 'View Recipes',
            'search_items' => 'Search Recipes',
            'not_found' => 'No Recipe found',
            'not_found_in_trash' => 'No Recipe found in Trash'
        ),
        'public' => true,
        'menu_icon' => 'dashicons-admin-network',
		//'menu_icon' => get_stylesheet_directory_uri() . '/images/banner-icon.png',
		'menu_position' => 3,
        'supports' => array(
            'title',
            'editor',
            'custom-fields',
            'author',
            'comments',
            'thumbnail',
            'excerpt',
            'revisions'
        ),
        'show_in_rest' => true
    ));
}


?>