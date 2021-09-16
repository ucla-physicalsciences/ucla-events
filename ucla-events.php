<?php
/**
 * Plugin Name: UCLA AOS Events
 * Description: This plugin will help to create CPT for the events object
 * Author: Yasmine Khadija Talby
 * Version: 0.1.0
 */

if (!defined('ABSPATH')){
        exit;
}

define('EV_DOMAIN','ucla-events');

/*CPT*/

function ucla_events(){
        $labels= array(
                'name'=>__('Events','EV_DOMAIN'),
                'singular_name'=>__('Event','EV_DOMAIN'),
                'add_new'=>__('Add New Event','EV_DOMAIN'),
                'edit_item'=>__('Edit Event','EV_DOMAIN'),
                'new_item'=>__('New Event','EV_DOMAIN'),
                'view_item'=>__('View Event','EV_DOMAIN'),
                'view_items'=>__('View Events','EV_DOMAIN'),
                'search_items'=>__('Search Events','EV_DOMAIN'),
                'not_found'=>__('No Events found.','EV_DOMAIN'),
                'not_found_in_trash'=>__('No Events found in trash.','EV_DOMAIN'),
                'all_items'=>__('All Events','EV_DOMAIN'),
                'menu_name'=>__('Events','EV_DOMAIN'),
        );

        //set options for CPT

        $args = array(
                'description'=>__('Departemental Events','PUB_DOMAIN'),
                'labels'=>$labels,
                'supports'=> array('title','thumbnail', 'editor', 'author','custom-fields',), //define core features the post type supports
                'taxonomies'=> array('fields'), //taxonomy identifiers that will be registered for the post type
                'hierarchical'=>false, //this CPT is handled like a post
                'public'=> true ,//allow us to publish
                'show_in_rest' => false,//block editor?
                'has_archive'=> true,
                'menu_icon' => 'dashicons-tickets' //set the menu icon
        );
        register_post_type('events', $args);

}

add_action('init','ucla_events',0);

/*CF*/
function add_events_meta_boxes(){
	 add_meta_box("events-metadata", "Event Details", "events_metabox", "events", "side", "low");
}
add_action('admin_init','add_events_meta_boxes');

function save_events_details(){
	global $post;
	if (defined('DOING_AUTOSAVE')&& DOING_AUTOSAVE){return;}
	update_post_meta($post->ID, "event_location",sanitize_text_field($_POST["event_location"]));
	update_post_meta($post->ID, "event_institution",sanitize_text_field($_POST["event_institution"]));
	update_post_meta($post->ID, "event_speaker",sanitize_text_field($_POST["event_speaker"]));
update_post_meta($post->ID, "event_time",sanitize_text_field($_POST["event_time"]));
//update_post_meta($post->ID, "event_date",sanitize_text_field($_POST["event_date"]));
}

add_action('save_post','save_events_details');

function events_metabox() {
        global $post;
        $custom = get_post_custom($post->ID);//retrieve post meta fields based on post ID
echo "<label for=\"username\">Location : </label><br>";
	$field_data_event_location = $custom["event_location"][0]; //grab data from "event_location"
	echo "<input type=\"text\" name=\"event_location\" value=\"".$field_data_event_location."\" placeholder=\"Event Location\"><br>";
	echo "<label for=\"username\">Institution : </label><br>";
	$field_data_event_institution = $custom["event_institution"][0]; //grab data from "event_institution"
	echo "<input type=\"text\" name=\"event_institution\" value=\"".$field_data_event_institution."\" placeholder=\"Event Institution\"><br>";
	echo "<label for=\"username\">Speaker : </label><br>";
$field_data_event_speaker = $custom["event_speaker"][0]; //grab data from "event_speaker"
        echo "<input type=\"text\" name=\"event_speaker\" value=\"".$field_data_event_speaker."\" placeholder=\"Event Speaker\"><br>";
//DATE AND TIME//
echo "<label for=\"username\">Date and Time: </label><br>";

}
/*Taxonomy*/

add_action('init', 'events_taxonomy',0);

function events_taxonomy(){
	//Labels for the GUI

	$labels = array (
		'name'=>__('Event Types', 'EV_DOMAIN'),
		'singular_name' =>__('Event Type', 'EV_DOMAIN'),
		'search_items' =>  __( 'Search Event Types', 'EV_DOMAIN'),
	);
	register_taxonomy('events_type','events',array(
		'hierarchical' => true, //category taxonomy
    'labels' => $labels,
    'show_ui' => true,
    'show_in_rest' => true,
    'show_admin_column' => true,
    'update_count_callback' => '_update_post_term_count',
    'query_var' => true,
    'rewrite' => array( 'slug' => 'events-type'),
    ));
}


/*Template*/


function event_template($template){
        global $post;
        if ('events' === $post->post_type){
                return plugin_dir_path( __FILE__ ) . 'single-event.php';
        }
        return $template;
}
add_filter('single_template','event_template');
