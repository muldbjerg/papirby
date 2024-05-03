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
  wp_enqueue_style( 'style-main', get_stylesheet_directory_uri() . '/main.css' );
  // echo get_stylesheet_directory_uri();
  // wp_enqueue_style( 'style', get_stylesheet_uri()  );
}
add_action('wp_enqueue_scripts', 'add_styling');

function add_custom_menus() {
	unregister_nav_menu('primary');
	unregister_nav_menu('secondary');
	unregister_nav_menu('handheld');

    register_nav_menu('main-menu',__( 'Main Menu' ));
    register_nav_menu('footer-1-menu',__( 'Footer Menu 1' ));
    register_nav_menu('footer-2-menu',__( 'Footer Menu 2' ));
}
add_action( 'init', 'add_custom_menus' );


function home_body_class($classes) {
    if ( is_front_page() ) {
        $classes[] = 'home';
    }
    return $classes;
}
add_filter( 'body_class', 'home_body_class' );


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
          'hierarchical' => true,
          'supports' => array('title', 'editor', 'page-attributes')
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
      'slug' => 'afdel', // This controls the base slug that will display before each term
      'with_front' => false, // Don't display the category base before "/locations/"
      'hierarchical' => true // This will allow URL's like "/locations/boston/cambridge/"
    ),
  ));
}
add_action( 'init', 'add_custom_taxonomies', 0 );


// ADVANCHED CUSTOM FIELDS
// include_once('acf_fields.php');


