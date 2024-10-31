<?php
/*
 * Plugin Name: Testimonials by Archon
 * Plugin URI: http://archonweb.com/testimonials-by-archon/
 * Description: Provides both widgets and shortcodes to help you display and manage your testimonials across your site.
 * Version: 1.0
 * Author: Cody Greene
 * Author URI: https://github.com/toymakercody
 * License: GPL2
 *
 */

/*
 * Assign global variables
 */
$plugin_url = WP_PLUGIN_URL . '/testimonials-by-archon.php';
$plugin_table = 'testimonials_by_archon';


/*
 * Check for add a new testimonial input
 */
if(isset($_POST['testimonial_content']) && isset($_POST['testimonial_author'])){
	global $wpdb;
	$content = $_POST['testimonial_content'];
	$author = $_POST['testimonial_author'];
	$table = $wpdb->base_prefix . 'testimonials_by_archon';
	$wpdb->insert($table, array('content' => $content,'author' => $author));
}

/*
 * Check for an update to testimonial input
 */
if(isset($_POST['testimonial_content_edit']) && isset($_POST['testimonial_author_edit']) && isset($_POST['testimonial_id'])){
	global $wpdb;
	$content = $_POST['testimonial_content_edit'];
	$author = $_POST['testimonial_author_edit'];
	$id = $_POST['testimonial_id'];
	$table = $wpdb->base_prefix . 'testimonials_by_archon';
	
	$wpdb->update( $table, array('content' => $content, 'author' => $author), array('id' => $id), array('%s','%s') );
}

/*
 * create the database table needed for plugin when plugin is activated
 */
function tba_create_table(){
	global $wpdb;
	$table_name = $wpdb->base_prefix . 'testimonials_by_archon';
	$sql = "CREATE TABLE $table_name (
		id int(11) NOT NULL AUTO_INCREMENT,
		content text(255) DEFAULT NULL,
		author varchar(255) DEFAULT NULL,
		UNIQUE KEY id (id)
	);";
	$wpdb->query($sql);
}
register_activation_hook(__FILE__, 'tba_create_table');

/*
 * delete the database table needed for plugin when plugin is deactivated
 */
function tba_delete_table(){
	global $wpdb;
	$table_name = $wpdb->base_prefix . 'testimonials_by_archon';
	$sql = "DROP TABLE $table_name";
	$wpdb->query($sql);
}
register_deactivation_hook(__FILE__, 'tba_delete_table');


/*
 * Add a link to our plugin in the admin menu
 * under 'Settings > Testimonials by Archon'
 */
function testimonials_by_archon_menu(){
	/*
	 * Use the add_options_page function
	 * add_options_page($page_title, $menu_title, $capability, $menu_slug, $function);
	 */
	add_options_page(
		'Testimonials by Archon Plugin',
		'Testimonials by Archon',
		'manage_options',
		'testimonials_by_archon',
		'testimonials_by_archon_options_page'
	);
}
add_action('admin_menu', 'testimonials_by_archon_menu');

/*
 * Check if the user can manage plugin options
 */
function testimonials_by_archon_options_page(){
	if(!current_user_can('manage_options')){
		wp_die('You do not have sufficient permissions to access this page.');
	}
	require('inc/options-page-wrapper.php');
}

/*
 * get testimonials by shortcode
 */
function testimonial_by_archon_shortcode( $atts ) {
	global $wpdb;
	global $plugin_table;
	$table_name = $wpdb->prefix . $plugin_table;

    $a = shortcode_atts( array(
        'id' => null,
    ), $atts );
    if($a['id'] == null){
    	$row = $wpdb->get_row('SELECT * FROM ' . $table_name . ' ORDER BY id DESC limit 1');
    }elseif($a['id'] == 'random'){
		$row_count = $wpdb->get_results( 'SELECT COUNT(*) FROM ' . $table_name, ARRAY_N);
		$randomid = rand(1, $row_count[0][0]);/*need to see if there is a better way then double array to get data back*/
		$row = $wpdb->get_row( $wpdb->prepare('SELECT * FROM ' . $table_name . ' WHERE id = %d', $randomid) );
	}else{
    	$id = $a['id'];
		$row = $wpdb->get_row( $wpdb->prepare('SELECT * FROM ' . $table_name . ' WHERE id = %d', $id) );
    }
    
	$htmlString = null;
	$htmlString .= '<blockquote class="testimonial"><p>' . $row->content . '</p></blockquote>';
	$htmlString .= '<p class="testimonial-author">' . $row->author . '</p>';
	return $htmlString;

}
add_shortcode( 'testimonial', 'testimonial_by_archon_shortcode' );

/*
 * Add the style sheet to all front facing pages and to the admin backend
 */
function add_stylesheet_to_all_other_places() {
	wp_enqueue_style( 'style-name', plugins_url('css/main.css', __FILE__) );
}
add_action( 'wp_enqueue_scripts', 'add_stylesheet_to_all_other_places' );

function add_stylesheet_to_admin() {
	wp_enqueue_style( 'prefix-style', plugins_url('css/main.css', __FILE__) );
}
add_action( 'admin_enqueue_scripts', 'add_stylesheet_to_admin' );

/*
 * Add the javascript to the admin options page only
 */
function add_javascript_to_admin($hook) {
	if ( 'settings_page_testimonials_by_archon' != $hook ) {
		return;
	}
	wp_enqueue_script('jquery');
	wp_enqueue_script( 'my_custom_script', plugin_dir_url( __FILE__ ) . '/js/main.js' );
}
add_action('admin_enqueue_scripts', 'add_javascript_to_admin');

?>