<?php
/*
 Plugin Name: Services
 Plugin URI: https://www.devdot.co.uk
 Description: A post type to display my services
 Version: 1.0
 Author: Ben Andrews
 Author URI: https://www.devdot.co.uk/about
 Text Domain: services
*/

//Security to prevent direct access of php files

if(! defined('ABSPATH')) {
  exit;
}

function create_services_cpt(){
  $labels = array(
    'name' => __('Services', 'Post Type General Name', 'services'),
    'singular_name' => __('Service', 'Post Type Singular name', 'service'),
    'menu_name' => __('Services', 'services'),
    'name_admin_bar' => __('Services', 'services'),
    'archives' => __('Service Archives', 'services'),
    'all_items' => __('All Items', 'services'),
    'add_new_item' => __('Add New Service', 'services'),
    'add_new' => __('Add New', 'services'),
    'new_item' => __('New Service', 'services'),
    'edit_item' => __('Edit Service', 'services'),
    'update_item' => __('Update Service', 'services'),
    'view_item' => __('View Service', 'services'),
    'view_items' => __('View Services', 'services'),
    'search_items' => __('Search Services', 'services'),
    'not_found' => __('Not Found', 'services'),
    'not_found_in_trash' => __('Not Found In Trash', 'services'),
    'featured_image' => __('Featured Image', 'services'),
    'set_featured_image' => __('Set Featured Image', 'services'),
    'remove_featured_image' => __('Remove Set Featured Image', 'services'),
    'use_featured_image' => __('Use Set Featured Image', 'services'),
    'insert_into_item' => __('Insert Into Services', 'services'),
    'uploaded_to_this_item' => __('Uploaded To This Item', 'services'),
    'items_list' => __('Services List', 'services'),
    'item_list_navigation' => __('Services List Navigation', 'services'),
    'filter_items_list' => __('Filter Services List', 'services'),
  );

  $args = array(
    'label' => __('Services',  'services'),
    'description'  => __('Services Custom Post Type', 'services'),
    'labels' => $labels,
    'menu_icon' => 'dashicons-format-aside',
    'supports' => array('title', 'editor', 'thumbnail'),
    'taxonomies' => array('category', 'post_tag'),
    'public' => true,
    'show_ui' => true,
    'show_in_menu' => true,
    'show_in_admin_bar' => true,
    'show_in_nav_menus' => true,
    'can_export' => true,
    'has_archives' => true,
    'hierarchical' => false,
    'exclude_from_search' => false,
    'show_in_rest' => true,
    'publicly_queryable' => true,
    'capability_type' => 'post',
    'rewrite' => array('slug' => 'services'),
    );

    register_post_type('services', $args);
}

add_action('init','create_services_cpt', 0);


// Action to add the meta box we are defining
add_action( 'add_meta_boxes_services', "services_details_add_meta_box" );

/*
 * Routine to add a meta box.  Called via a filter hook once WordPress is initialized
 */
function services_details_add_meta_box(){
    add_meta_box(
        "services_details_meta_box",  // An ID for the Meta Box.  Make it unique to your plugin
        __( "Services Extra Details", 'services' ),  // The title for your Meta Box
        "services_details_meta_box_render",  // A callback function to fill the Meta Box with the desired UI in the editor
        "services",  // The screen name - in this case the name of our custom post type
        "normal"  // The context or placement for the meta box.  Choose "normal", "side" or "advanced"
    );
}

/*
 * Routine to display a custom meta box editor
 * Note: In this example our custom meta data is saved as a row in the postmeta database table.
 * $post PostObject An object representing a WordPress post that is currently being loaded in the post editor.
 */
function services_details_meta_box_render( $post ){

    // Get the fa code stored in the meta data filed
    $code = get_post_meta( $post->ID, "facode", true );
    echo '<div><p>Enter the Fa-Code from Font Awsome 4 Here...</p><input type="text" class="widefat" name="facode" value="'.$code.'" placeholder="facode" /></div>';
}

// Hook into the save routine for posts
add_action( 'save_post', 'services_details_meta_box_save');

/*
 * Routine to save the custom post meta data from the editor
 * Note: We retrieve the form data through the PHP Global $_POST
 * $post_id int The ID of the post being saved
 */
function services_details_meta_box_save( $post_id ){



    // Check to see if this is our custom post type (remove this check if applying the meta box globally)
    if( $_POST['post_type'] == "services"){

        // Retrieve the values from the form
        $code = $_POST['facode'];

        // Clean, sanitize and validate the input as appropriate

        // Save the updated data into the custom post meta database table
        update_post_meta( $post_id, "facode", $code );

    }
}
?>
