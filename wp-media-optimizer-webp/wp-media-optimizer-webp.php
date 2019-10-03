<?php
/**
* Plugin Name: WP Media Optimizer (.webp)
* Plugin URI: http://www.francescosganga.it/wordpress/plugin/wp-media-optimizer-webp/
* Description: Convert your media images to .webp for increase performances
* Version: 1.0
* Author: Francesco Sganga
* Author URI: http://www.francescosganga.it/
**/

function wpmowebp_assets() {
	wp_enqueue_style("eap", plugin_dir_url(__FILE__) . "assets/style.css");
}

add_action('wp_enqueue_scripts', 'wpmowebp_assets');

add_action("admin_enqueue_scripts", "wpmowebp_admin_assets");

function wpmowebp_init() {
	register_setting('wpmowebp-options', 'wpmowebp-test', array(
		'type' => 'string', 
		'sanitize_callback' => 'sanitize_text_field',
		'default' => "it"
	));

}
add_action('admin_init', 'wpmowebp_init');

function wpmowebp_options_panel(){
	add_menu_page('WP Media Optimizer', 'WP Media Optimizer', 'manage_options', 'wpmowebp-options', 'wpmowebp_options_settings');
	add_submenu_page('wpmowebp-options', 'About', 'About', 'manage_options', 'wpmowebp-option-about', 'wpmowebp_options_about');
}
add_action('admin_menu', 'wpmowebp_options_panel');

function wpmowebp_options_settings(){
	wp_enqueue_script("wpmowebp-admin", plugin_dir_url(__FILE__) . "assets/admin-main.js", array(), "1.0.0", true);
	?>
	<div class="wrap">
		<h1>WP Media Optimizer (.webp)</h1>
		<h2>Settings Section</h2>
		<form method="post" action="options.php">
		<?php settings_fields('wpmowebp-options'); ?>
		<?php do_settings_sections('wpmowebp-options'); ?>
		<table class="form-table">
			<tr valign="top">
				<th scope="row">Test</th>
				<td>
					<input type="text" name="wpmowebp-test" value="<?php echo get_option('wpmowebp-test'); ?>" />
				</td>
			</tr>
		</table>
		<?php submit_button(); ?>
		</form>
		<hr />
		<h2>How to use</h2>
	</div>
	<?php
}

function wpmowebp_options_about(){
	?>
	<h1>About</h1>
	<h2>Under Construction</h2>
	<?php
}

function wpmwebp_imagetowebp() {
    if(isset($_GET['image'])) {
        $image = $_GET['image'];
        $extension = pathinfo($image, PATHINFO_EXTENSION);
        switch($extension) {
            case "jpg":
                header("Content-Type: image/webp");
                print imagewebp(imagecreatefromjpeg($image));
                die();
                break;
                
            case "png":
                header("Content-Type: image/webp");
                print imagewebp(imagecreatefrompng($image));
                die();
                break;
        }
    }
}

add_action('init', 'wpmwebp_imagetowebp');

function filter_content($content) {
    $content = preg_replace_callback("/https:\/\/www.wrappingtorino.it\/(.*?).(?:jpg|png)/", function($matches) {
        //print_r($matches);
        return home_url() . "/?image={$matches[1]}.jpg";
    }, $content);
    
    return $content;
}
ob_start("filter_content");