function my_acf_add_local_field_groups() {
    acf_add_local_field_group( array(
      'key' => 'group_661837eaae44c',
      'title' => 'Enheder',
      'fields' => array(
        array(
          'key' => 'field_661837ebea15e',
          'label' => 'Aldersgruppe',
          'name' => 'aldersgruppe',
          'aria-label' => '',
          'type' => 'text',
          'instructions' => '',
          'required' => 0,
          'conditional_logic' => 0,
          'wrapper' => array(
            'width' => '',
            'class' => '',
            'id' => '',
          ),
          'default_value' => '',
          'maxlength' => '',
          'placeholder' => '',
          'prepend' => '',
          'append' => '',
        ),
        array(
          'key' => 'field_66183824ea15f',
          'label' => 'Mødetidspunkt',
          'name' => 'modetidspunkt',
          'aria-label' => '',
          'type' => 'text',
          'instructions' => '',
          'required' => 0,
          'conditional_logic' => 0,
          'wrapper' => array(
            'width' => '',
            'class' => '',
            'id' => '',
          ),
          'default_value' => '',
          'maxlength' => '',
          'placeholder' => '',
          'prepend' => '',
          'append' => '',
        ),
        array(
          'key' => 'field_6618387706b30',
          'label' => 'Enheds billed',
          'name' => 'enheds_billed',
          'aria-label' => '',
          'type' => 'image',
          'instructions' => '',
          'required' => 0,
          'conditional_logic' => 0,
          'wrapper' => array(
            'width' => '',
            'class' => '',
            'id' => '',
          ),
          'return_format' => 'url',
          'library' => 'all',
          'min_width' => '',
          'min_height' => '',
          'min_size' => '',
          'max_width' => '',
          'max_height' => '',
          'max_size' => '',
          'mime_types' => '',
          'preview_size' => 'medium',
        ),
        array(
          'key' => 'field_661839273eb69',
          'label' => 'Billed kredit',
          'name' => 'enheds_billed_kredit',
          'aria-label' => '',
          'type' => 'text',
          'instructions' => '',
          'required' => 0,
          'conditional_logic' => 0,
          'wrapper' => array(
            'width' => '',
            'class' => '',
            'id' => '',
          ),
          'default_value' => '',
          'maxlength' => '',
          'placeholder' => '',
          'prepend' => '',
          'append' => '',
        ),
        array(
          'key' => 'field_66183839ea160',
          'label' => 'Enhedsleder',
          'name' => 'enhedsleder',
          'aria-label' => '',
          'type' => 'text',
          'instructions' => '',
          'required' => 0,
          'conditional_logic' => 0,
          'wrapper' => array(
            'width' => '',
            'class' => '',
            'id' => '',
          ),
          'default_value' => '',
          'maxlength' => '',
          'placeholder' => '',
          'prepend' => '',
          'append' => '',
        ),
        array(
          'key' => 'field_66183845ea161',
          'label' => 'Enhedsleder mail',
          'name' => 'enhedsleder_mail',
          'aria-label' => '',
          'type' => 'text',
          'instructions' => '',
          'required' => 0,
          'conditional_logic' => 0,
          'wrapper' => array(
            'width' => '',
            'class' => '',
            'id' => '',
          ),
          'default_value' => '',
          'maxlength' => '',
          'placeholder' => '',
          'prepend' => '',
          'append' => '',
        ),
      ),
      'location' => array(
        array(
          array(
            'param' => 'post_type',
            'operator' => '==',
            'value' => 'enheder',
          ),
        ),
      ),
      'menu_order' => 0,
      'position' => 'normal',
      'style' => 'default',
      'label_placement' => 'top',
      'instruction_placement' => 'label',
      'hide_on_screen' => '',
      'active' => true,
      'description' => '',
      'show_in_rest' => 0,
    ) );

      acf_add_local_field_group( array(
      'key' => 'group_661835bc5e2a4',
      'title' => 'Forside',
      'fields' => array(
        array(
          'key' => 'field_661835bd65f7e',
          'label' => 'Herospot titel',
          'name' => 'herospot_title',
          'aria-label' => '',
          'type' => 'wysiwyg',
          'instructions' => '',
          'required' => 0,
          'conditional_logic' => 0,
          'wrapper' => array(
            'width' => '',
            'class' => '',
            'id' => '',
          ),
          'default_value' => '',
          'tabs' => 'all',
          'toolbar' => 'full',
          'media_upload' => 0,
          'delay' => 0,
        ),
        array(
          'key' => 'field_6618363045b11',
          'label' => 'Herospot tekst',
          'name' => 'herospot_tekst',
          'aria-label' => '',
          'type' => 'text',
          'instructions' => '',
          'required' => 0,
          'conditional_logic' => 0,
          'wrapper' => array(
            'width' => '',
            'class' => '',
            'id' => '',
          ),
          'default_value' => '',
          'maxlength' => '',
          'placeholder' => '',
          'prepend' => '',
          'append' => '',
        ),
      ),
      'location' => array(
        array(
          array(
            'param' => 'page_template',
            'operator' => '==',
            'value' => 'templates/forside.php',
          ),
        ),
      ),
      'menu_order' => 0,
      'position' => 'normal',
      'style' => 'default',
      'label_placement' => 'top',
      'instruction_placement' => 'label',
      'hide_on_screen' => '',
      'active' => false,
      'description' => '',
      'show_in_rest' => 0,
    ) );

      acf_add_local_field_group( array(
      'key' => 'group_66280745cb441',
      'title' => 'Nyheder',
      'fields' => array(
        array(
          'key' => 'field_662807464883d',
          'label' => 'Forside teaser',
          'name' => 'forside_teaser',
          'aria-label' => '',
          'type' => 'text',
          'instructions' => '',
          'required' => 0,
          'conditional_logic' => 0,
          'wrapper' => array(
            'width' => '',
            'class' => '',
            'id' => '',
          ),
          'default_value' => '',
          'maxlength' => '',
          'placeholder' => '',
          'prepend' => '',
          'append' => '',
        ),
      ),
      'location' => array(
        array(
          array(
            'param' => 'post_type',
            'operator' => '==',
            'value' => 'post',
          ),
        ),
      ),
      'menu_order' => 0,
      'position' => 'normal',
      'style' => 'default',
      'label_placement' => 'top',
      'instruction_placement' => 'label',
      'hide_on_screen' => '',
      'active' => true,
      'description' => '',
      'show_in_rest' => 0,
    ) );   
}

add_action('acf/register_fields', 'my_acf_add_local_field_groups');




// REMOVE COMMENTS
add_action('admin_init', function () {
    // Redirect any user trying to access comments page
    global $pagenow;
     
    if ($pagenow === 'edit-comments.php') {
        wp_safe_redirect(admin_url());
        exit;
    }
 
    // Remove comments metabox from dashboard
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
 
    // Disable support for comments and trackbacks in post types
    foreach (get_post_types() as $post_type) {
        if (post_type_supports($post_type, 'comments')) {
            remove_post_type_support($post_type, 'comments');
            remove_post_type_support($post_type, 'trackbacks');
        }
    }
});
 
// Close comments on the front-end
add_filter('comments_open', '__return_false', 20, 2);
add_filter('pings_open', '__return_false', 20, 2);
 
// Hide existing comments
add_filter('comments_array', '__return_empty_array', 10, 2);
 
// Remove comments page in menu
add_action('admin_menu', function () {
    remove_menu_page('edit-comments.php');
});
 
// Remove comments links from admin bar
add_action('init', function () {
    if (is_admin_bar_showing()) {
        remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
    }
});