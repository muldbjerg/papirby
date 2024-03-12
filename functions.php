<?php

// Remove scripts and styles from parent theme
add_action( 'wp_enqueue_scripts', 'child_deregister_styles_scripts', 999 );
function child_deregister_styles_scripts() {
	 wp_dequeue_style( 'storefront-style' );
	 wp_dequeue_style( 'storefront-icons' );
}

// include custom jQuery
function remove_jquery() {
	// wp_deregister_script('jquery');
}
add_action('wp_enqueue_scripts', 'remove_jquery');


function add_styling(){
  wp_enqueue_style( 'style', get_stylesheet_uri() );
}
add_action('wp_enqueue_scripts', 'add_styling');

function add_custom_menus() {
    register_nav_menu('main-menu',__( 'Main Menu' ));
}
add_action( 'init', 'add_custom_menus' );



function create_posttype() {
  
    register_post_type( 'enheder',
    // CPT Options
        array(
            'labels' => array(
                'name' => __( 'Enheder' ),
                'singular_name' => __( 'Enhed' ),
				'add_new_item' => __( 'Add New Enhed' ),
				'edit_item' => __( 'Edit Enhed' ),
				'update_item' => __( 'Update Enhed' ),
				'search_items' => __( 'Search Enhed' ),
            ),
            'public' => true,
            'has_archive' => false,
            'rewrite' => array('slug' => 'enheder'),
            'show_in_rest' => true,
			'taxonomies' => array( 'afdeling' ),
  
        )
    );
}
// Hooking up our function to theme setup
add_action( 'init', 'create_posttype' );

function add_custom_taxonomies() {
  // Add new "Locations" taxonomy to Posts
  register_taxonomy('afdelinger', array('post', 'enheder'), array(
    // Hierarchical taxonomy (like categories)
    'hierarchical' => true,
    // This array of options controls the labels displayed in the WordPress Admin UI
    'labels' => array(
      'name' => _x( 'Afdelinger', 'taxonomy general name' ),
      'singular_name' => _x( 'Afdeling', 'taxonomy singular name' ),
      'search_items' =>  __( 'Search afdelinger' ),
      'all_items' => __( 'All afdelinger' ),
      'parent_item' => __( 'Parent afdeling' ),
      'parent_item_colon' => __( 'Parent afdeling:' ),
      'edit_item' => __( 'Edit afdeling' ),
      'update_item' => __( 'Update afdeling' ),
      'add_new_item' => __( 'Add New afdeling' ),
      'new_item_name' => __( 'New afdeling Name' ),
      'menu_name' => __( 'Afdelinger' ),
    ),
    // Control the slugs used for this taxonomy
    'rewrite' => array(
      'slug' => 'afdelinger', // This controls the base slug that will display before each term
      'with_front' => false, // Don't display the category base before "/locations/"
      'hierarchical' => true // This will allow URL's like "/locations/boston/cambridge/"
    ),
  ));
}
add_action( 'init', 'add_custom_taxonomies', 0 );
